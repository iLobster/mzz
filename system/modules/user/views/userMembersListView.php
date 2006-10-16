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
 * userMembersListView: вид для метода membersList модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */


class userMembersListView extends simpleView
{
    private $users;

    public function __construct($group, $users)
    {
        parent::__construct($group);
        $this->users = $users;
    }

    public function toString()
    {
        $this->smarty->assign('users', $this->users);
        $this->smarty->assign('group', $this->DAO);

        $this->response->setTitle('Группа -> ' . $this->DAO->getName() . ' -> список пользователей');

        return $this->smarty->fetch('user.membersList.tpl');
    }
}

?>