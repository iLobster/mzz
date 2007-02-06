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
 * fileUploadForm: ����� ��� ������ upload ������ fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class fileUploadForm
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
    static function getForm($folder)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url();
        $url->setAction('upload');
        $url->addParam('path', $folder->getPath());
        $form = new HTML_QuickForm('fileUpload', 'POST', $url->get());
        /*
        if ($action == 'edit') {
        $defaultValues = array();
        $defaultValues['title']  = $news->getTitle();
        $defaultValues['text']  = $news->getText();
        $form->setDefaults($defaultValues);
        }*/
        /*
        $form->addElement('text', 'title', '���:', 'size="30"');
        $form->addElement('text', 'created', '���� ��������:', 'size="30" id="calendar-field-created"');
        $form->addElement('textarea', 'text', '�����:', 'rows="7" cols="50"');*/

        $form->addElement('file', 'file', '����');

        $form->addElement('reset', 'reset', '������', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', '���������');
        return $form;
    }
}

?>