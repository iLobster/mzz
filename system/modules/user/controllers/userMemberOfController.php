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
 * userMemberOfController: контроллер для метода memberOf модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

fileLoader::load('user/views/userMemberOfView');

class userMemberOfController extends simpleController
{
    public function getView()
    {
        if (($id = $this->request->get('id', 'integer', SC_PATH)) == null) {
            $id = $this->request->get('id', 'integer', SC_POST);
        }

        $userMapper = $this->toolkit->getMapper('user', 'user', $this->request->getSection());
        $userGroupMapper = $this->toolkit->getMapper('user', 'userGroup', $this->request->getSection());

        $user = $userMapper->searchById($id);

        // проверяем что найден нужный пользователь
        if ($id != $user->getId()) {
            fileLoader::load('user/views/user404View');
            return new user404View();
        }

        if ($this->request->getMethod() == 'POST') {
            // если была отправлена форма
            $groups = $this->request->get('groups', 'array', SC_POST);

            if (is_null($groups)) {
                $groups = array();
            }

            $groupsArray = array();

            // формируем массив с выбранными группами
            foreach (array_keys($groups) as $val) {
                $criteria = new criteria();
                $criteria->add('user_id', $id)->add('group_id', $val);
                $userGroup = $userGroupMapper->searchOneByCriteria($criteria);

                if (is_null($userGroup)) {
                    $userGroup = $userGroupMapper->create();
                    $userGroup->setUser($id);
                    $userGroup->setGroup($val);
                }

                $groupsArray[] = $userGroup;
            }

            $user->setGroups($groupsArray);
            $userMapper->save($user);

            return new simpleJipCloseView();
        } else {
            // если просто показать список групп и пользователей
            $groupMapper = $this->toolkit->getMapper('user', 'group', $this->request->getSection());

            $criteria = new criteria();
            $criteria->setOrderByFieldAsc('name');
            $groups = $groupMapper->searchAll($criteria);

            return new userMemberOfView($user, $groups);
        }
    }
}

?>