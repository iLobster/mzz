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
 * @package modules
 * @subpackage user
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
                $login = $this->request->get('login', 'string', SC_POST);
                $password = $this->request->get('password', 'string', SC_POST);

                $userMapper = new userMapper('user');
                $user = $userMapper->login($login, $password);

                if ($user->isLoggedIn()) {
                    fileLoader::load('user/views/userLoginSuccessView');
                    return new userLoginSuccessView($this->request->get('url', 'string', SC_POST));
                }
            }

            fileLoader::load('user/views/userLoginformView');
            fileLoader::load('user/views/userLoginForm');

            $form = userLoginForm::getForm($this->request->getUrl());

            return new userLoginformView($form);
        }

        fileLoader::load('user/views/userLoginAlreadyView');
        return new userLoginAlreadyView($user);
    }
}

?>
