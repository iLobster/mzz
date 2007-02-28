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
 * newsCreateForm: форма для метода create модуля news
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

        $url = new url('withAnyParam');
        $url->addParam('folder', $folder);
        $url->setAction($action);

        $form = new HTML_QuickForm('createFolder', 'POST', $url->get());

        $defaultValues = array();

        if ($action == 'editFolder') {
            $defaultValues['name'] = $targetFolder->getName();
            $defaultValues['title'] = $targetFolder->getTitle();
        }

        $defaultValues['label'] = $folder;
        $form->setDefaults($defaultValues);

        $label = $form->addElement('text', 'label', 'Имя надкаталога', 'size=30');
        $label->freeze();
        $form->addElement('text', 'name', 'Имя:', 'size=30');
        $form->addElement('text', 'title', 'Название:', 'size=30');


        $form->addRule('name', 'обязательное поле', 'required');
        $form->addRule('name', 'только алфавитно-цифровые символы', 'regex', '/[^\W\d][\w\d_]*/');

        if ($action == 'editFolder') {
            $form->registerRule('isUniqueName', 'callback', 'editFolderValidate');
        } else {
            $form->registerRule('isUniqueName', 'callback', 'createFolderValidate');
        }

        $form->addRule('name', 'имя должно быть уникально в пределах каталога и содержать латинские буквы и цифры', 'isUniqueName', array($folder, $newsFolderMapper));

        $form->addElement('reset', 'reset', 'Отмена', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', 'Сохранить');

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