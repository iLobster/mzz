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
 * accessEditUserDefaultView: вид для метода editUserDefault модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */


class accessEditUserDefaultView extends simpleView
{
    private $actions;
    private $user;
    private $users;
    private $class;
    private $section;

    public function __construct($acl, $actions, $user, $users, $class, $section)
    {
        $this->actions = $actions;
        $this->user = $user;
        $this->users = $users;
        $this->class = $class;
        $this->section = $section;
        parent::__construct($acl);
    }

    public function toString()
    {
        if ($this->user) {
            $this->smarty->assign('acl', $this->DAO->getDefault($this->user->getId()));
        }
        $this->smarty->assign('user', $this->user);
        $this->smarty->assign('users', $this->users);
        $this->smarty->assign('actions', $this->actions);
        $this->smarty->assign('class', $this->class);
        $this->smarty->assign('section', $this->section);

        $title = $this->user ? $this->user->getLogin() : 'добавить пользователя';
        $this->response->setTitle('ACL -> объект ... -> права по умолчанию -> ' . $title);

        return $this->smarty->fetch('access.editUserDefault.tpl');
    }
}

?>