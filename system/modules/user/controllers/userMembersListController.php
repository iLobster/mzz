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
 * userMembersListController: контроллер для метода membersList модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userMembersListController extends simpleController
{
    protected function getView()
    {
        if (($id = $this->request->getInteger('id')) == null) {
            $id = $this->request->getInteger('id', SC_POST);
        }

        $userGroupMapper = $this->toolkit->getMapper('user', 'userGroup');
        $groupMapper = $this->toolkit->getMapper('user', 'group');

        $group = $groupMapper->searchById($id);

        // проверяем что найдена нужная группа
        if (is_null($group)) {
            return $groupMapper->get404()->run();
        }

        if ($this->request->getMethod() == 'POST') {
            // если была отправлена форма
            $users = $this->request->getArray('users', SC_POST);

            if (is_null($users)) {
                $users = array();
            }

            $usersArray = array();

            // формируем массив с выбранными пользователями
            foreach (array_keys($users) as $val) {
                $criteria = new criteria();
                $criteria->add('group_id', $id)->add('user_id', $val);
                $userGroup = $userGroupMapper->searchOneByCriteria($criteria);

                if (!is_null($userGroup)) {
                    $userGroupMapper->delete($userGroup->getId());
                }
            }

            return jipTools::closeWindow(0, true);
        } else {
            $criteria = new criteria();
            $criteria->add('group_id', $id)->setOrderByFieldAsc('user_id.login');
            $users = $userGroupMapper->searchAllByCriteria($criteria);

            $this->smarty->assign('users', $users);
            $this->smarty->assign('group', $group);
            $this->response->setTitle('Группа -> ' . $group->getName() . ' -> список пользователей');
            return $this->smarty->fetch('user/membersList.tpl');
        }
    }
}

?>