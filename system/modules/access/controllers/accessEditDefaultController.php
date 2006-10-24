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
 * accessEditDefaultController: контроллер для метода editDefault модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */

fileLoader::load('access/views/accessEditDefaultView');

class accessEditDefaultController extends simpleController
{
    public function getView()
    {
        $db = db::factory();

        $class = $this->request->get('class_name', 'string', SC_PATH);
        $section = $this->request->get('section_name', 'string', SC_PATH);

        $acl = new acl($this->toolkit->getUser());
        // получаем пользователей и группы, на которые уже установлены права
        $users = $acl->getUsersListDefault($section, $class);
        $groups = $acl->getGroupsListDefault($section, $class);

        $userMapper = $this->toolkit->getMapper('user', 'user', 'user');

        // получаем число пользователей, которые ещё не добавлены в ACL для этого объекта
        $criteria = new criteria($userMapper->getTable());
        $criteria->addSelectField('COUNT(*)', 'cnt');
        $select = new simpleSelect($criteria);
        $usersNotAdded = $db->getOne($select->toString()) - sizeof($users);


        $groupMapper = $this->toolkit->getMapper('user', 'group', 'user');

        // получаем число групп, которые ещё не добавлены в ACL для этого объекта
        $criteria = new criteria($groupMapper->getTable());
        $criteria->addSelectField('COUNT(*)', 'cnt');
        $select = new simpleSelect($criteria);
        $groupsNotAdded = $db->getOne($select->toString()) - sizeof($groups);

        return new accessEditDefaultView($users, $groups, $class, $section, $usersNotAdded, $groupsNotAdded);
    }
}

?>