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
 * newsSaveFolderForm: ����� ��� ������ saveFolder ������ news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */
class newsSaveFolderForm
{
    static function getForm($folder, $newsFolderMapper, $action, $targetFolder, $isEdit)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('newsFolder');
        $url->addParam('name', $folder);
        $url->setAction($action);

        $form = new HTML_QuickForm('createFolder', 'POST', $url->get());

        $defaultValues = array();

        if ($isEdit) {
            $defaultValues['name'] = $targetFolder->getName();
            $defaultValues['title'] = $targetFolder->getTitle();
        }

        $defaultValues['label'] = $folder;
        $form->setDefaults($defaultValues);

        $label = $form->addElement('text', 'label', '��� �����������', 'size=30');
        $label->freeze();
        $form->addElement('text', 'name', '���:', 'size=30');
        $form->addElement('text', 'title', '��������:', 'size=30');


        $form->addRule('name', '������������ ����', 'required');
        $form->addRule('name', '������ ���������-�������� �������', 'regex', '/[^\W\d][\w\d_]*/');

        if ($isEdit) {
            $form->registerRule('isUniqueName', 'callback', 'editFolderValidate');
        } else {
            $form->registerRule('isUniqueName', 'callback', 'createFolderValidate');
        }

        $form->addRule('name', '��� ������ ���� ��������� � �������� �������� � ��������� ��������� ����� � �����', 'isUniqueName', array($folder, $newsFolderMapper));

        $form->addElement('reset', 'reset', '������', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', '���������');

        return $form;
    }
}

function createFolderValidate($name, $data)
{
    if (preg_match('/[^a-z0-9_\-]/i', $name)) {
        return false;
    }

    return is_null($data[1]->searchByPath($data[0] . '/' . $name));
}

function editFolderValidate($name, $data)
{
    if (preg_match('/[^a-z0-9_\-]/i', $name)) {
        return false;
    }
    $data[0] = explode('/', $data[0]);
    $current = array_pop($data[0]);

    return $current == $name || is_null($data[1]->searchByPath(implode('/', $data[0]) . '/' . $name));
}

?>