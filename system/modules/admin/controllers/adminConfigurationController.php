<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * adminConfigurationController: контроллер для метода configuration модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminConfigurationController extends simpleController
{
    protected function getView()
    {
        $section = $this->request->getString('section_name');
        $module = $this->request->getString('module_name');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $menu = $adminMapper->getMenu();
        $this->smarty->assign('admin_menu', $menu);



        $this->smarty->assign('current_section', $section);
        $this->smarty->assign('current_module', $module);



        $info = $adminMapper->getInfo();

        $this->smarty->assign('info', $info['data']);
        $this->smarty->assign('cfgAccess', $info['cfgAccess']);
        $this->smarty->assign('main_class', $info['main_class']);
        $this->smarty->assign('admin', $info['admin']);
        $this->smarty->assign('title', 'Панель управления');
        return $this->smarty->fetch('admin/configuration.tpl');
    }
}

?>