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

        $info = $adminMapper->getModules();

        $hiddenClasses = array_flip(explode(',', $this->request->getString('mzz-devToolbarH', SC_COOKIE)));

        $this->smarty->assign('modules', $info);
        $this->smarty->assign('sections', array());
        $this->smarty->assign('hiddenClasses', $hiddenClasses);
        //$this->smarty->assign('latestObjects', $adminMapper->getLatestRegisteredObj());
        return $this->smarty->fetch('admin/devToolbar.tpl');
    }
}

?>