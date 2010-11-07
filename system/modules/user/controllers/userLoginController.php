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

fileLoader::load('user/pam/pam');

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
        $tplPath = $this->request->getString('tplPath');
        $pamProvider = $this->request->getString('pam');

        if (!$user->isLoggedIn()) {
            $validator = new formValidator();
            $pam = pam::factory($pamProvider);

            $pam->validate($validator);

            if (!$this->request->getBoolean('onlyForm') && $validator->validate()) {
                $user = $pam->login();

                if (!$user || !$user->isConfirmed()) {
                    $validator->setError('login', 'Wrong login or password');
                } else {
                    $this->toolkit->setUser($user);
                    if ($this->request->getBoolean('save', SC_POST)) {
                        $this->rememberUser($user);
                    }

                    if (!$backURL) {
                        $url = new url('default');
                        $backURL = $url->get();
                    }

                    return $this->redirect($backURL);
                }
            }

            $url = new url('default2');
            $url->setModule('user');
            $url->setAction('login');
            $this->view->assign('form_action', $url->get());
            $this->view->assign('validator', $validator);
            $this->view->assign('backURL', $backURL);

            return ($tplPath) ? $this->view->render($tplPath . 'loginForm.tpl') : $this->render('user/loginForm.tpl');
        }

        $this->view->assign('user', $user);
        return ($tplPath) ? $this->view->render($tplPath . 'alreadyLogin.tpl') : $this->render('user/alreadyLogin.tpl');
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