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
 * adminDeleteClassController: контроллер дл€ метода deleteClass модул€ admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.1
 */

class adminDeleteClassController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $modules = $adminMapper->getModulesList();

        $not_found = true;
        foreach ($modules as $val) {
            if (isset($val['classes'][$id])) {
                if ($val['classes'][$id]['exists']) {
                    $controller = new messageController('Ќельз€ удалить класс', messageController::WARNING);
                    return $controller->run();
                } else {
                    $not_found = false;
                }
            }
        }

        if ($not_found) {
            $controller = new messageController(' ласса не существует', messageController::WARNING);
            return $controller->run();
        }

        $db = DB::factory();

        $data = $db->getRow('SELECT * FROM `sys_classes` WHERE `id` = ' . $id);

        if ($modules[$data['module_id']]['main_class'] == $data['id']) {
            $controller = new messageController('Ќельз€ удалить класс, он €вл€етс€ главным дл€ этого модул€', messageController::WARNING);
            return $controller->run();
        }

        $const = DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR;
        $dest = (file_exists(systemConfig::$pathToApplication . $const . $data['name'])) ? systemConfig::$pathToApplication : systemConfig::$pathToSystem;

        $classGenerator = new classGenerator($modules[$data['module_id']]['name'], $dest . $const);
        $classGenerator->delete($data['name']);

        $db->query('DELETE FROM `sys_classes` WHERE `id` = ' .$id);

        $url = new url('default2');
        $url->setAction('devToolbar');
        return jipTools::redirect($url->get());
    }
}

?>