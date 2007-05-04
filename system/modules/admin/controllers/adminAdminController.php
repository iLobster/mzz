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
 * @version 0.1.3
 */

class adminAdminController extends simpleController
{
    public function getView()
    {
        $section = $this->request->get('section_name', 'string', SC_PATH);
        $module = $this->request->get('module_name', 'string', SC_PATH);

        $user = $this->toolkit->getUser();

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $menu = $adminMapper->getAdminInfo();
        $this->smarty->assign('current_section', $section);
        $this->smarty->assign('current_module', $module);
        unset($menu['admin'], $menu['access']);
        $this->smarty->assign('menu', $menu);

        if (isset($menu[$module]['sections'][$section])) {
            $class = $adminMapper->getMainClass($module);

            $obj_id = $this->toolkit->getObjectId('access_' . $section . '_' . $class);

            $mapper = $this->toolkit->getMapper($module, $class, $section);

            $mapper->register($obj_id, 'sys', 'access');
            $acl = new acl($user, $obj_id);

            $access = $acl->get('admin');

        /**
         * @todo подумать над тем, что должно быть в случае 403 здесь
         */
            if ($access) {
                //$adminMapper = $this->toolkit->getMapper('admin', 'admin');


                return $this->smarty->fetch('admin/admin.tpl');
            }

            return 'нет доступа';
        }

        return 'Запрашиваемого вами модуля не существует';
    }
}

?>