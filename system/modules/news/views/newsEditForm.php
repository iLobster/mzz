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

        if ($action == 'edit') {
            $defaultValues = array();
            $defaultValues['title']  = $news->getTitle();
            $defaultValues['text']  = $news->getText();
            $form->setDefaults($defaultValues);
        }

        $form->addElement('text', 'title', '���:', 'size="30"');
        $form->addElement('text', 'created', '���� ��������:', 'size="30" id="calendar-field-created"');
        $form->addElement('textarea', 'text', '�����:', 'rows="7" cols="50"');

        $form->addElement('reset', 'reset', '������', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', '���������');
        return $form;
    }
}

?>