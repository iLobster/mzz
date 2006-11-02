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
 * accessEditUserController: ���������� ��� ������ editUser ������ access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */

fileLoader::load('access/views/accessEditUserView');

class accessEditUserController extends simpleController
{
    public function getView()
    {
        if (($obj_id = $this->request->get('id', 'integer', SC_PATH)) == null) {
            $obj_id = $this->request->get('id', 'integer', SC_POST);
        }

        if (($user_id = $this->request->get('user_id', 'integer', SC_PATH)) == null) {
            $user_id = $this->request->get('user_id', 'integer', SC_POST);
        }

        $userMapper = $this->toolkit->getMapper('user', 'user', 'user');
        $user = $userMapper->searchById($user_id);

        $acl = new acl($user, $obj_id);

        $action = $this->toolkit->getAction($acl->getModule());
        $actions = $action->getActions(true);
//var_dump($actions);
        $actions = $actions[$acl->getClass()];

        if ($this->request->getMethod() == 'POST' && $user_id == $user->getId()) {
            $setted = $this->request->get('access', 'array', SC_POST);

            $result = array();
            foreach ($actions as $key => $val) {
                $result[$key] = isset($setted[$key]) && $setted[$key];
            }

            $acl->set($result);

            fileLoader::load('access/views/accessEditUserSuccessView');
            return new accessEditUserSuccessView();
        }

        $action = $this->request->getAction();
        $users = false;

        if ($action == 'addUser') {
            $criterion = new criterion('a.uid', $userMapper->getTable() . '.' . $userMapper->getTableKey(), criteria::EQUAL, true);
            $criterion->addAnd(new criterion('a.obj_id', $obj_id));

            $criteria = new criteria();
            $criteria->addJoin('sys_access', $criterion, 'a');
            $criteria->add('a.uid', null, criteria::IS_NULL);

            $users = $userMapper->searchAllByCriteria($criteria);
        }

        return new accessEditUserView($acl, array_keys($actions), $user, $users);
    }
}

?>