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
 * accessEditUserView: вид для метода editUser модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */


class accessEditUserView extends simpleView
{
    private $actions;
    private $user;

    public function __construct($acl, $actions, $user)
    {
        $this->actions = $actions;
        $this->user = $user;
        parent::__construct($acl);
    }

    public function toString()
    {
        $this->smarty->assign('acl', $this->DAO->get());
        $this->smarty->assign('user', $this->user);
        $this->smarty->assign('actions', $this->actions);

        $this->response->setTitle('ACL -> объект ... -> ' . $this->user->getLogin());

        return $this->smarty->fetch('access.editUser.tpl');
    }
}

?>