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
 * newsCreateForm: ����� ��� ������ create ������ news
 *
 * @package news
 * @version 0.1
 */

class newsCreateForm {
    static function getForm($folder)
    {
        require_once 'HTML/QuickForm.php';
        require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';

        $form = new HTML_QuickForm('form', 'POST');

        $form->addElement('text', 'title', '���:', 'size=30');
        $form->addElement('textarea', 'text', '�����:', 'rows=7 cols=50');

        $url = new url();
        $url->addParam($folder);
        $url->setAction('createItem');

        $form->addElement('hidden', 'path', $url->get());
        $form->addElement('reset', 'reset', '�����');
        $form->addElement('submit', 'submit', '���������');
        return $form;
    }
}

?>
