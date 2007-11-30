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
 * adminDevToolbarController: контроллер для метода devToolbar модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.1
 */
class adminDevToolbarController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $info = $adminMapper->getInfo();
        $modules = $adminMapper->getModulesList();
        $sections = $adminMapper->getSectionsList();
        $latestObjects = $adminMapper->getLatestRegisteredObj();

        $access = array();

        foreach ($info['data'] as $key => $module) {
            foreach ($module as $section => $classes) {
                foreach ($classes as $class) {
                    $name = $section . '_' . $class['class'];
                    $access[$name] = $class;
                    $access[$name]['admin'] = $info['admin'][$name];
                }
            }
        }

        $this->smarty->assign('access', $access);
        $this->smarty->assign('modules', $modules);
        $this->smarty->assign('sections', $sections);
        $this->smarty->assign('latestObjects', $latestObjects);
        return $this->smarty->fetch('admin/devToolbar.tpl');
    }
}

?>