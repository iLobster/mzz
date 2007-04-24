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
 */
class userLoginFormController extends simpleController
{
    public function getView()
    {
        $user = $this->toolkit->getUser();

        $prefix = $this->request->get('tplPrefix', 'string');
        if (!empty($prefix)) {
            $prefix .= '/';
        }

        if (!$user->isLoggedIn()) {
            $url = new url('default2');
            $url->setSection('user');
            $url->setAction('login');
            $form = array('action' => $url->get(), 'backUrl' => $this->request->getRequestUrl());
            $this->smarty->assign('form', $form);
            $this->smarty->assign('user', null);

            return $this->smarty->fetch('user/' . $prefix . 'loginForm.tpl');
        }
        $this->smarty->assign('user', $user);
        return $this->smarty->fetch('user/' . $prefix . 'alreadyLogin.tpl');
    }
}

?>