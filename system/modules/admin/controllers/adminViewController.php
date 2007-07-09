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
 * adminViewController: контроллер дл€ метода view модул€ admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.2
 */

class adminViewController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $info = $adminMapper->getInfo();
        $this->smarty->assign('info', $info['data']);
        $this->smarty->assign('cfgAccess', $info['cfgAccess']);
        $this->smarty->assign('main_class', $info['main_class']);
        $this->smarty->assign('admin', $info['admin']);
        $this->smarty->assign('title', 'ѕанель управлени€');
        return $this->smarty->fetch('admin/view.tpl');
    }
}

?>