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
 * userAddToGroupController: ���������� ��� ������ addToGroup ������ user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userAddToGroupController extends simpleController
{
    protected function getView()
    {
        $filter = $this->request->get('filter', 'string', SC_GET);

        $id = $this->request->get('id', 'integer');

        $groupMapper = $this->toolkit->getMapper('user', 'group');
        $group = $groupMapper->searchById($id);

        // ��������� ��� ������� ������ ������
        if (is_null($group)) {
            return $groupMapper->get404()->run();
        }

        if ($this->request->getMethod() == 'POST') {
            $userGroupMapper = $this->toolkit->getMapper('user', 'userGroup');

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

            return jipTools::closeWindow();
        } else {

            $users = array();

            if (!is_null($filter)) {
                $userGroupMapper = $this->toolkit->getMapper('user', 'userGroup');
                $userMapper = $this->toolkit->getMapper('user', 'user');

                $criterion = new criterion('r.user_id', 'user.' . $userMapper->getTableKey(), criteria::EQUAL, true);
                $criterion->addAnd(new criterion('r.group_id', $id));

                $criteria = new criteria();
                $criteria->addJoin($userGroupMapper->getTable(), $criterion, 'r');
                $criteria->add('login', '%' . $filter . '%', criteria::LIKE)->add('r.id', null, criteria::IS_NULL);

                // @todo: �������� ���� ����� ����� ��������� � ������?
                $limit = 25;
                $criteria->setLimit($limit + 1);

                $userMapper = $this->toolkit->getMapper('user', 'user');

                // �������� ���� �������������, ������� ��� �� ��������� � ��� ������ � ������������� �����
                $users = $userMapper->searchAllByCriteria($criteria);

                if (sizeof($users) > $limit) {
                    $this->smarty->assign('too_much', true);
                }

                $this->smarty->assign('filter', $filter);
            }

            $url = new url('withId');
            $url->setSection($this->request->getSection());
            $url->addParam('id', $this->request->get('id', 'integer'));
            $url->setAction('addToGroupList');


            $this->smarty->assign('users', $users);
            $this->smarty->assign('group', $group);

            $this->response->setTitle('������ -> ' . $group->getName() . ' -> ���������� �������������');
            return $this->smarty->fetch('user/addToGroup.tpl');
        }
    }
}

?>