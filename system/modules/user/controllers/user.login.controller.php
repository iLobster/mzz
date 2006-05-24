<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * userLoginController: контроллер для метода login модуля user
 *
 * @package user
 * @version 0.2.2
 */

class userLoginController extends simpleController
{
    public function __construct()
    {
        fileLoader::load("user");
        fileLoader::load("user/mappers/userMapper");
        parent::__construct();
    }

    public function getView()
    {
        $user = $this->toolkit->getUser();

        if (!$user->isLoggedIn()) {
            if (strtoupper($this->request->getMethod()) == 'POST') {
                $login = $this->request->get('login', SC_POST);
                $password = $this->request->get('password', SC_POST);

                $userMapper = new userMapper('user');
                $user = $userMapper->login($login, $password);

                if ($user->isLoggedIn()) {
                    fileLoader::load('user/views/user.login.success.view');
                    return new userLoginSuccessView($this->request->get('url', SC_POST));
                }
            }

            fileLoader::load('user/views/user.loginform.view');
            fileLoader::load('user/views/user.login.form');

            $form = userLoginForm::getForm($this->request->getUrl());

            return new userLoginformView($form);
        }

        fileLoader::load('user/views/user.login.already.view');
        return new userLoginAlreadyView($user);
    }
}

?>
