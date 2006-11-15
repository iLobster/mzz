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

fileLoader::load('access/views/accessEditGroupDefaultView');

class accessEditGroupDefaultController extends simpleController
{
    public function getView()
    {
        if (($group_id = $this->request->get('id', 'integer', SC_PATH)) == null) {
            $group_id = $this->request->get('id', 'integer', SC_POST);
        }

        $class = $this->request->get('class_name', 'string', SC_PATH);
        $section = $this->request->get('section_name', 'string', SC_PATH);

        $groupMapper = $this->toolkit->getMapper('user', 'group', 'user');
        $group = $groupMapper->searchById($group_id);

        $acl = new acl($this->toolkit->getUser(), 0, $class, $section);

        $action = $this->toolkit->getAction($acl->getModule($class));
        $actions = $action->getActions();

        $actions = $actions[$class];

        if ($this->request->getMethod() == 'POST' && $group) {
            $setted = $this->request->get('access', 'array', SC_POST);

            $result = array();
            foreach ($actions as $key => $val) {
                $result[$key]['allow'] = isset($setted[$key]) && isset($setted[$key]['allow']) && $setted[$key]['allow'];
                $result[$key]['deny'] = isset($setted[$key]) && isset($setted[$key]['deny']) && $setted[$key]['deny'];
            }

            $acl->setDefault($group_id, $result);

            fileLoader::load('access/views/accessEditUserSuccessView');
            return new accessEditUserSuccessView();
        }

        $action = $this->request->getAction();
        $groups = false;

        if ($action == 'addGroupDefault') {
            $class_section_id = $acl->getClassSection();

            $criterion = new criterion('a.gid', $groupMapper->getTable() . '.' . $groupMapper->getTableKey(), criteria::EQUAL, true);
            $criterion->addAnd(new criterion('a.obj_id', 0));
            $criterion->addAnd(new criterion('a.class_section_id', $class_section_id));

            $criteria = new criteria();
            $criteria->addJoin('sys_access', $criterion, 'a');
            //$criteria->addGroupBy($groupMapper->getTable() . '.' . $groupMapper->getTableKey());
            $criteria->add('a.id', null, criteria::IS_NULL);

            $groups = $groupMapper->searchAllByCriteria($criteria);
        }

        return new accessEditGroupDefaultView($acl, array_keys($actions), $group, $groups, $class, $section);
    }
}

?>