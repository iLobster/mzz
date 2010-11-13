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

        if (!$user->isLoggedIn()) {
            $validator = new formValidator();
            $pamProvider = $this->request->getString('pam');

            $pam = pam::factory($pamProvider);

            if ($pam->validate($validator)) {
                $user = $pam->login();

                if (!$user) {
                    var_dump($user);
                    $validator->setError('login', 'Wrong login or password');
                } else {
                    $this->toolkit->setUser($user);
                    
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



}

?>