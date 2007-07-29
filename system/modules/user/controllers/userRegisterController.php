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
 * userRegisterController: ���������� ��� ������ register ������ user
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
        $user = $this->toolkit->getUser();

        //if ($user->isLoggedIn()) {
            //$controller = new messageController('��� �� ��������� �����������', messageController::INFO);
            //return $controller->run();
        //}

        $userId = $this->request->get('user', 'integer', SC_GET);
        $confirm = $this->request->get('confirm', 'string', SC_GET);

        if (empty($userId) || empty($confirm)) {
            $validator = new formValidator();
            $validator->add('required', 'login', '���������� ������� �����');
            $validator->add('required', 'password', '���������� ������� ������');
            $validator->add('required', 'email', '���������� ������� �������� e-mail');
            $validator->add('Regex', 'email', '���������� ������� ���������� e-mail', '/^((\"[^\"\f\n\r\t\v\b]+\")|([\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+(\.[\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+)*))@((\[(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))\])|(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))|((([A-Za-z0-9\-])+\.)+[A-Za-z\-]+))$/');
            $validator->add('required', 'repassword', '���������� ������� ������ ������');
            $validator->add('callback', 'login', '������������ � ����� ������� ��� ����������', array('checkUniqueUserLogin', $userMapper));
            $validator->add('callback', 'repassword', '������ ������ �� ���������', array('checkRepass', $this->request->get('password', 'string', SC_POST)));

            $url = new url('default2');
            $url->setAction('register');

            if (!$validator->validate()) {
                $this->smarty->assign('action', $url->get());
                $this->smarty->assign('errors', $validator->getErrors());
                return $this->smarty->fetch('user/register.tpl');
            } else {
                $login = $this->request->get('login', 'string', SC_POST);
                $password = $this->request->get('password', 'string', SC_POST);
                $email = $this->request->get('email', 'string', SC_POST);

                $user = $userMapper->create();
                $user->setLogin($login);
                $user->setPassword($password);
                $user->setCreated(mktime());
                $confirm = md5($email . mktime());
                $user->setConfirmed($confirm);
                $userMapper->save($user);

                $url->add('user', $user->getId(), true);
                $url->add('confirm', $confirm, true);
                $this->smarty->assign('url', $url->get());

                if (mail($email, '������������� �����������', $this->smarty->fetch('user/mail.tpl'))) {
                    return $this->smarty->fetch('user/success.tpl');
                } else {
                    return '������... �� ���� �� ��������. ������� ��������? ����������� �� mzzMail';
                }
            }
        } else {
            $criteria = new criteria;
            $criteria->add('id', $userId)->add('confirmed', $confirm);
            $user = $userMapper->searchOneByCriteria($criteria);

            if ($user) {
                $user->setConfirmed('');
                $userMapper->save($user);
                return '����������� ������������';
            } else {
                return '��� ������ ������������';
            }
        }
    }
}

function checkUniqueUserLogin($login, $userMapper)
{
    $user = $userMapper->searchByLogin($login);
    return ($user->getId() == MZZ_USER_GUEST_ID && $login !== $user->getLogin());
}

function checkRepass($repassword, $password)
{
    return $password == $repassword;
}

?>