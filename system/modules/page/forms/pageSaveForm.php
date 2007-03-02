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
 * pageSaveForm: форма для метода save модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */
class pageSaveForm
{
    /**
     * метод получения формы
     *
     * @param object $page объект page
     * @param string $section текущая секция
     * @param string $action текущее действие
     * @param object $pageFolder
     * @param boolean $isEdit true если действие "редактировать"
     * @return object сгенерированная форма
     */
    static function getForm($page, $section, $action, $pageFolder, $isEdit)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');


        $url = new url('pageActions');
        $url->addParam('name', $pageFolder->getPath() . ($isEdit ? '/' . $page->getName() : ''));
        $url->setAction($action);
        $url->setSection($section);
        $form = new HTML_QuickForm($action, 'POST', $url->get());

        if ($isEdit) {
            $defaultValues = array();
            $defaultValues['name']  = $page->getName();
            $defaultValues['title']  = $page->getTitle();
            $defaultValues['contentArea']  = $page->getContent();
            $form->setDefaults($defaultValues);
        }

        $form->addElement('text', 'name', 'Name ID:', 'size=30');
        $form->addElement('text', 'title', 'Заголовок:', 'size=30');
        $form->addElement('textarea', 'contentArea', 'Содержание:', 'rows=15 cols=80 id="contentArea" style="width: 100%;"');

        if ($isEdit) {
            $form->registerRule('isUniqueName', 'callback', 'editPageValidate');
        } else {
            $form->registerRule('isUniqueName', 'callback', 'createPageValidate');
        }

        $form->addRule('name', 'имя страницы должно быть уникально в пределах каталога и содержать латинские буквы и цифры', 'isUniqueName', array($page, $pageFolder));

        $form->addElement('reset', 'reset', 'Отмена','onclick=\'javascript: jipWindow.close();\'');
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