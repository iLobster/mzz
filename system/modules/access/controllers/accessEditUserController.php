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
 * accessEditUserController: контроллер для метода editUser модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */
class accessEditUserController extends simpleController
{
    protected function getView()
    {
        $obj_id = $this->request->getInteger('id', SC_PATH | SC_POST);
        $user_id = $this->request->getInteger('user_id', SC_PATH | SC_POST);

        $userMapper = $this->toolkit->getMapper('user', 'user', 'user');
        $user = $userMapper->searchByKey($user_id);

        $acl = new acl($user, $obj_id);

        try {
            $action = $this->toolkit->getAction($acl->getModule());
        } catch (mzzRuntimeException $e) {
            $controller = new messageController($e->getMessage(), messageController::WARNING);
            return $controller->run();
        }


        $actions = $action->getActions(array('acl' => true));

        $actions = $actions[$acl->getClass()];

        if ($this->request->getMethod() == 'POST' && $user_id == $user->getId()) {
            $setted = $this->request->getArray('access', SC_POST);

            $result = array();
            foreach ($actions as $key => $val) {
                $result[$key]['allow'] = isset($setted[$key]) && isset($setted[$key]['allow']) && $setted[$key]['allow'];
                $result[$key]['deny'] = isset($setted[$key]) && isset($setted[$key]['deny']) && $setted[$key]['deny'];
            }

            $acl->set($result);

            return jipTools::closeWindow();
        }

        $action = $this->request->getAction();
        $users = false;

        if ($action == 'addUser') {
            $criterion = new criterion('a.uid', $userMapper->table() . '.' . $userMapper->pk(), criteria::EQUAL, true);
            $criterion->addAnd(new criterion('a.obj_id', $obj_id));

            $criteria = new criteria();
            $criteria->addJoin('sys_access', $criterion, 'a');
            $criteria->add('a.uid', null, criteria::IS_NULL);

            $users = $userMapper->searchAllByCriteria($criteria);
        }

        $this->smarty->assign('acl', $acl->get(null, true, true));
        $this->smarty->assign('user', $user);
        $this->smarty->assign('users', $users);
        $this->smarty->assign('actions', $actions);

        return $this->smarty->fetch('access/editUser.tpl');
    }
}

?>