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
        $id = $this->request->getInteger('id');
        $action_name = $this->request->getString('action_name');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $adminGeneratorMapper = $this->toolkit->getMapper('admin', 'adminGenerator');

        $class = $adminMapper->searchClassById($id);

        if ($class === false) {
            $controller = new messageController(i18n::getMessage('class.error.not_exists', 'admin'), messageController::WARNING);
            return $controller->run();
        }

        $module = $adminMapper->searchModuleById($class['module_id']);

        $act = new action($module['name']);
        $actions = $act->getActions();

        if (!isset($actions[$class['name']][$action_name])) {
            $controller = new messageController(i18n::getMessage('action.error.not_exists', 'admin'), messageController::WARNING);
            return $controller->run();
        }

        $actionInfo = $actions[$class['name']][$action_name];

        $dest = current($adminGeneratorMapper->getDests(true, $module['name']));

        try {
            $fileGenerator = new fileGenerator($dest);

            $fileGenerator->edit($this->actions($class['name']), new fileIniTransformer('delete', $action_name));

            if ($action_name == $actionInfo['controller']) {
                $fileGenerator->delete($this->controllers($module['name'], $action_name));
                $fileGenerator->delete($this->templates($action_name));
            }

            $action_id = $adminGeneratorMapper->deleteAction($action_name, $class['id']);

            $this->cleanAcl($module, $class, $action_id);

            $fileGenerator->run();
        } catch (Exception $e) {
            $controller = new messageController($e->getMessage(), messageController::WARNING);
            return $controller->run();
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

    private function actions($name)
    {
        return 'actions/' . $name . '.ini';
    }

    private function templates($name)
    {
        return 'templates/' . $name . '.tpl';
    }

    private function controllers($module, $action)
    {
        return 'controllers/' . $module . ucfirst($action) . 'Controller.php';
    }
}

?>