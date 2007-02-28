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
 * userLoginForm форма для метода login модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1.1
 */

class userLoginForm
{
    static function getForm($backUrl)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('default2');
        $url->setSection('user');
        $url->setAction('login');

        $form = new HTML_QuickForm('userLogin', 'POST', $url->get());

        $form->addElement('text', 'login', 'Имя:', 'size=10');
        $form->addElement('password', 'password', 'Пароль:', 'size=10');
        $form->addElement('advcheckbox', 'save', null, 'Запомнить');
        $form->addElement('hidden', 'url', (string)$backUrl);

        $form->addElement('submit', 'submit', 'Вход');

        return $form;
    }
}

?>