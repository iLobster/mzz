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
 * userMemberOfView: вид для метода memberOf модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */


class userMemberOfView extends simpleView
{
    private $groups;

    public function __construct($user, $groups)
    {
        $this->groups = $groups;
        parent::__construct($user);
    }

    public function toString()
    {
        $selected = array();
        foreach ($this->DAO->getGroups() as $val) {
            $selected[$val->getGroup()->getId()] = 1;
        }

        $this->smarty->assign('groups', $this->groups);
        $this->smarty->assign('selected', $selected);
        $this->smarty->assign('user', $this->DAO);

        $this->response->setTitle('Пользователь -> ' . $this->DAO->getLogin() . ' -> список групп');

        return $this->smarty->fetch('user/memberOf.tpl');
    }
}

?>