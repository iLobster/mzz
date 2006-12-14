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
 * accessEditUserDefaultController: ���������� ��� ������ editUserDefault ������ access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */

fileLoader::load('access/views/accessEditUserDefaultView');

class accessEditUserDefaultController extends simpleController
{
    public function getView()
    {
        if (($user_id = $this->request->get('id', 'integer', SC_PATH)) == null) {
            $user_id = $this->request->get('id', 'integer', SC_POST);
        }

        $class = $this->request->get('class_name', 'string', SC_PATH);
        $section = $this->request->get('section_name', 'string', SC_PATH);

        $userMapper = $this->toolkit->getMapper('user', 'user', 'user');
        $user = $userMapper->searchById($user_id);

        $acl = new acl($user, 0, $class, $section);

        $action = $this->toolkit->getAction($acl->getModule($class));
        $actions = $action->getActions();

        $actions = $actions[$class];

        if ($this->request->getMethod() == 'POST' && $user) {
            $setted = $this->request->get('access', 'array', SC_POST);

            $result = array();
            foreach ($actions as $key => $val) {
                $result[$key]['allow'] = isset($setted[$key]) && isset($setted[$key]['allow']) && $setted[$key]['allow'];
                $result[$key]['deny'] = isset($setted[$key]) && isset($setted[$key]['deny']) && $setted[$key]['deny'];
            }

            $acl->setDefault($user_id, $result, true);

            return new simpleJipCloseView(2);
        }


        $action = $this->request->getAction();
        $users = false;

        if ($action == 'addUserDefault') {
            $class_section_id = $acl->getClassSection();

            $criterion = new criterion('a.uid', 'user.' . $userMapper->getTableKey(), criteria::EQUAL, true);
            $criterion->addAnd(new criterion('a.obj_id', 0));
            $criterion->addAnd(new criterion('a.class_section_id', $class_section_id));

            $criteria = new criteria();
            $criteria->addJoin('sys_access', $criterion, 'a');
            $criteria->add('a.id', null, criteria::IS_NULL);

            $users = $userMapper->searchAllByCriteria($criteria);
        }

        return new accessEditUserDefaultView($acl, $actions, $user, $users, $class, $section);
    }
}

?>