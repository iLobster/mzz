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
     * @param string $action ������� ��������
     * @param object $pageFolder
     * @return object ��������������� �����
     */
    static function getForm($page, $section, $action, $pageFolder)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $formAction = '/' . $section . '/' . $pageFolder->getPath() . ($action == 'edit' ? '/' . $page->getName() : '') . '/' . $action;
        $form = new HTML_QuickForm('form', 'POST', $formAction);

        if ($action == 'edit') {
            $defaultValues = array();
            $defaultValues['name']  = $page->getName();
            $defaultValues['title']  = $page->getTitle();
            $defaultValues['content']  = $page->getContent();
            $form->setDefaults($defaultValues);
        }

        $form->addElement('text', 'name', 'Name ID:', 'size=30');
        $form->addElement('text', 'title', '���������:', 'size=30');
        $form->addElement('textarea', 'content', '����������:', 'rows=15 cols=80 id="content" style="width: 100%;"');

        if ($action == 'edit') {
            $form->registerRule('isUniqueName', 'callback', 'editPageValidate');
        } else {
            $form->registerRule('isUniqueName', 'callback', 'createPageValidate');
        }

        $form->addRule('name', '��� �������� ������ ���� ��������� � �������� �������� � ��������� ��������� ����� � �����', 'isUniqueName', array($page, $pageFolder));

        $form->addElement('reset', 'reset', '������','onclick=\'javascript: hideJip();\'');
        $form->addElement('submit', 'submit', '���������');
        return $form;
    }
}

function createPageValidate($name, $data)
{
    if (preg_match('/[^a-z0-9_\-]/i', $name)) {
        return false;
    }

    $toolkit = systemToolkit::getInstance();
    $pageMapper = $toolkit->getMapper('page', 'page');

    $criteria = new criteria();
    $criteria->add('name', $name)->add('folder_id', $data[1]->getId());
    return is_null($pageMapper->searchOneByCriteria($criteria));
}

function editPageValidate($name, $data)
{
    if (preg_match('/[^a-z0-9_\-]/i', $name)) {
        return false;
    }

    $toolkit = systemToolkit::getInstance();
    $pageMapper = $toolkit->getMapper('page', 'page');

    $criteria = new criteria();
    $criteria->add('name', $name)->add('folder_id', $data[1]->getId());

    return $data[0]->getName() == $name || is_null($pageMapper->searchOneByCriteria($criteria));
}

?>
