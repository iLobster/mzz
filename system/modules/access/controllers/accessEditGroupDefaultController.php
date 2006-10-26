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
                $result[$key] = isset($setted[$key]) && $setted[$key];
            }

            $acl->setDefault($group_id, $result);

            fileLoader::load('access/views/accessEditUserSuccessView');
            return new accessEditUserSuccessView();
        }

        $groups = false;

        return new accessEditGroupDefaultView($acl, array_keys($actions), $group, $groups);
    }
}

?>