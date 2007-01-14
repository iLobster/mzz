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
     * @param string $action текущее действие
     * @param object $pageFolder
     * @return object сгенерированная форма
     */
    static function getForm($page, $section, $action, $pageFolder)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $formAction = '/' . $section . '/' . $pageFolder->getPath() . ($action == 'edit' ? '/' . $page->getName() : '') . '/' . $action;
        $form = new HTML_QuickForm('form', 'POST', $formAction);

        if ($action == 'edit') {
            $defaultValues = array();
            $defaultValues['name']  = $page->getName();
            $defaultValues['title']  = $page->getTitle();
            $defaultValues['content']  = $page->getContent();
            $form->setDefaults($defaultValues);
        }

        $form->addElement('text', 'name', 'Name ID:', 'size=30');
        $form->addElement('text', 'title', 'Заголовок:', 'size=30');
        $form->addElement('textarea', 'content', 'Содержание:', 'rows=15 cols=80 id="content" style="width: 100%;"');

        if ($action == 'edit') {
            $form->registerRule('isUniqueName', 'callback', 'editPageValidate');
        } else {
            $form->registerRule('isUniqueName', 'callback', 'createPageValidate');
        }

        $form->addRule('name', 'имя страницы должно быть уникально в пределах каталога и содержать латинские буквы и цифры', 'isUniqueName', array($page, $pageFolder));

        $form->addElement('reset', 'reset', 'Отмена','onclick=\'javascript: hideJip();\'');
        $form->addElement('submit', 'submit', 'Сохранить');
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
