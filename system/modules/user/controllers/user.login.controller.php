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
        fileLoader::load("user");
        fileLoader::load("user/mappers/userMapper");
    }

    public function getView()
    {
        $userMapper = new userMapper('user');
        
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();

        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
        
        if ($user_id) {
            $user = $userMapper->searchById($user_id);
        } else {
            $login = $httprequest->get('login', SC_POST);
            $password = $httprequest->get('password', SC_POST);
            $user = $userMapper->login($login, $password);
        }
        if ($user === false) {

                require_once 'HTML/QuickForm.php';
                require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';

                $form = new HTML_QuickForm('form', 'POST', '/');
                $defaultValues = array();
                $defaultValues['title']  = 'title';
                $defaultValues['text']  = 'text';
                $form->setDefaults($defaultValues);

                $form->addElement('text', 'login', 'Имя:', 'size=30');
                $form->addElement('password', 'password', 'Пароль:', 'size=30');

                $form->addElement('reset', 'reset', 'Отмена','onclick=\'javascript: window.close();\'');
                $form->addElement('submit', 'submit', 'Отправить');
                
                return new userViewView($form);
                
        } else {
            fileLoader::load('user/views/user.login.success.view');
            return new userLoginSuccessView($user);
        }
    }
}

?>
