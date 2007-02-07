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
 * fileEditForm: форма для метода edit модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class fileEditForm
{
    /**
     * метод получения формы
     *
     * @param object $news объект новостей
     * @param string $section текущая секция
     * @param string $action текущее действие
     * @param newsFolder $newsFolder папка, в которой создаём новость
     * @return object сгенерированная форма
     */
    static function getForm($file)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url();
        $url->setAction('edit');
        $url->addParam('name', $file->getFullPath());
        $form = new HTML_QuickForm('fileUpload', 'POST', $url->get());

        $defaultValues = array();
        $defaultValues['name']  = $file->getName();
        $form->setDefaults($defaultValues);

        $form->addElement('text', 'name', 'Новое имя:', 'size="30"');
        $form->registerRule('isUniqueName', 'callback', 'checkFilename');
        $form->addRule('name', 'недопустимые символы в имени', 'regex', '/^[a-zа-я0-9_\.\-! ]+$/i');
        $form->addRule('name', 'имя должно быть уникально в пределах каталога', 'isUniqueName', array($file));

        $form->addElement('reset', 'reset', 'Отмена', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', 'Сохранить');
        return $form;
    }
}

function checkFilename($name, $data)
{
    if ($name == $data[0]->getName()) {
        return true;
    }

    $toolkit = systemToolkit::getInstance();
    $criteria = new criteria();
    $criteria->add('folder_id', $data[0]->getFolder()->getId())->add('name', $name);

    $fileMapper = $toolkit->getMapper('fileManager', 'file');
    return is_null($fileMapper->searchOneByCriteria($criteria));
}

?>