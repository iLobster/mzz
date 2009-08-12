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
 * accessEditAccessGroupController
 * @package modules
 * @subpackage access
 * @version 0.1
 */
class accessEditAccessGroupController extends simpleController
{
    private $module_name;

    private $group;

    protected function getView()
    {
        $this->module_name = $this->request->getString('module_name');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $info = $adminMapper->getInfo();
        $module = $info[$this->module_name];
        $obj_id = $module['obj_id'];
        $module['name'] = $this->module_name;

        $group_id = $this->request->getInteger('user_id', SC_PATH | SC_POST | SC_GET);

        $groupMapper = $this->toolkit->getMapper('user', 'group');
        $this->group = $groupMapper->searchByKey($group_id);

        $acl = new acl($this->toolkit->getUser(), $obj_id);

        $validator = new formValidator();

        list ($access, $actions) = $this->getActionsList($obj_id);

        if ($this->request->getMethod() == 'POST' && $this->group) {
            $setted = $this->request->getArray('access', SC_POST);

            $admin_access = array(
                'admin' => array(
                    'allow' => !empty($setted['admin_access']['allow']),
                    'deny' => !empty($setted['admin_access']['deny'])));

            unset($setted['admin_access']);
            unset($access['admin_access']);

            $result = array();

            foreach ($access as $key => $val) {
                if (!isset($setted[$key])) {
                    $setted[$key] = array(
                        'allow' => 0,
                        'deny' => 0);
                }
            }

            foreach ($setted as $key => $val) {
                $action = $this->getAdminsActions($key);

                $result[$action['class']][$key]['allow'] = isset($setted[$key]) && !empty($setted[$key]['allow']);
                $result[$action['class']][$key]['deny'] = isset($setted[$key]) && !empty($setted[$key]['deny']);
            }

            foreach ($result as $key => $val) {
                $acl_default = new acl($this->toolkit->getUser(), 0, $key);
                $acl_default->setDefault($group_id, $val);
            }

            $acl->setForGroup($group_id, $admin_access);

            return jipTools::closeWindow();
        }

        $action = $this->request->getAction();
        $groups = false;

        if ($action == 'addAccessGroup') {
            $accessMapper = $this->toolkit->getMapper('access', 'access');
            $criterion = new criterion('a.gid', $groupMapper->table() . '.' . $groupMapper->pk(), criteria::EQUAL, true);
            $criterion->addAnd(new criterion('a.obj_id', $obj_id));

            $criteria = new criteria();
            $criteria->addJoin($accessMapper->table(), $criterion, 'a');
            $criteria->add('a.gid', null, criteria::IS_NULL);

            $groups = $groupMapper->searchAllByCriteria($criteria);
        }

        $this->smarty->assign('acl', $access);
        $this->smarty->assign('group', $this->group);
        $this->smarty->assign('groups', $groups);
        $this->smarty->assign('actions', $actions);

        return $this->smarty->fetch('access/editAccessGroup.tpl');
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

        $acl = new acl($this->toolkit->getUser(), $obj_id);
        if ($this->group) {
            $tmp = $acl->getForGroup($this->group->getId());
            $access['admin_access'] = array(
                'allow' => isset($tmp['admin']) && $tmp['admin'],
                'deny' => isset($tmp['admin']) && !$tmp['admin']);
        }

        foreach ($this->getAdminsActions() as $module => $item) {
            $acl_default = new acl($this->toolkit->getUser(), 0, $module);
            if ($this->group) {
                $access = array_merge($access, $acl_default->getForGroupDefault($this->group->getId(), true));
            }

            foreach ($item as $key => $admin_action) {
                $actions[$key]['title'] = $admin_action['title'];
            }
        }

        return array(
            $access,
            $actions);
    }
}

?>