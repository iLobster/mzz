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
 * userMemberOfController: ���������� ��� ������ memberOf ������ user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userMemberOfController extends simpleController
{
    public function getView()
    {
        if (($id = $this->request->get('id', 'integer', SC_PATH)) == null) {
            $id = $this->request->get('id', 'integer', SC_POST);
        }

        $userMapper = $this->toolkit->getMapper('user', 'user');
        $userGroupMapper = $this->toolkit->getMapper('user', 'userGroup');

        $user = $userMapper->searchById($id);

        // ��������� ��� ������ ������ ������������
        if ($id != $user->getId()) {
            fileLoader::load('user/views/user404View');
            return new user404View();
        }

        if ($this->request->getMethod() == 'POST') {
            // ���� ���� ���������� �����
            $groups = $this->request->get('groups', 'array', SC_POST);

            if (is_null($groups)) {
                $groups = array();
            }

            $groupsArray = array();

            // ��������� ������ � ���������� ��������
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
            // ���� ������ �������� ������ ����� � �������������
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

            $this->response->setTitle('������������ -> ' . $user->getLogin() . ' -> ������ �����');

            return $this->smarty->fetch('user/memberOf.tpl');
        }
    }
}

?>