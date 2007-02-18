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
 * @package modules
 * @subpackage news
 * @version 0.1
 */

class newsEditForm
{
    /**
     * ����� ��������� �����
     *
     * @param object $news ������ ��������
     * @param string $section ������� ������
     * @param string $action ������� ��������
     * @param newsFolder $newsFolder �����, � ������� ������ �������
     * @return object ��������������� �����
     */
    static function getForm($news, $section, $action, $newsFolder)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url();
        $url->setSection($section);
        $url->setAction($action);
        $url->addParam('id', $action == 'edit' ? $news->getId() : $newsFolder->getPath());
        $form = new HTML_QuickForm('newsEdit', 'POST', $url->get());

        $defaultValues = array();
        if ($action == 'edit') {
            $defaultValues = array();
            $defaultValues['title']  = $news->getTitle();
            $defaultValues['text']  = $news->getText();
            $defaultValues['created']  = date('H:i:s d/m/Y', $news->getCreated());
        } else {
            $defaultValues['created']  = date('H:i:s d/m/Y');
            $form->addElement('text', 'created', '���� ��������:', 'size="20" id="calendar-field-created"');
            $form->addRule('created', '���������� ������� ����', 'required');
            $form->addRule('created', '���������� ������ ����: ��:�:� �/�/� ', 'regex', '#^([01][0-9]|[2][0-3]):([0-5][0-9]):([0-5][0-9])\s(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])[/](19|20)\d{2}$#');
        }
        $form->setDefaults($defaultValues);

        $form->addElement('text', 'title', '��������:', 'size="60"');
        $form->addElement('textarea', 'text', '����������:', 'rows="7" cols="50"');

        $form->addElement('reset', 'reset', '������', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', '���������');

        $form->addRule('title', '���������� ������� �������', 'required');

        return $form;
    }
}

?>