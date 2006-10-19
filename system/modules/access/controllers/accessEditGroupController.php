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
 * accessEditGroupController: ���������� ��� ������ editGroup ������ access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */

fileLoader::load('access/views/accessEditGroupView');

class accessEditGroupController extends simpleController
{
    public function getView()
    {
        if (($obj_id = $this->request->get('id', 'integer', SC_PATH)) == null) {
            $obj_id = $this->request->get('id', 'integer', SC_POST);
        }

        if (($group_id = $this->request->get('user_id', 'integer', SC_PATH)) == null) {
            $group_id = $this->request->get('user_id', 'integer', SC_POST);
        }

        $groupMapper = $this->toolkit->getMapper('user', 'group', 'user');
        $group = $groupMapper->searchById($group_id);

        $acl = new acl($this->toolkit->getUser(), $obj_id);

        $action = $this->toolkit->getAction($acl->getModule());
        $actions = $action->getActions();

        $actions = $actions[$acl->getClass()];

        if ($this->request->getMethod() == 'POST' && $group) {
            $setted = $this->request->get('access', 'array', SC_POST);

            $result = array();
            foreach ($actions as $key => $val) {
                $result[$key] = isset($setted[$key]) && $setted[$key];
            }

            $acl->setForGroup($group_id, $result);

            fileLoader::load('access/views/accessEditUserSuccessView');
            return new accessEditUserSuccessView();
        }

        $action = $this->request->getAction();
        $groups = false;

        if ($action == 'addGroup') {
            $criterion = new criterion('a.gid', $groupMapper->getTable() . '.' . $groupMapper->getTableKey(), criteria::EQUAL, true);
            $criterion->addAnd(new criterion('a.obj_id', $obj_id));

            $criteria = new criteria();
            $criteria->addJoin('sys_access', $criterion, 'a');
            $criteria->add('a.gid', null, criteria::IS_NULL);

            $groups = $groupMapper->searchAllByCriteria($criteria);
        }

        return new accessEditGroupView($acl, array_keys($actions), $group, $groups);
    }
}

?>