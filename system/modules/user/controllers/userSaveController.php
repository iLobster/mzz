<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/user/controllers/userEditController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userEditController.php 2386 2008-02-10 03:28:25Z striker $
 */

/**
 * userEditController: контроллер для метода edit модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.2
 */

class userSaveController extends simpleController
{
    protected function getView()
    {
        $userMapper = $this->toolkit->getMapper('user', 'user');
        $id = $this->request->getInteger('id', SC_PATH | SC_POST);

        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');

        $editedUser = $isEdit ? $userMapper->searchByKey($id) : $userMapper->create();

        if ($isEdit && $editedUser->getId() != $id) {
            return $userMapper->get404()->run();
        }

        $validator = new formValidator();
        $validator->rule('required', 'user[login]', 'Обязательное для заполнения поле');
        if (!$isEdit) {
            $validator->rule('required', 'user[password]', 'Обязательное для заполнения поле');
        }

        $validator->rule('callback', 'user[login]', 'Пользователь с таким логином же существует', array(
            array(
                $this,
                'checkUniqueUserLogin'),
            $editedUser,
            $userMapper));

        if ($validator->validate()) {
            $info = $this->request->getArray('user', SC_POST);

            $editedUser->setLogin((string)$info['login']);
            if (!empty($info['password'])) {
                $editedUser->setPassword((string)$info['password']);
            }
            $userMapper->save($editedUser);

            if (!$isEdit) {
                // добавим созданного пользователя в группы с флагом 'is_default'
                $groupMapper = $this->toolkit->getMapper('user', 'group');

                $userGroups = $editedUser->getGroups();

                foreach ($groupMapper->searchAllByField('is_default', 1) as $group) {
                    $userGroups->add($group);
                }

                $userMapper->save($editedUser);
            }

            return jipTools::redirect();
        }

        if ($isEdit) {
            $url = new url('withId');
            $url->add('id', $editedUser->getId());
        } else {
            $url = new url('default2');
        }
        $url->setAction($action);

        $editedUser = ($isEdit) ? $editedUser : $userMapper->create();
        $this->smarty->assign('user', $editedUser);
        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('validator', $validator);
        return $this->smarty->fetch('user/save.tpl');
    }

    function checkUniqueUserLogin($login, $user, $userMapper)
    {
        if ($login === $user->getLogin()) {
            return true;

        }
        $user = $userMapper->searchByLogin($login);
        return is_null($user);
    }
}

?>