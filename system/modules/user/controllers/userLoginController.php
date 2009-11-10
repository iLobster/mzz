<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * userLoginController: контроллер для метода login модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.2.4
 */
class userLoginController extends simpleController
{
    protected function getView()
    {
        $user = $this->toolkit->getUser();
        $backURL = $this->request->getString('url', SC_POST);

        if (!$user->isLoggedIn()) {
            $validator = new formValidator();
            $validator->rule('required', 'login', 'Login field is required');
            $validator->rule('required', 'password', 'Password field is required');

            if (!$this->request->getBoolean('onlyForm') && $validator->validate()) {
                $login = $this->request->getString('login', SC_POST);
                $password = $this->request->getString('password', SC_POST);

                $userMapper = $this->toolkit->getMapper('user', 'user');
                $user = $userMapper->login($login, $password);

                if ($user instanceof user) {
                    $this->toolkit->setUser($user);
                    if ($this->request->getBoolean('save', SC_POST)) {
                        $this->rememberUser($user);
                    }

                    if (!$backURL) {
                        $url = new url('default');
                        $backURL = $url->get();
                    }

                    return $this->redirect($backURL);
                } else {
                    $validator->setError('login', 'Wrong login or password');
                    $errors['login'] = 'Wrong login or password';
                    //userMapper::NOT_CONFIRMED || userMapper::WRONG_AUTH_DATA
                }
            } else {
                $errors = $validator->getErrors();
            }

            $url = new url('default2');
            $url->setModule('user');
            $url->setAction('login');
            $this->smarty->assign('form_action', $url->get());
            $this->smarty->assign('validator', $validator);
            $this->smarty->assign('backURL', $backURL);

            return $this->fetch('user/loginForm.tpl');
        }

        $this->smarty->assign('user', $user);
        return $this->fetch('user/alreadyLogin.tpl');
    }

    protected function rememberUser($user)
    {
        $userAuthMapper = $this->toolkit->getMapper('user', 'userAuth');
        $hash = $this->request->getString(userAuthMapper::AUTH_COOKIE_NAME, SC_COOKIE);
        $ip = $this->request->getServer('REMOTE_ADDR');
        $userAuth = $userAuthMapper->saveAuth($user, $hash, $ip);

        $this->response->setCookie(userAuthMapper::AUTH_COOKIE_NAME, $userAuth->getHash(), time() + 10 * 365 * 86400, '/');
    }
}

?>