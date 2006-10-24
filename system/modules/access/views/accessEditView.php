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
 * accessEditView: ��� ��� ������ edit ������ access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */


class accessEditView extends simpleView
{
    private $groups;
    private $id;
    private $usersExists;
    private $groupsExist;

    public function __construct($users, $groups, $id, $usersExists, $groupsExist)
    {
        $this->groups = $groups;
        $this->id = $id;
        $this->usersExists = $usersExists;
        $this->groupsExist = $groupsExist;
        parent::__construct($users);
    }

    public function toString()
    {
        $this->smarty->assign('users', $this->DAO);
        $this->smarty->assign('usersExists', $this->usersExists);
        $this->smarty->assign('groupsExists', $this->groupsExist);
        $this->smarty->assign('groups', $this->groups);
        $this->smarty->assign('id', $this->id);
        return $this->smarty->fetch('access.edit.tpl');
    }
}

?>