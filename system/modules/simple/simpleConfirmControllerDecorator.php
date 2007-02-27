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
 * simpleConfirmControllerDecorator
 *
 * @package modules
 * @subpackage simple
 * @version 0.1
 */

abstract class simpleConfirmControllerDecorator extends simpleController
{
    protected $message = 'Вы хотите выполнить это действие?';

    abstract function confirmed();

    public function getView()
    {
        $confirm = $this->request->get('_confirm', 'string', SC_GET);
        $session = $this->toolkit->getSession();
        if (!empty($confirm) && $confirm == $session->get('confirm_code')) {
            $session->destroy('confirm_code');
            return $this->confirmed();
        }
        $session->set('confirm_code', $code = md5(microtime()));
        $url = $this->request->getRequestUrl();
        $url = $url . (strpos($url, '?') ? '&' : '?') . '_confirm=' . $code;

        $this->smarty->assign('url', $url);
        $this->smarty->assign('message', $this->message);
        return $this->smarty->fetch('confirm.tpl');
    }
}

?>