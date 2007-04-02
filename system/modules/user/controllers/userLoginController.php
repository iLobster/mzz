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
 * @version 0.2.2
 */
class userLoginController extends simpleController
{
    public function getView()
    {
        $user = $this->toolkit->getUser();

        $prefix = $this->request->get('tplPrefix', 'string');
        if (!empty($prefix)) {
            $prefix .= '/';
        }

        if (!$user->isLoggedIn()) {
            if (strtoupper($this->request->getMethod()) == 'POST') {
                $login = $this->request->get('login', 'string', SC_POST);
                $password = $this->request->get('password', 'string', SC_POST);

                $userMapper = new userMapper('user');
                $user = $userMapper->login($login, $password);

                if ($user->isLoggedIn()) {
                    $save = $this->request->get('save', 'string', SC_POST);
                    if ($save) {
                        $userAuthMapper = $this->toolkit->getMapper('user', 'userAuth', 'user');
                        $userAuthMapper->set($user->getId());
                    }
                    return $this->response->redirect($this->request->get('url', 'string', SC_POST));
                }
            }

            //fileLoader::load('user/forms/userLoginForm');
            //$form = userLoginForm::getForm($this->request->getRequestUrl());
            //$renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
            //$form->accept($renderer);

            //$this->smarty->assign('form', $renderer->toArray());


            $url = new url('default2');
            $url->setSection('user');
            $url->setAction('login');
            $form = array('action' => $url->get(), 'backUrl' => $this->request->getRequestUrl());
            $this->smarty->assign('form', $form);

            $this->smarty->assign('user', null);
            $this->response->setTitle('Пользователь -> Авторизация');

            return $this->smarty->fetch('user/' . $prefix . 'login.tpl');
        }

        $this->smarty->assign('user', $user);
        return $this->smarty->fetch('user/' . $prefix . 'alreadyLogin.tpl');
    }
}

?>