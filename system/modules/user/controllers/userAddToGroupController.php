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
 * userAddToGroupController: контроллер для метода addToGroup модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

fileLoader::load('user/views/userAddToGroupView');

class userAddToGroupController extends simpleController
{
    public function getView()
    {
        $filter = $this->request->get('filter', 'string', SC_GET);

        $id = $this->request->get('id', 'integer', SC_PATH);

        $groupMapper = $this->toolkit->getMapper('user', 'group', $this->request->getSection());
        $group = $groupMapper->searchById($id);

        // проверяем что найдена нужная группа
        if (is_null($group)) {
            fileLoader::load('user/views/group404View');
            return new group404View();
        }

        if ($this->request->getMethod() == 'POST') {
            $userGroupMapper = $this->toolkit->getMapper('user', 'userGroup', $this->request->getSection());

            $users = $this->request->get('users', 'array', SC_POST);

            if (is_null($users)) {
                $users = array();
            }

            foreach (array_keys($users) as $val) {
                $criteria = new criteria();
                $criteria->add('user_id', $val)->add('group_id', $id);
                $userGroup = $userGroupMapper->searchOneByCriteria($criteria);

                if (is_null($userGroup)) {
                    $userGroup = $userGroupMapper->create();
                    $userGroup->setUser($val);
                    $userGroup->setGroup($id);
                    $userGroupMapper->save($userGroup);
                }
            }

            fileLoader::load('user/views/userAddToGroupSuccessView');
            return new userAddToGroupSuccessView();

        } else {

            $users = array();

            if (!is_null($filter)) {
                file_put_contents('c:/q', $filter);
                $userGroupMapper = $this->toolkit->getMapper('user', 'userGroup', $this->request->getSection());
                $userMapper = $this->toolkit->getMapper('user', 'user', $this->request->getSection());

                $criterion = new criterion('r.user_id', $userMapper->getTable() . '.' . $userMapper->getTableKey(), criteria::EQUAL, true);
                $criterion->addAnd(new criterion('r.group_id', $id));

                $criteria = new criteria();
                $criteria->addJoin($userGroupMapper->getTable(), $criterion, 'r');
                $criteria->add('login', '%' . $filter . '%', criteria::LIKE)->add('r.id', null, criteria::IS_NULL);

                $userMapper = $this->toolkit->getMapper('user', 'user', $this->request->getSection());

                // выбираем всех пользователей, которые ещё не добавлены в эту группу и удовлетворяют маске
                $users = $userMapper->searchAllByCriteria($criteria);
            }

            return new userAddToGroupView($users, $group, $filter);

        }
    }
}

?>