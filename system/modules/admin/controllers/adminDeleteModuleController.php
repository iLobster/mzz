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

fileLoader::load('codegenerator/directoryGenerator');

/**
 * adminDeleteModuleController: контроллер для метода deleteModule модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.2
 */

class adminDeleteModuleController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $adminGeneratorMapper = $this->toolkit->getMapper('admin', 'adminGenerator');
        $modules = $adminMapper->getModulesList();

        if (!isset($modules[$id])) {
            $controller = new messageController(i18n::getMessage('module.error.not_exists', 'admin'), messageController::WARNING);
            return $controller->run();
        }

        if (sizeof($modules[$id]['classes'])) {
            $controller = new messageController(i18n::getMessage('module.error.cannot_delete', 'admin'), messageController::WARNING);
            return $controller->run();
        }

        $dest = current($adminGeneratorMapper->getDests(true, $modules[$id]['name']));
        $dest = pathinfo($dest, PATHINFO_DIRNAME);

        $generator = new directoryGenerator($dest);
        try {
            $generator->delete($modules[$id]['name'], array('recursive', 'skip'));
            $generator->run();
        } catch (Exception $e) {
            $controller = new messageController($e->getMessage(), messageController::WARNING);
            return $controller->run();
        }

        $adminGeneratorMapper->deleteModule($id);

        return jipTools::redirect();
    }
}

?>