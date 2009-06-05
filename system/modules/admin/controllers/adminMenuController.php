<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * adminMenuController: контроллер для метода menu модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminMenuController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $menu = array();
        foreach ($adminMapper->getModules() as $moduleName => $module) {
            $actions = $this->toolkit->getAction($moduleName)->getActions(array('admin' => true));

            $obj_id = $this->toolkit->getObjectId('access_' . $moduleName);
            $acl = new acl($this->toolkit->getUser());

            foreach ($actions as $className => $action) {
                $acl->register($obj_id, $className);
                $acl = new acl($this->toolkit->getUser(), $obj_id);

                foreach ($action as $actionName => $options) {
                    if ($acl->get($actionName)) {
                        if (!isset($menu[$moduleName])) {
                            $menu[$moduleName] = array();
                            $menu[$moduleName]['actions'] = array();
                            $menu[$moduleName]['title'] = $module;
                        }
                        $menu[$moduleName]['actions'][$actionName] = $options;
                    }
                }
            }
        }

        $module = $this->request->getString('module_name');
        $action = $this->request->getString('action_name');

        if (is_null($action) && is_null($module)) {
            $module = 'admin';
            $action = $this->request->getRequestedAction();
        }

        $this->smarty->assign('current_module', $module);
        $this->smarty->assign('current_action', $action);
        $this->smarty->assign('menu', $menu);
        return $this->smarty->fetch('admin/menu.tpl');
    }
}

?>