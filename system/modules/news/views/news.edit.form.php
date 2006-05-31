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

class newsEditForm
{
    /**
     * ����� ��������� �����
     *
     * @param object $news ������ ��������
     * @param string $section ������� ������
     * @return object ��������������� �����
     */
    static function getForm($news, $section)
    {
        require_once 'HTML/QuickForm.php';
        require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';

        $form = new HTML_QuickForm('newsEdit', 'POST', '/' . $section . '/' . $news->getId() . '/edit');
        $defaultValues = array();
        $defaultValues['title']  = $news->getTitle();
        $defaultValues['text']  = $news->getText();
        $form->setDefaults($defaultValues);

        $form->addElement('text', 'title', '���:', 'size=30');
        $form->addElement('textarea', 'text', '�����:', 'rows=7 cols=50');

        $form->addElement('reset', 'reset', '������','onclick=\'javascript: window.close();\'');
        $form->addElement('submit', 'submit', '���������');
        return $form;
    }
}

?>
