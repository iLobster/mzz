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

fileLoader::load('codegenerator/fileGenerator');

/**
 * adminDeleteClassController: контроллер для метода deleteClass модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.2
 */

class adminDeleteClassController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $adminGeneratorMapper = $this->toolkit->getMapper('admin', 'adminGenerator');

        $class = $adminMapper->searchClassById($id);

        if (!$class) {
            $controller = new messageController(i18n::getMessage('class.error.not_exists', 'admin'), messageController::WARNING);
            return $controller->run();
        }

        $module = $adminMapper->searchModuleById($class['module_id']);
        $module_name = $module['name'];
        $class_name = $class['name'];

        $dest = current($adminGeneratorMapper->getDests(true, $module_name));

        $generator = new fileGenerator($dest);
        try {
            $generator->delete('actions/' . $class_name . '.ini');
            $generator->delete('mappers/' . $class_name . 'Mapper.php');
            $generator->delete($class_name . '.php');

            $generator->run();
        } catch (Exception $e) {
            $controller = new messageController($e->getMessage(), messageController::WARNING);
            return $controller->run();
        }

        $adminGeneratorMapper->deleteClass($id);

        return jipTools::redirect();
    }
}

?>