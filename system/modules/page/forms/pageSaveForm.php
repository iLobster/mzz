<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * pageSaveForm: ����� ��� ������ save ������ page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */
class pageSaveForm
{
    /**
     * ����� ��������� �����
     *
     * @param object $page ������ page
     * @param string $section ������� ������
     * @param string $action ������� ��������
     * @param object $pageFolder
     * @param boolean $isEdit true ���� �������� "�������������"
     * @return object ��������������� �����
     */
    static function getForm($page, $section, $action, $pageFolder, $isEdit)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');


        $url = new url('pageActions');
        $url->addParam('name', $pageFolder->getPath() . ($isEdit ? '/' . $page->getName() : ''));
        $url->setAction($action);
        $url->setSection($section);
        $form = new HTML_QuickForm($action, 'POST', $url->get());

        if ($isEdit) {
            $defaultValues = array();
            $defaultValues['name']  = $page->getName();
            $defaultValues['title']  = $page->getTitle();
            $defaultValues['contentArea']  = $page->getContent();
            $form->setDefaults($defaultValues);
        }

        $form->addElement('text', 'name', 'Name ID:', 'size=30');
        $form->addElement('text', 'title', '���������:', 'size=30');
        $form->addElement('textarea', 'contentArea', '����������:', 'rows=15 cols=80 id="contentArea" style="width: 100%;"');

        if ($isEdit) {
            $form->registerRule('isUniqueName', 'callback', 'editPageValidate');
        } else {
            $form->registerRule('isUniqueName', 'callback', 'createPageValidate');
        }

        $form->addRule('name', '��� �������� ������ ���� ��������� � �������� �������� � ��������� ��������� ����� � �����', 'isUniqueName', array($page, $pageFolder));

        $form->addElement('reset', 'reset', '������','onclick=\'javascript: jipWindow.close();\'');
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