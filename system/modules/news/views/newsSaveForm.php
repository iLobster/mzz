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
 * newsSaveForm: форма для метода save модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */
class newsSaveForm
{
    /**
     * метод получения формы
     *
     * @param object $news объект новостей
     * @param string $section текущая секция
     * @param string $action текущее действие
     * @param newsFolder $newsFolder папка, в которой создаём новость
     * @param boolean $isEdit true если действие "редактировать"
     * @return object сгенерированная форма
     */
    static function getForm($news, $section, $action, $newsFolder, $isEdit)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('withAnyParam');
        $url->setSection($section);
        $url->setAction($action);
        $url->addParam('name', $isEdit ? $news->getId() : $newsFolder->getPath());
        $form = new HTML_QuickForm('newsEdit', 'POST', $url->get());

        $defaultValues = array();
        if ($isEdit) {
            $defaultValues = array();
            $defaultValues['title']  = $news->getTitle();
            $defaultValues['text']  = $news->getText();
            $defaultValues['created']  = date('H:i:s d/m/Y', $news->getCreated());
        } else {
            $defaultValues['created']  = date('H:i:s d/m/Y');
            $form->addElement('text', 'created', 'Дата создания:', 'size="20" id="calendar-field-created"');
            $form->addRule('created', 'Необходимо указать дату', 'required');
            $form->addRule('created', 'Правильный формат даты: чч:м:с д/м/г ', 'regex', '#^([01][0-9]|[2][0-3]):([0-5][0-9]):([0-5][0-9])\s(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])[/](19|20)\d{2}$#');
        }
        $form->setDefaults($defaultValues);

        $form->addElement('text', 'title', 'Название:', 'size="60"');
        $form->addElement('textarea', 'text', 'Содержание:', 'rows="7" cols="50"');

        $form->addElement('reset', 'reset', 'Отмена', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', 'Сохранить');

        $form->addRule('title', 'Необходимо назвать новость', 'required');

        return $form;
    }
}

?>