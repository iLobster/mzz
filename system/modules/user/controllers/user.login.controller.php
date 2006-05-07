<?php
//
// $Id: news.view.controller.php 451 2006-02-06 18:29:50Z zerkms $
// $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/modules/news/controllers/news.view.controller.php $
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
 * @version 0.1
 */

class userLoginController
{
    public function __construct()
    {
        fileLoader::load('user/views/user.login.view');
        fileLoader::load('user/views/user.login.form');
        fileLoader::load("user");
        fileLoader::load("user/mappers/userMapper");
    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();

        $user = $toolkit->getUser();

        if ($user->getId() == 1) {
            if (strtoupper($httprequest->getMethod()) == 'POST') {
                $login = $httprequest->get('login', SC_POST);
                $password = $httprequest->get('password', SC_POST);

                $userMapper = new userMapper('user');
                $user = $userMapper->login($login, $password);

                if ($user->getId() != 1) {
                    fileLoader::load('user/views/user.login.success.view');
                    return new userLoginSuccessView($httprequest->get('url', SC_POST));
                }
            }

            $form = userLoginForm::getForm($httprequest->getUrl());
            return new userViewView($form);
        }

        fileLoader::load('user/views/user.login.already.view');
        return new userLoginAlreadyView($user);
    }
}

?>
