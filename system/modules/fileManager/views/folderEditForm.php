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
 * folderEditForm: форма для метода editFolder модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class folderEditForm
{
    /**
     * метод получения формы
     *
     * @return object сгенерированная форма
     */
    static function getForm($folder, $folderMapper, $action)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url();
        $url->setAction($action);
        $url->addParam('name', $folder->getPath());
        $form = new HTML_QuickForm('editFolder', 'POST', $url->get());

        if ($action == 'editFolder') {
            $defaultValues = array();
            $defaultValues['name']  = $folder->getName();
            $defaultValues['title']  = $folder->getTitle();
            $form->setDefaults($defaultValues);

            $form->registerRule('isUniqueName', 'callback', 'editFolderValidate');
        } else {

        }

        $form->addElement('text', 'name', 'Имя:', 'size="30"');
        $form->addElement('text', 'title', 'Заголовок:', 'size="30"');

        $form->addRule('name', 'недопустимые символы в имени', 'regex', '/^[a-zа-я0-9_\.\-! ]+$/i');
        $form->addRule('name', 'имя должно быть уникально в пределах каталога', 'isUniqueName', array($folder, $folderMapper));

        $form->addElement('reset', 'reset', 'Отмена', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', 'Сохранить');
        return $form;
    }
}

function editFolderValidate($name, $data)
{
    $path = $data[0]->getPath();
    $pathToParent = substr($path, 0, strpos($path, '/'));

    return $data[0]->getName() == $name || is_null($data[1]->searchByPath($pathToParent . '/' . $name));
}

?>