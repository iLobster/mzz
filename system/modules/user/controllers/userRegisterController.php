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
 * userRegisterController: контроллер для метода register модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

class userRegisterController extends simpleController
{
    protected function getView()
    {
        $userMapper = $this->toolkit->getMapper('user', 'user');

        $userId = $this->request->getInteger('user', SC_GET);
        $confirm = $this->request->getString('confirm', SC_GET);

        if (empty($userId) || empty($confirm)) {
            $validator = new formValidator();
            $validator->rule('required', 'login', 'Необходимо указать логин');
            $validator->rule('required', 'password', 'Необходимо указать пароль');
            $validator->rule('required', 'email', 'Необходимо указать обратный e-mail');
            $validator->rule('email', 'email', 'Необходимо указать правильный e-mail');
            $validator->rule('required', 'repassword', 'Необходимо указать повтор пароль');
            $validator->rule('callback', 'login', 'Пользователь с таким логином уже существует', array(array($this, 'checkUniqueUserLogin'), $userMapper));
            $validator->rule('callback', 'email', 'Пользователь с таким email уже существует', array(array($this, 'checkUniqueUserEmail'), $userMapper));
            $validator->rule('callback', 'repassword', 'Повтор пароля не совпадает', array(array($this, 'checkRepass'), $this->request->getString('password', SC_POST)));

            $url = new url('default2');
            $url->setAction('register');

            if ($validator->validate()) {
                $login = $this->request->getString('login', SC_POST);
                $password = $this->request->getString('password', SC_POST);
                $email = $this->request->getString('email', SC_POST);

                $user = $userMapper->create();
                $user->setLogin($login);
                $user->setEmail($email);
                $user->setPassword($password);
                $user->setCreated(mktime());
                $confirm = md5($email . mktime());
                $user->setConfirmed($confirm);
                $userMapper->save($user);

                $this->smarty->assign('confirm', $confirm);
                $this->smarty->assign('user', $user);
                $body = $this->smarty->fetch('user/register/mailbody.tpl');

                fileLoader::load('service/mailer/mailer');
                $mailer = mailer::factory();

                $mailer->set($user->getEmail(), $user->getLogin(), 'noreply@mzz.ru', 'mzz', 'Подтверждение регистрации', $body);
                $mailer->send();

                return $this->smarty->fetch('user/register/success.tpl');
            }

            $this->smarty->assign('form_action', $url->get());
            $this->smarty->assign('validator', $validator);
            return $this->smarty->fetch('user/register/form.tpl');

        } else {
            $criteria = new criteria;
            $criteria->where('id', $userId)->where('confirmed', $confirm);
            $user = $userMapper->searchOneByCriteria($criteria);

            if ($user) {
                $user->setConfirmed('');
                $userMapper->save($user);

                $groupMapper = $this->toolkit->getMapper('user', 'group');
                $groups = $groupMapper->searchDefaultGroups();

                $userGroupMapper = $this->toolkit->getMapper('user', 'userGroup');

                foreach ($groups as $group) {
                    $userGroup = $userGroupMapper->create();
                    $userGroup->setGroup($group);
                    $userGroup->setUser($user);
                    $userGroupMapper->save($userGroup);
                }

                return $this->smarty->fetch('user/register/confirmed.tpl');
            } else {
                return $this->smarty->fetch('user/register/confirmNoNeed.tpl');
            }
        }
    }

    function checkUniqueUserLogin($login, $userMapper)
    {
        $user = $userMapper->searchByLogin($login);
        return is_null($user);
    }

    function checkUniqueUserEmail($email, $userMapper)
    {
        $user = $userMapper->searchByEmail($email);
        return is_null($user);
    }

    function checkRepass($repassword, $password)
    {
        return $password == $repassword;
    }
}

?>