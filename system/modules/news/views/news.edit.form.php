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
 * newsEditForm: форма для метода edit модуля news
 *
 * @package news
 * @version 0.1
 */

class newsEditForm {
    static function getForm($news)
    {
        require_once 'HTML/QuickForm.php';
        require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';

        // Следующая строка здесь не к месту ???
        //$data = $tableModule->getNews($params[0]);

        $form = new HTML_QuickForm('form', 'POST');
        $defaultValues = array();
        $defaultValues['title']  = $news->getTitle();
        $defaultValues['text']  = $news->getText();
        $form->setDefaults($defaultValues);

        $form->addElement('text', 'title', 'Имя:', 'size=30');
        $form->addElement('textarea', 'text', 'Текст:', 'rows=7 cols=50');
        $form->addElement('hidden', 'path', '/news/edit');
        $form->addElement('hidden', 'id', $news->getId());
        $form->addElement('reset', 'reset', 'Отмена','onclick=\'javascript: window.close();\'');
        $form->addElement('submit', 'submit', 'Сохранить');
        return $form;
    }
}

?>
