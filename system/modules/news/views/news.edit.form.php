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
 * newsEditForm: ����� ��� ������ edit ������ news
 *
 * @package news
 * @version 0.1
 */

class newsEditForm {
    static function getForm($news)
    {
        require_once 'HTML/QuickForm.php';
        require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';

        // ��������� ������ ����� �� � ����� ???
        //$data = $tableModule->getNews($params[0]);

        $form = new HTML_QuickForm('form', 'POST');
        $defaultValues = array();
        $defaultValues['title']  = $news->getTitle();
        $defaultValues['text']  = $news->getText();
        $form->setDefaults($defaultValues);

        $form->addElement('text', 'title', '���:', 'size=30');
        $form->addElement('textarea', 'text', '�����:', 'rows=7 cols=50');
        $form->addElement('hidden', 'path', '/news/edit');
        $form->addElement('hidden', 'id', $news->getId());
        $form->addElement('reset', 'reset', '������','onclick=\'javascript: window.close();\'');
        $form->addElement('submit', 'submit', '���������');
        return $form;
    }
}

?>
