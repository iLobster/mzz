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
 * userLoginFormController: контроллер для метода loginForm модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 * @deprecated not in use
 */
class userLoginFormController extends simpleController
{
    protected function getView()
    {
        $user = $this->toolkit->getUser();

        $prefix = $this->request->getString('tplPrefix');
        if (!empty($prefix)) {
            $prefix .= '/';
        }

        if (!$user->isLoggedIn()) {
            $url = new url('default2');
            $url->setModule('user');
            $url->setAction('login');
            $this->smarty->assign('form_action', $url->get());
            $this->smarty->assign('backURL', $this->request->getRequestUrl());
            $this->smarty->assign('user', null);

            return $this->smarty->fetch('user/' . $prefix . 'loginForm.tpl');
        }
        $this->smarty->assign('user', $user);
        return $this->smarty->fetch('user/' . $prefix . 'alreadyLogin.tpl');
    }
}

?>