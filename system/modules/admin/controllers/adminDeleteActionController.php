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
fileLoader::load('codegenerator/fileIniTransformer');

/**
 * adminDeleteActionController: контроллер для метода deleteAction модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.2
 */
class adminDeleteActionController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $adminGeneratorMapper = $this->toolkit->getMapper('admin', 'adminGenerator');

        $module_name = $this->request->getString('module_name');
        try {
            $module = $this->toolkit->getModule($module_name);
        } catch (mzzModuleNotFoundException $e) {
            return $this->forward404($adminMapper);
        }

        $action_name = $this->request->getString('class_name');
        try {
            $actionObject = $module->getAction($action_name);
        } catch (mzzUnknownModuleActionException $e) {
            return $this->forward404($adminMapper);
        }

        $class_name = $actionObject->getClassName();

        $dests = $adminGeneratorMapper->getDests(true, $module->getName());

        if (!sizeof($dests)) {
            $controller = new messageController($this->getAction(), i18n::getMessage('error.write_denied', 'admin'), messageController::WARNING);
            return $controller->run();
        }

        $dest = current($dests);

        try {
            $adminGeneratorMapper->deleteAction($module, $actionObject, $dest);
        } catch (Exception $e) {
            return $e->getMessage();
            //$controller = new messageController($this->getAction(), $e->getMessage(), messageController::WARNING);
            //return $controller->run();
        }

        return jipTools::closeWindow();
    }

    private function cleanAcl($module, $class, $action_id)
    {
        $mapper = $this->toolkit->getMapper($module['name'], $class['name']);
        if ($mapper->isAttached('acl_ext') || $mapper->isAttached('acl_simple')) {
            $acl = new acl();
            $acl->deleteAction($class['id'], $action_id);
        }
    }

}

?>