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
 * accessEditController: контроллер для метода edit модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */
class accessEditACLController extends simpleController
{
    public function getView()
    {
        $db = db::factory();

        $id = $this->request->get('id', 'integer', SC_PATH);

        $acl = new acl($this->toolkit->getUser(), $id);
        // получаем пользователей и группы, на которые уже установлены права
        $users = $acl->getUsersList();
        $groups = $acl->getGroupsList();

        $userMapper = $this->toolkit->getMapper('user', 'user', 'user');

        // получаем число пользователей, которые ещё не добавлены в ACL для этого объекта
        $criterion = new criterion('a.uid', $userMapper->getTable() . '.' . $userMapper->getTableKey(), criteria::EQUAL, true);
        $criterion->addAnd(new criterion('a.obj_id', $id));

        $criteria = new criteria($userMapper->getTable());
        $criteria->addSelectField('COUNT(*)', 'cnt');
        $criteria->addJoin('sys_access', $criterion, 'a');
        $criteria->add('a.uid', null, criteria::IS_NULL);

        $select = new simpleSelect($criteria);
        $usersNotAdded = $db->getOne($select->toString());


        $groupMapper = $this->toolkit->getMapper('user', 'group', 'user');

        // получаем число групп, которые ещё не добавлены в ACL для этого объекта
        $criterion = new criterion('a.gid', $groupMapper->getTable() . '.' . $groupMapper->getTableKey(), criteria::EQUAL, true);
        $criterion->addAnd(new criterion('a.obj_id', $id));

        $criteria = new criteria($groupMapper->getTable());
        $criteria->addSelectField('COUNT(*)', 'cnt');
        $criteria->addJoin('sys_access', $criterion, 'a');
        $criteria->add('a.gid', null, criteria::IS_NULL);

        $select = new simpleSelect($criteria);
        $groupsNotAdded = $db->getOne($select->toString());

        $this->smarty->assign('users', $users);
        $this->smarty->assign('usersExists', (bool)$usersNotAdded);
        $this->smarty->assign('groupsExists', (bool)$groupsNotAdded);
        $this->smarty->assign('groups', $groups);
        $this->smarty->assign('id', $id);
        return $this->smarty->fetch('access/edit.tpl');
    }
}

?>