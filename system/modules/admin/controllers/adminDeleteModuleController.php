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

fileLoader::load('codegenerator/moduleGenerator');

/**
 * adminDeleteModuleController: контроллер для метода deleteModule модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.1
 */
 
class adminDeleteModuleController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $modules = $adminMapper->getModulesList();

        if (!isset($modules[$id])) {
            $controller = new messageController('Модуля не существует', messageController::WARNING);
            return $controller->run();
        }

        if (sizeof($modules[$id]['classes'])) {
            $controller = new messageController('Нельзя удалить модуль', messageController::WARNING);
            return $controller->run();
        }

        $db = DB::factory();

        $const = DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR;
        $dest = (file_exists(systemConfig::$pathToApplication . $const . $modules[$id]['name'])) ? systemConfig::$pathToApplication : systemConfig::$pathToSystem;

        $moduleGenerator = new moduleGenerator($dest);
        $moduleGenerator->delete($modules[$id]['name']);

        $db->query('DELETE FROM `sys_modules` WHERE `id` = ' .$id);

        $url = new url('default2');
        $url->setAction('devToolbar');
        return jipTools::redirect($url->get());
    }
}

?>