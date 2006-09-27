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
 * pageEditForm: ����� ��� ������ edit ������ page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */

class pageEditForm
{
    /**
     * ����� ��������� �����
     *
     * @param object $page ������ page
     * @param string $section ������� ������
     * @return object ��������������� �����
     */
    static function getForm($page, $section)
    {
        require_once 'HTML/QuickForm.php';
        require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';

        $form = new HTML_QuickForm('form', 'POST', '/' . $section . '/' . $page->getName() . '/edit');
        $defaultValues = array();
        $defaultValues['name']  = $page->getName();
        $defaultValues['title']  = $page->getTitle();
        $defaultValues['content']  = $page->getContent();
        $form->setDefaults($defaultValues);

        $form->addElement('text', 'name', 'Name ID:', 'size=30');
        $form->addElement('text', 'title', '���������:', 'size=30');
        $form->addElement('textarea', 'content', '����������:', 'rows=7 cols=50');

        $form->addElement('reset', 'reset', '������','onclick=\'javascript: window.close();\'');
        $form->addElement('submit', 'submit', '���������');
        return $form;
    }
}

?>
