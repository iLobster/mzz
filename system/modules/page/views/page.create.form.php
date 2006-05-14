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
 * pageCreateForm: форма для метода create модуля page
 *
 * @package page
 * @version 0.1
 */

class pageCreateForm {
    static function getForm()
    {
        require_once 'HTML/QuickForm.php';
        require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';

        $url = new url();
        $url->setAction('create');

        $form = new HTML_QuickForm('form', 'POST', $url->get());

        $form->addElement('text', 'name', 'Name ID:', 'size=30');
        $form->addElement('text', 'title', 'Заголовок:', 'size=30');
        $form->addElement('textarea', 'content', 'Содеражние:', 'rows=7 cols=50');


        //$form->addElement('hidden', 'path', $url->get());
        $form->addElement('reset', 'reset', 'Сброс');
        $form->addElement('submit', 'submit', 'Сохранить');
        return $form;
    }
}

?>
