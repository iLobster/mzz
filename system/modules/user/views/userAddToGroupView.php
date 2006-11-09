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
 * userAddToGroupView: вид для метода addToGroup модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */


class userAddToGroupView extends simpleView
{
    private $filter;
    private $group;

    public function __construct($users, $group, $filter)
    {
        parent::__construct($users);
        $this->filter = $filter;
        $this->group = $group;
    }

    public function toString()
    {
        $url = new url();
        $url->setSection($this->httprequest->getSection());
        $url->addParam($this->httprequest->get('id', 'integer', SC_PATH));
        $url->setAction('addToGroupList');

        $this->smarty->assign('filter', $this->filter);
        $this->smarty->assign('users', $this->DAO);
        $this->smarty->assign('group', $this->group);

        $this->response->setTitle('Группа -> ' . $this->group->getName() . ' -> добавление пользователей');
        return $this->smarty->fetch('user.addToGroup.tpl');
    }

}

?>