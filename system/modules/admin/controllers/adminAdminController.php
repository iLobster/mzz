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
 * @version 0.1.4
 */

class adminAdminController extends simpleController
{
    public function getView()
    {
        $section = $this->request->get('section_name', 'string');
        $module = $this->request->get('module_name', 'string');

        $user = $this->toolkit->getUser();

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $menu = $adminMapper->getAdminInfo();
        unset($menu['admin'], $menu['access']);
        $this->smarty->assign('admin_menu', $menu);

        $this->smarty->assign('current_section', $section);
        $this->smarty->assign('current_module', $module);

        if (is_null($module) && is_null($section)) {
            $module = $this->request->get('name', 'string');
            if (is_null($module)) {
                return $this->smarty->fetch('admin/main.tpl');
            }

            // если указан лишь модуль, и этот модуль находится лишь в одной секции - отображаем её
            if (isset($menu[$module]['sections']) && sizeof($menu[$module]['sections']) == 1) {
                $section = key($menu[$module]['sections']);
                $this->request->setParam('section_name', $section);
                $this->request->setParam('module_name', $module);

                $this->smarty->assign('current_section', $section);
                $this->smarty->assign('current_module', $module);
            }
        }

        if (isset($menu[$module]['sections'][$section])) {
            $class = $adminMapper->getMainClass($module);

            $obj_id = $this->toolkit->getObjectId('access_' . $section . '_' . $class);

            $mapper = $this->toolkit->getMapper($module, $class, $section);

            $mapper->register($obj_id, 'sys', 'access');
            $acl = new acl($user, $obj_id);

            $access = $acl->get('admin');

            if ($access) {
                return $this->smarty->fetch('admin/admin.tpl');
            }

            fileLoader::load('simple/simple403Controller');
            $controller = new simple403Controller();
            return $controller->run();
        }

        if (isset($menu[$module])) {
            return $this->smarty->fetch('admin/noSection.tpl');
        } else {
            return $this->smarty->fetch('admin/noModule.tpl');
        }
    }
}

?>