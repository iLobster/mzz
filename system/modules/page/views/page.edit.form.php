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
 * pageEditForm: форма для метода edit модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */

class pageEditForm
{
    /**
     * метод получения формы
     *
     * @param object $page объект page
     * @param string $section текущая секция
     * @return object сгенерированная форма
     */
    static function getForm($page, $section)
    {
        require_once 'HTML/QuickForm.php';
        require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';

        $form = new HTML_QuickForm('form', 'POST', '/' . $section . '/' . $page->getName() . '/edit');
        $defaultValues = array();
        $defaultValues['name']  = $page->getName();
        $defaultValues['title']  = $page->getTitle();
        $defaultValues['content']  = $page->getContent();
        $form->setDefaults($defaultValues);

        $form->addElement('text', 'name', 'Name ID:', 'size=30');
        $form->addElement('text', 'title', 'Заголовок:', 'size=30');
        $form->addElement('textarea', 'content', 'Содержание:', 'rows=7 cols=50');

        $form->addElement('reset', 'reset', 'Отмена','onclick=\'javascript: window.close();\'');
        $form->addElement('submit', 'submit', 'Сохранить');
        return $form;
    }
}

?>
