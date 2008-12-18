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
 * @version 0.2.3
 */
class userLoginController extends simpleController
{
    protected function getView()
    {
        $user = $this->toolkit->getUser();

        $backURL = $this->request->getString('url', SC_POST);

        if (!$user->isLoggedIn()) {
            if ($this->request->isMethod('POST')) {
                $login = $this->request->getString('login', SC_POST);
                $password = $this->request->getString('password', SC_POST);

                $userMapper = $this->toolkit->getMapper('user', 'user');
                $user = $userMapper->login($login, $password);

                if ($user->isLoggedIn()) {
                    $save = $this->request->getBoolean('save', SC_POST);
                    if ($save) {
                        $userAuthMapper = $this->toolkit->getMapper('user', 'userAuth', 'user');
                        $userAuthMapper->set($user->getId());
                    }

                    return $this->redirect($backURL);
                }
            }


            $url = new url('default2');
            $url->setSection('user');
            $url->setAction('login');
            $this->smarty->assign('form_action', $url->get());
            $this->smarty->assign('backURL', $backURL);
            $this->smarty->assign('user', null);

            return $this->fetch('user/login.tpl');
        }

        /*if (strtoupper($this->request->getMethod()) == 'POST') {
            // @todo: если нет урла - редиректить на главную
            return $this->response->redirect($this->request->getString('url', SC_POST));
        }*/

        $this->smarty->assign('user', $user);
        return $this->fetch('user/alreadyLogin.tpl');
    }
}

?>