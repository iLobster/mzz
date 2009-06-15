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
 * accessEditGroupController: контроллер для метода editGroup модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */
class accessEditGroupController extends simpleController
{
    protected function getView()
    {
        $obj_id = $this->request->getInteger('id', SC_PATH | SC_POST);
        $group_id = $this->request->getInteger('user_id', SC_PATH | SC_POST);

        $groupMapper = $this->toolkit->getMapper('user', 'group');
        $group = $groupMapper->searchByKey($group_id);

        $acl = new acl($this->toolkit->getUser(), $obj_id);

        try {
            $action = $this->toolkit->getAction($acl->getModule());
        } catch (mzzRuntimeException $e) {
            $controller = new messageController($e->getMessage(), messageController::WARNING);
            return $controller->run();
        }

        $actions = $action->getActions(array('acl' => true));

        $actions = $actions[$acl->getClass()];

        if ($this->request->getMethod() == 'POST' && $group) {
            $setted = $this->request->getArray('access', SC_POST);

            $result = array();
            foreach ($actions as $key => $val) {
                $result[$key]['allow'] = isset($setted[$key]) && isset($setted[$key]['allow']) && $setted[$key]['allow'];
                $result[$key]['deny'] = isset($setted[$key]) && isset($setted[$key]['deny']) && $setted[$key]['deny'];
            }

            $acl->setForGroup($group_id, $result);

            return jipTools::closeWindow();
        }

        $action = $this->request->getAction();
        $groups = false;

        if ($action == 'addGroup') {
            $accessMapper = $this->toolkit->getMapper('access', 'access');
            $criterion = new criterion('a.gid', $groupMapper->table() . '.' . $groupMapper->pk(), criteria::EQUAL, true);
            $criterion->addAnd(new criterion('a.obj_id', $obj_id));

            $criteria = new criteria();
            $criteria->addJoin($accessMapper->table(), $criterion, 'a');
            $criteria->add('a.gid', null, criteria::IS_NULL);

            $groups = $groupMapper->searchAllByCriteria($criteria);
        }

        if ($group) {
            $this->smarty->assign('acl', $acl->getForGroup($group->getId(), true));
        }

        $this->smarty->assign('group', $group);
        $this->smarty->assign('groups', $groups);
        $this->smarty->assign('actions', $actions);

        return $this->smarty->fetch('access/editGroup.tpl');
    }
}

?>