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
 * newsCreateForm: ����� ��� ������ create ������ news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

class newsCreateFolderForm
{
    static function getForm($folder, $newsFolderMapper, $action, $targetFolder)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url();
        $url->addParam($folder);
        $url->setAction($action);

        $form = new HTML_QuickForm('createFolder', 'POST', $url->get());

        $defaultValues = array();

        if ($action == 'editFolder') {
            $defaultValues['name'] = $targetFolder->getName();
        }

        $defaultValues['label'] = $folder;
        $form->setDefaults($defaultValues);

        $label = $form->addElement('text', 'label', '��� �����������', 'size=30');
        $label->freeze();
        $form->addElement('text', 'name', '���:', 'size=30');


        $form->addRule('name', '������������ ����', 'required');
        $form->addRule('name', '������ ���������-�������� �������', 'regex', '/\w[\w\d_]+/');

        $form->registerRule('isUniqueName', 'callback', 'createFolderValidate');
        $form->addRule('name', '��� ������ ���� ��������� � �������� ��������', 'isUniqueName', array($folder, $newsFolderMapper));

        $form->addElement('reset', 'reset', '�����');
        $form->addElement('submit', 'submit', '���������');

        return $form;
    }
}

function createFolderValidate($name, $data)
{
    return is_null($data[1]->searchByPath($data[0] . '/' . $name));
}

?>
