<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/access/controllers/accessEditUserController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: accessEditUserController.php 3522 2009-07-29 03:59:08Z zerkms $
 */

/**
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */
class accessEditAccessUserController extends simpleController
{
    private $module_name;

    private $user;

    protected function getView()
    {
        $this->module_name = $this->request->getString('module_name');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $info = $adminMapper->getInfo();
        $module = $info[$this->module_name];
        $obj_id = $module['obj_id'];
        $module['name'] = $this->module_name;

        $user_id = $this->request->getInteger('user_id', SC_PATH | SC_POST);

        $userMapper = $this->toolkit->getMapper('user', 'user');
        $this->user = $userMapper->searchByKey($user_id);

        $acl = new acl($this->user, $obj_id);

        $validator = new formValidator();

        $validator->add('required', 'user_id');

        list($access, $actions) = $this->getActionsList($obj_id);

        if ($validator->validate() && $user_id == $this->user->getId()) {
            $setted = $this->request->getArray('access', SC_POST);

            $admin_access = !empty($setted['admin_access']['allow']) && !empty($setted['admin_access']['deny']);
            unset($setted['admin_access']);
            unset($access['admin_access']);

            $result = array();

            foreach ($access as $key => $val) {
                $action = $this->getAdminsActions($key);

                $result[$action['class']][$key]['allow'] = isset($setted[$key]) && !empty($setted[$key]['allow']);
                $result[$action['class']][$key]['deny'] = isset($setted[$key]) && !empty($setted[$key]['deny']);
            }

            foreach ($result as $key => $val) {
                $acl_default = new acl($this->user, 0, $key);
                $acl_default->setDefault($user_id, $val, true);
            }

            $acl->set('admin', $admin_access);

            return jipTools::closeWindow();
        }

        $action = $this->request->getAction();
        $users = false;

        if ($action == 'addAccessUser') {
            $accessMapper = $this->toolkit->getMapper('access', 'access');
            $criterion = new criterion('a.uid', $userMapper->table() . '.' . $userMapper->pk(), criteria::EQUAL, true);
            $criterion->addAnd(new criterion('a.obj_id', $obj_id));

            $criteria = new criteria();
            $criteria->addJoin($accessMapper->table(), $criterion, 'a');
            $criteria->add('a.uid', null, criteria::IS_NULL);

            $users = $userMapper->searchAllByCriteria($criteria);
        }

        $this->smarty->assign('acl', $access);
        $this->smarty->assign('user', $this->user);
        $this->smarty->assign('users', $users);
        $this->smarty->assign('actions', $actions);

        return $this->smarty->fetch('access/editAccessUser.tpl');
    }

    private function getAdminsActions($name = null)
    {
        static $actions;

        if (!$actions) {
            $actions = $this->toolkit->getAction($this->module_name)->getActions(array(
                'admin' => true));
        }

        if ($name) {
            foreach ($actions as $key => $class) {
                if (isset($class[$name])) {
                    $class[$name]['class'] = $key;
                    return $class[$name];
                }
            }
        }

        return $actions;
    }

    private function getActionsList($obj_id)
    {
        $actions = array(
            'admin_access' => array(
                'title' => 'Администрирование модуля'));

        $access = array();

        $acl = new acl($this->user, $obj_id);
        $access['admin_access'] = $acl->get('admin', false, true);

        foreach ($this->getAdminsActions() as $module => $item) {
            $acl_default = new acl($this->user, 0, $module);
            $access = array_merge($access, $acl_default->getDefault(true));

            foreach ($item as $key => $admin_action) {
                $actions[$key]['title'] = $admin_action['title'];
            }
        }

        return array($access, $actions);
    }
}

?>