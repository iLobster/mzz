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
 * accessEditDefaultView: вид для метода editDefault модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */


class accessEditDefaultView extends simpleView
{
    private $groups;
    private $section;
    private $class;
    private $usersExists;
    private $groupsExist;

    public function __construct($users, $groups, $section, $class, $usersExists, $groupsExist)
    {
        parent::__construct($users);
        $this->groups = $groups;
        $this->class = $class;
        $this->section = $section;
        $this->usersExists = $usersExists;
        $this->groupsExist = $groupsExist;
    }

    public function toString()
    {
        $this->smarty->assign('users', $this->DAO);
        $this->smarty->assign('usersExists', $this->usersExists);
        $this->smarty->assign('groupsExists', $this->groupsExist);
        $this->smarty->assign('groups', $this->groups);
        $this->smarty->assign('class', $this->class);
        $this->smarty->assign('section', $this->section);
        return $this->smarty->fetch('access.editDefault.tpl');
    }
}

?>