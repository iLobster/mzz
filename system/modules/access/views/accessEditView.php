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
 * accessEditView: вид для метода edit модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */


class accessEditView extends simpleView
{
    private $groups;
    private $id;

    public function __construct($users, $groups, $id)
    {
        parent::__construct($users);
        $this->groups = $groups;
        $this->id = $id;
    }

    public function toString()
    {
        $this->smarty->assign('users', $this->DAO);
        $this->smarty->assign('groups', $this->groups);
        $this->smarty->assign('id', $this->id);
        return $this->smarty->fetch('access.edit.tpl');
    }
}

?>