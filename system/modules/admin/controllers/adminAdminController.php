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
 * adminAdminController: контроллер для метода admin модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.5
 */
class adminAdminController extends simpleController
{
    protected function getView()
    {
        $moduleName = $this->request->getString('module_name');
        $actionName = $this->request->getString('action_name');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        if (is_null($moduleName)) {
            $moduleName = 'admin';

            if (is_null($actionName)) {
                $actionName = 'admin';
            }
        }

        if ($moduleName == 'admin' && in_array($actionName, array(
            'dashboard',
            'admin'))) {
            return $this->mainAdminPage();
        }

        $module = $this->toolkit->getModule($moduleName);

        try {
            $action = $module->getAction($actionName);

            if (!$action->canRun()) {
                return $this->forward('admin', '403');
            }

            return $this->forward($moduleName, $actionName);
        } catch (mzzUnknownModuleActionException $e) {
            $this->smarty->assign('module', $moduleName);
            return $this->smarty->fetch('admin/404.tpl');
        }
    }

    protected function mainAdminPage()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $dashboard = array();
        foreach ($adminMapper->getModules() as $moduleName => $module) {
            foreach ($module->getActions() as $action) {
                if ($action->isDashboard()) {
                    $dashboard[] = $action;
                }
            }
        }

        $this->smarty->assign('dashboard', $dashboard);
        return $this->smarty->fetch('admin/main.tpl');
    }
}

?>