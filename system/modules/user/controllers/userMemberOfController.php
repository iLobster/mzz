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
class userMemberOfController extends simpleController
{
    protected function getView()
    {
        if (($id = $this->request->getInteger('id')) == null) {
            $id = $this->request->getInteger('id', SC_POST);
        }

        $userMapper = $this->toolkit->getMapper('user', 'user');
        $userGroupMapper = $this->toolkit->getMapper('user', 'userGroup');

        $user = $userMapper->searchById($id);

        // проверяем что найден нужный пользователь
        if ($user && $id != $user->getId()) {
            return $userMapper->get404()->run();
        }

        if ($this->request->getMethod() == 'POST') {
            // если была отправлена форма
            $groups = $this->request->getArray('groups', SC_POST);

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

            return jipTools::closeWindow();
        } else {
            // если просто показать список групп и пользователей
            $groupMapper = $this->toolkit->getMapper('user', 'group');

            $criteria = new criteria();
            $criteria->setOrderByFieldAsc('name');
            $groups = $groupMapper->searchAll($criteria);

            $selected = array();
            foreach ($user->getGroups() as $val) {
                $selected[$val->getGroup()->getId()] = 1;
            }

            $this->smarty->assign('groups', $groups);
            $this->smarty->assign('selected', $selected);
            $this->smarty->assign('user', $user);

            return $this->smarty->fetch('user/memberOf.tpl');
        }
    }
}

?>