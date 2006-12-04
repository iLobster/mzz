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
 * adminViewView: ��� ��� ������ view ������ admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminViewView extends simpleView
{
    public function toString()
    {
        $this->smarty->assign('info', $this->DAO['data']);
        $this->smarty->assign('cfgAccess', $this->DAO['cfgAccess']);
        $this->smarty->assign('admin', $this->DAO['admin']);
        $this->smarty->assign('title', '������ ����������');
        return $this->smarty->fetch('admin/view.tpl');
    }
}

?>