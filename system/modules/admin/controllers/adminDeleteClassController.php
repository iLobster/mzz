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
 * @version 0.3
 */
class adminDeleteClassController extends simpleController
{
    protected function getView()
    {
        $adminGeneratorMapper = $this->toolkit->getMapper('admin', 'adminGenerator');

        $module_name = $this->request->getString('module_name');
        try {
            $module = $this->toolkit->getModule($module_name);
        } catch (mzzModuleNotFoundException $e) {
            return $this->forward404($adminMapper);
        }

        $classes = $module->getClasses();
        $class_name = $this->request->getString('class_name');

        if (!in_array($class_name, $classes)) {
            return $this->forward404($adminMapper);
        }

        $dest = current($adminGeneratorMapper->getDests(true, $module_name));

        try {
            $adminGeneratorMapper->deleteClass($module, $class_name, $dest);
        } catch (Exception $e) {
            return $e->getMessage();
            $controller = new messageController($this->getAction(), $e->getMessage(), messageController::WARNING);
            return $controller->run();
        }

        return jipTools::redirect();
    }
}
?>