<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/**
 * userLoginAlreadyView: ��� ������ user ��� ��� ���������������� �������������
 *
 * @package user
 * @version 0.1
 */

class userLoginAlreadyView extends simpleView
{
    public function toString()
    {
        $this->smarty->assign('user', $this->DAO);

        return $this->smarty->fetch('user.already.login.tpl');
    }

}
?>