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
 * userMembersListController: ���������� ��� ������ membersList ������ user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userMembersListController extends simpleController
{
    public function getView()
    {
        if (($id = $this->request->get('id', 'integer', SC_PATH)) == null) {
            $id = $this->request->get('id', 'integer', SC_POST);
        }

        $userGroupMapper = $this->toolkit->getMapper('user', 'userGroup');
        $groupMapper = $this->toolkit->getMapper('user', 'group');

        $group = $groupMapper->searchById($id);

        // ��������� ��� ������� ������ ������
        if (is_null($group)) {
            fileLoader::load('user/views/group404View');
            return new group404View();
        }

        if ($this->request->getMethod() == 'POST') {
            // ���� ���� ���������� �����
            $users = $this->request->get('users', 'array', SC_POST);

            if (is_null($users)) {
                $users = array();
            }

            $usersArray = array();

            // ��������� ������ � ���������� ��������������
            foreach (array_keys($users) as $val) {
                $criteria = new criteria();
                $criteria->add('group_id', $id)->add('user_id', $val);
                $userGroup = $userGroupMapper->searchOneByCriteria($criteria);

                if (!is_null($userGroup)) {
                    $userGroupMapper->delete($userGroup->getId());
                }
            }

            //return new simpleJipCloseView();
            return jipTools::closeWindow(0, true);
        } else {
            $criteria = new criteria();
            $criteria->add('group_id', $id)->setOrderByFieldAsc('user_id.login');
            $users = $userGroupMapper->searchAllByCriteria($criteria);

            $this->smarty->assign('users', $users);
            $this->smarty->assign('group', $group);
            $this->response->setTitle('������ -> ' . $group->getName() . ' -> ������ �������������');
            return $this->smarty->fetch('user/membersList.tpl');
        }
    }
}

?>