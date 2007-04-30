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

fileLoader::load('forms/validators/formValidator');

/**
 * userEditController: ���������� ��� ������ edit ������ user
 *
 * @package modules
 * @subpackage user
 * @version 0.2
 */

class userEditController extends simpleController
{
    public function getView()
    {
        $userMapper = $this->toolkit->getMapper('user', 'user');
        $id = $this->request->get('id', 'integer', SC_PATH | SC_POST);
        $editedUser = $userMapper->searchById($id);

        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');

        if ($isEdit && $editedUser->getId() != $id) {
            return $userMapper->get404()->run();
        }

        $validator = new formValidator();
        $validator->add('required', 'user[login]', '������������ ��� ���������� ����');
        if (!$isEdit) {
            $validator->add('required', 'user[password]', '������������ ��� ���������� ����');
        }

        $validator->add('callback', 'user[login]', '������������ � ����� ������� �� ����������', array('checkUniqueUserLogin', $editedUser, $userMapper));

        if ($validator->validate()) {
            if (!$isEdit) {
                $editedUser = $userMapper->create();
            }

            $info = $this->request->get('user', 'array', SC_POST);

            $editedUser->setLogin((string)$info['login']);
            if (!empty($info['password'])) {
                $editedUser->setPassword((string)$info['password']);
            }

            if (!$isEdit) {
                // ������� ���������� ������������ � ������ � ������ 'is_default'
                $groupMapper = $this->toolkit->getMapper('user', 'group');
                $groups = $groupMapper->searchAllByField('is_default', 1);

                $userMapper->save($editedUser);

                $userGroupMapper = $this->toolkit->getMapper('user', 'userGroup');
                $userGroup = array();

                foreach ($groups as $group) {
                    $userGroup_tmp = $userGroupMapper->create();
                    $userGroup_tmp->setGroup($group);

                    $userGroup[] = $userGroup_tmp;
                }

                $editedUser->setGroups($userGroup);
            }

            $userMapper->save($editedUser);
            return jipTools::redirect();
        }


        if ($isEdit) {
            $url = new url('withId');
            $url->addParam('id', $editedUser->getId());
        } else {
            $url = new url('default2');
        }
        $url->setAction($action);


        $editedUser = ($isEdit) ? $editedUser : $userMapper->create();
        $this->smarty->assign('user', $editedUser);
        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('errors', $validator->getErrors());
        return $this->smarty->fetch('user/edit.tpl');
    }
}

function checkUniqueUserLogin($login, $user, $userMapper)
{
    if ($login === $user->getLogin()) {
        return true;

    }
    $user = $userMapper->searchByLogin($login);
    return ($user->getId() == MZZ_USER_GUEST_ID && $login !== $user->getLogin());
}

?>