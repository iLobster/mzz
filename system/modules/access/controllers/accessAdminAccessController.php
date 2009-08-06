<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/access/controllers/accessEditDefaultController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: accessEditDefaultController.php 3071 2009-03-25 00:08:37Z zerkms $
 */

/**
 * accessAdminAccessController: контроллер для метода adminAccess модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */
class accessAdminAccessController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $info = $adminMapper->getInfo();

        $module_name = $this->request->getString('module_name');

        $module = $info[$module_name];
        $id = $module['obj_id'];

        $module['name'] = $module_name;

        $db = db::factory();

        $acl = new acl($this->toolkit->getUser(), $id);

        // получаем пользователей и группы, на которые уже установлены права
        $users = $acl->getUsersList();
        $groups = $acl->getGroupsList();

        $userMapper = $this->toolkit->getMapper('user', 'user');
        $accessMapper = $this->toolkit->getMapper('access', 'access');

        // получаем число пользователей, которые ещё не добавлены в ACL для этого объекта
        $criterion = new criterion('a.uid', $userMapper->table() . '.' . $userMapper->pk(), criteria::EQUAL, true);
        $criterion->addAnd(new criterion('a.obj_id', $id));

        $criteria = new criteria($userMapper->table());
        $criteria->addSelectField(new sqlFunction('count', '*', 'true'), 'cnt');
        $criteria->addJoin($accessMapper->table(), $criterion, 'a');
        $criteria->add('a.uid', null, criteria::IS_NULL);

        $select = new simpleSelect($criteria);
        $usersNotAdded = $db->getOne($select->toString());

        $groupMapper = $this->toolkit->getMapper('user', 'group');

        // получаем число групп, которые ещё не добавлены в ACL для этого объекта
        $criterion = new criterion('a.gid', $groupMapper->table() . '.' . $groupMapper->pk(), criteria::EQUAL, true);
        $criterion->addAnd(new criterion('a.obj_id', $id));

        $criteria = new criteria($groupMapper->table());
        $criteria->addSelectField(new sqlFunction('count', '*', 'true'), 'cnt');
        $criteria->addJoin($accessMapper->table(), $criterion, 'a');
        $criteria->add('a.gid', null, criteria::IS_NULL);

        $select = new simpleSelect($criteria);
        $groupsNotAdded = $db->getOne($select->toString());

        $this->smarty->assign('module', $module);
        $this->smarty->assign('users', $users);
        $this->smarty->assign('usersExists', (bool)$usersNotAdded);
        $this->smarty->assign('groupsExists', (bool)$groupsNotAdded);
        $this->smarty->assign('groups', $groups);
        $this->smarty->assign('id', $id);
        return $this->smarty->fetch('access/editAccess.tpl');
    }
}

?>