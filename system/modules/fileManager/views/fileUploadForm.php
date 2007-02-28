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
 * @version 0.1.1
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

        $url = new url('withAnyParam');
        $url->setAction('upload');
        $url->addParam('name', $folder->getPath());
        $form = new HTML_QuickForm('fileUpload', 'POST', $url->get());

        $form->addElement('file', 'file', '����');
        $form->addRule('file', '������������ ����', 'uploadedfile');

        $form->addElement('text', 'name', '����� ���:', 'size="30"');
        $form->addRule('name', '������������ ������� � �����', 'regex', '/^[a-z�-�0-9_\.\-]+$/i');

        $form->addElement('reset', 'reset', '������', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', '���������');
        return $form;
    }
}

?>