<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('codegenerator/classGenerator');

/**
 * adminDeleteClassController: контроллер для метода deleteClass модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.2
 */

class adminDeleteClassController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $modules = $adminMapper->getModulesList();

        /*$not_found = true;
        foreach ($modules as $val) {
            if (isset($val['classes'][$id])) {
                if ($val['classes'][$id]['exists']) {
                    $controller = new messageController('Нельзя удалить класс', messageController::WARNING);
                    return $controller->run();
                } else {
                    $not_found = false;
                }
            }
        }*/

        $class = $adminMapper->searchClassById($id);

        if (!$class) {
            $controller = new messageController('Класса не существует', messageController::WARNING);
            return $controller->run();
        }

        $db = DB::factory();

        $data = $db->getRow('SELECT * FROM `sys_classes` WHERE `id` = ' . $id);

        if ($modules[$data['module_id']]['main_class'] == $data['id']) {
            if (sizeof($modules[$data['module_id']]['classes']) > 1) {
                $controller = new messageController('Нельзя удалить класс, он является главным для этого модуля', messageController::WARNING);
                return $controller->run();
            } else {
                $stmt = $db->prepare('UPDATE `sys_modules` SET `main_class` = NULL WHERE `id` = :id');
                $stmt->bindValue(':id', $data['module_id'], PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        $const = DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR;
        $moduleName = $modules[$data['module_id']]['name'];

        $dest = (file_exists(systemConfig::$pathToApplication . $const . $moduleName)) ? systemConfig::$pathToApplication : systemConfig::$pathToSystem;

        $classGenerator = new classGenerator($moduleName, $dest . $const);
        $classGenerator->delete($data['name']);

        $db->query('DELETE FROM `sys_classes` WHERE `id` = ' .$id);

        $url = new url('default2');
        $url->setAction('devToolbar');
        return jipTools::redirect($url->get());
    }
}

?>