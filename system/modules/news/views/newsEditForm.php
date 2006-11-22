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
     * @param object $newsMapper
     * @return object ��������������� �����
     */
    static function getForm($news, $section, $action, $newsMapper)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $formAction = '/' . $section . ($action == 'edit' ? '/' . $news->getId() : '') . '/' . $action;
        $form = new HTML_QuickForm('newsEdit', 'POST', $formAction);

        if ($action == 'edit') {
            $defaultValues = array();
            $defaultValues['title']  = $news->getTitle();
            $defaultValues['text']  = $news->getText();
            $form->setDefaults($defaultValues);
        }

        $form->addElement('text', 'title', '���:', 'size=30');
        $form->addElement('textarea', 'text', '�����:', 'rows=7 cols=50');

        $form->addElement('reset', 'reset', '������', 'onclick="javascript: hideJip();"');
        $form->addElement('submit', 'submit', '���������');
        return $form;
    }
}

?>
