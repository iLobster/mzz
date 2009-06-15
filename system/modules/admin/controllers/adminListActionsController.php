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

/**
 * adminListActionsController
 *
 * @package modules
 * @subpackage admin
 * @version 0.2
 */
class adminListActionsController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $adminGeneratorMapper = $this->toolkit->getMapper('admin', 'adminGenerator');

        $class = $adminMapper->searchClassById($id);

        if ($class === false) {
            $controller = new messageController(i18n::getMessage('class.error.not_exists', 'admin'), messageController::WARNING);
            return $controller->run();
        }

        $module = $adminMapper->searchModuleById($class['module_id']);

        $actions_db = $adminGeneratorMapper->getActions($id);

        $act = new action($module['name']);
        $actions_module = $act->getActions();
        $actions_class = $actions_module[$class['name']];

        $to_delete = array_diff($actions_db, array_keys($actions_class));
        $to_add = array_diff(array_keys($actions_class), $actions_db);

        foreach ($to_add as $action) {
            $adminGeneratorMapper->createAction($action, $class['id']);
        }

        foreach ($to_delete as $action) {
            $adminGeneratorMapper->deleteAction($action, $class['id']);
        }

        $this->smarty->assign('id', $id);
        $this->smarty->assign('actions', $actions_class);

        return $this->smarty->fetch('admin/listActions.tpl');
    }
}

?>