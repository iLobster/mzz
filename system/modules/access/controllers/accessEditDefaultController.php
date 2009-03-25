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
 * accessEditDefaultController: контроллер для метода editDefault модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */
class accessEditDefaultController extends simpleController
{
    protected function getView()
    {
        $db = db::factory();

        $class = $this->request->getString('class_name');

        $acl = new acl($this->toolkit->getUser());
        // получаем пользователей и группы, на которые уже установлены права
        $users = $acl->getUsersListDefault($class);
        $groups = $acl->getGroupsListDefault($class);

        $userMapper = $this->toolkit->getMapper('user', 'user');

        // получаем число пользователей, которые ещё не добавлены в ACL для этого объекта
        $criteria = new criteria($userMapper->table());
        $criteria->addSelectField(new sqlFunction('count', '*', true), 'cnt');
        $select = new simpleSelect($criteria);
        $usersNotAdded = $db->getOne($select->toString()) - sizeof($users);

        $groupMapper = $this->toolkit->getMapper('user', 'group');

        // получаем число групп, которые ещё не добавлены в ACL для этого объекта
        $criteria = new criteria($groupMapper->table());
        $criteria->addSelectField(new sqlFunction('count', '*', true), 'cnt');
        $select = new simpleSelect($criteria);
        $groupsNotAdded = $db->getOne($select->toString()) - sizeof($groups);

        $this->smarty->assign('users', $users);
        $this->smarty->assign('usersExists', $usersNotAdded);
        $this->smarty->assign('groupsExists', $groupsNotAdded);
        $this->smarty->assign('groups', $groups);
        $this->smarty->assign('class', $class);
        return $this->smarty->fetch('access/editDefault.tpl');
    }
}

?>