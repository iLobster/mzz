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
 * userLoginForm ����� ��� ������ login ������ user
 *
 * @package user
 * @version 0.1
 */

class userLoginForm {
    static function getForm($backUrl)
    {
        require_once 'HTML/QuickForm.php';
        require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';

        $url = new url();
        $url->setSection('user');
        $url->setAction('login');

        $form = new HTML_QuickForm('userLogin', 'POST', $url->get());

        $form->addElement('text', 'login', '���:', 'size=30');
        $form->addElement('password', 'password', '������:', 'size=30');
        $form->addElement('hidden', 'url', $backUrl);

        $form->addElement('reset', 'reset', '�����');
        $form->addElement('submit', 'submit', '����');

        return $form;
    }
}

?>
