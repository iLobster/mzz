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
        $module = $this->request->getString('module_name');
        $action = $this->request->getString('action_name');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $modules = $adminMapper->getModules();

        if (is_null($module) || $module == 'admin') {
            return $this->mainAdminPage();
        }

        if (isset($modules[$module])) {
            return $this->forward($module, $action);
        }

        return $this->smarty->fetch('admin/noModule.tpl');
    }

    protected function mainAdminPage()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $dashboard_modules = array();
        foreach ($adminMapper->getModules() as $moduleName => $module) {
            $modules_actions = $this->toolkit->getAction($moduleName)->getActions();
            foreach ($modules_actions as $class_actions) {
                if (array_key_exists('dashboard', $class_actions)) {
                    $dashboard_modules[] = $moduleName;
                }
            }
        }

        $this->smarty->assign('dashboard_modules', $dashboard_modules);
        return $this->smarty->fetch('admin/main.tpl');
    }
}

?>