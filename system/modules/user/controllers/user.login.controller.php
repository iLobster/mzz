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

class userLoginController
{
    public function __construct()
    {
        fileLoader::load("user");
        fileLoader::load("user/mappers/userMapper");
    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();

        $user = $toolkit->getUser();

        if (!$user->isLoggedIn()) {
            if (strtoupper($httprequest->getMethod()) == 'POST') {
                $login = $httprequest->get('login', SC_POST);
                $password = $httprequest->get('password', SC_POST);

                $userMapper = new userMapper('user');
                $user = $userMapper->login($login, $password);

                if ($user->isLoggedIn()) {
                    fileLoader::load('user/views/user.login.success.view');
                    return new userLoginSuccessView($httprequest->get('url', SC_POST));
                }
            }

            fileLoader::load('user/views/user.loginform.view');
            fileLoader::load('user/views/user.login.form');

            $start = microtime(1);
            echo __FILE__ . ' : <br>&lt;' . __LINE__ . '&gt;<br>';
            $form = userLoginForm::getForm($httprequest->getUrl());
            echo microtime(1) - $start;
            echo '<br>&lt;/' . __LINE__ . '&gt;<br>';

            return new userLoginformView($form);
        }

        fileLoader::load('user/views/user.login.already.view');
        return new userLoginAlreadyView($user);
    }
}

?>
