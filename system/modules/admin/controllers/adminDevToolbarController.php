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
    public function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $modules = $adminMapper->getModulesList();
        $sections = $adminMapper->getSectionsList();
        $latestObjects = $adminMapper->getLatestRegisteredObj();

        $this->smarty->assign('modules', $modules);
        $this->smarty->assign('sections', $sections);
        $this->smarty->assign('latestObjects', $latestObjects);
        return $this->smarty->fetch('admin/devToolbar.tpl');
    }
}

?>