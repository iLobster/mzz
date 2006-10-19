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

fileLoader::load('access/views/accessEditView');

class accessEditController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);

        $acl = new acl($this->toolkit->getUser(), $id);
        $users = $acl->getUsersList();
        $groups = $acl->getGroupsList();

        $userMapper = $this->toolkit->getMapper('user', 'user', 'user');

        $criterion = new criterion('a.uid', $userMapper->getTable() . '.' . $userMapper->getTableKey(), criteria::EQUAL, true);
        $criterion->addAnd(new criterion('a.obj_id', $id));

        $criteria = new criteria();
        $criteria->addJoin('sys_access', $criterion, 'a');
        $criteria->add('a.uid', null, criteria::IS_NULL);

        $usersNotAdded = $userMapper->searchAllByCriteria($criteria);


        $groupMapper = $this->toolkit->getMapper('user', 'group', 'user');

        $criterion = new criterion('a.gid', $groupMapper->getTable() . '.' . $groupMapper->getTableKey(), criteria::EQUAL, true);
        $criterion->addAnd(new criterion('a.obj_id', $id));

        $criteria = new criteria();
        $criteria->addJoin('sys_access', $criterion, 'a');
        $criteria->add('a.gid', null, criteria::IS_NULL);

        $groupsNotAdded = $groupMapper->searchAllByCriteria($criteria);

        return new accessEditView($users, $groups, $id, (bool)sizeof($usersNotAdded), (bool)sizeof($groupsNotAdded));
    }
}

?>