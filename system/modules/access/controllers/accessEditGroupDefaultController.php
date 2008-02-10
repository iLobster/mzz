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
 * accessEditGroupDefaultController: контроллер для метода editGroupDefault модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */
class accessEditGroupDefaultController extends simpleController
{
    protected function getView()
    {
        $group_id = $this->request->getInteger('id', SC_PATH | SC_POST);

        $class = $this->request->getString('class_name');
        $section = $this->request->getString('section_name');

        $groupMapper = $this->toolkit->getMapper('user', 'group', 'user');
        $group = $groupMapper->searchById($group_id);

        $acl = new acl($this->toolkit->getUser(), 0, $class, $section);

        $action = $this->toolkit->getAction($acl->getModule($class));
        $actions = $action->getActions(true);

        $actions = $actions[$class];

        if ($this->request->getMethod() == 'POST' && $group) {
            $setted = $this->request->getArray('access', SC_POST);

            $result = array();
            foreach ($actions as $key => $val) {
                $result[$key]['allow'] = isset($setted[$key]) && isset($setted[$key]['allow']) && $setted[$key]['allow'];
                $result[$key]['deny'] = isset($setted[$key]) && isset($setted[$key]['deny']) && $setted[$key]['deny'];
            }

            $acl->setDefault($group_id, $result);

            return jipTools::closeWindow();
        }

        $action = $this->request->getAction();
        $groups = false;

        if ($action == 'addGroupDefault') {
            $class_section_id = $acl->getClassSection();

            $criterion = new criterion('a.gid', 'group.' . $groupMapper->getTableKey(), criteria::EQUAL, true);
            $criterion->addAnd(new criterion('a.obj_id', 0));
            $criterion->addAnd(new criterion('a.class_section_id', $class_section_id));

            $criteria = new criteria();
            $criteria->addJoin('sys_access', $criterion, 'a');
            //$criteria->addGroupBy($groupMapper->getTable() . '.' . $groupMapper->getTableKey());
            $criteria->add('a.id', null, criteria::IS_NULL);

            $groups = $groupMapper->searchAllByCriteria($criteria);
        }

        if ($group) {
            $this->smarty->assign('acl', $acl->getForGroupDefault($group->getId(), true));
        }
        $this->smarty->assign('group', $group);
        $this->smarty->assign('groups', $groups);
        $this->smarty->assign('actions', $actions);
        $this->smarty->assign('class', $class);
        $this->smarty->assign('section', $section);

        $title = $group ? $group->getName() : 'добавить группу';
        $this->response->setTitle('ACL -> Права по умолчанию -> ' . $title);

        return $this->smarty->fetch('access/editGroupDefault.tpl');
    }
}

?>