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
 * fileUploadForm: форма для метода upload модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1.1
 */
class fileUploadForm
{
    /**
     * метод получения формы
     *
     * @param folder $folder папка, в которую загружаем файл
     * @return object сгенерированная форма
     */
    static function getForm($folder)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('withAnyParam');
        $url->setAction('upload');
        $url->addParam('name', $folder->getPath());
        $form = new HTML_QuickForm('fmUploadFileForm', 'POST', $url->get());

        $form->addElement('file', 'file', 'Файл');
        $form->addRule('file', 'Укажите файл для загрузки', 'uploadedfile');

        $form->addElement('text', 'name', 'Новое имя:', 'size="30"');
        $form->addRule('name', 'Недопустимые символы в имени', 'regex', '/^[a-zа-я0-9_\.\-]+$/i');

        $form->addElement('reset', 'resetButton', 'Отмена', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', 'Загрузить', 'id="fmUploadFileSubmitButton"');
        return $form;
    }
}

?>