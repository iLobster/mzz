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

        $user = $this->toolkit->getUser();

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $menu = $adminMapper->getMenu();
        $this->smarty->assign('admin_menu', $menu);

        $this->smarty->assign('current_module', $module);

        if (is_null($module) || $module == 'admin') {
            return $this->smarty->fetch('admin/main.tpl');
        }

        if (isset($menu[$module])) {
            $obj_id = $this->toolkit->getObjectId('access_' . $module);
            $adminMapper->register($obj_id, 'access');

            $user = $this->toolkit->getUser();
            $acl = new acl($user, $obj_id);

            if ($acl->get('admin')) {
                return $this->smarty->fetch('admin/admin.tpl');
            }

            fileLoader::load('simple/simple403Controller');
            $controller = new simple403Controller();
            return $controller->run();
        }

        return $this->smarty->fetch('admin/noModule.tpl');
    }
}

?>