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
 * groupEditForm: форма для метода edit модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

class groupEditForm
{
    /**
     * метод получения формы
     *
     * @param object $group редактируемая группа
     * @param string $section текущая секция
     * @param string $action текущий экшн
     * @param object $groupMapper маппер для групп
     * @return object сгенерированная форма
     */
    static function getForm($group, $section, $action, $groupMapper)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url();
        $url->setAction($action);
        $url->setSection($section);

        if ($action == 'groupEdit') {
            $url->addParam($group->getId());
        }

        $form = new HTML_QuickForm('groupEdit', 'POST', $url->get());

        if ($action == 'groupEdit') {
            $defaultValues = array();
            $defaultValues['name']  = $group->getName();
            $form->setDefaults($defaultValues);
        }

        $form->addElement('text', 'name', 'Имя:', 'size=30');

        $form->registerRule('isUniqueName', 'callback', 'createGroupValidation');
        $form->addRule('name', 'группа с таким именем уже существует', 'isUniqueName', array($group, $groupMapper));

        $form->addElement('reset', 'reset', 'Отмена','onclick=\'javascript: window.close();\'');
        $form->addElement('submit', 'submit', 'Сохранить');
        return $form;
    }
}

function createGroupValidation($name, $data)
{
    if (!is_object($data[0]) || $name !== $data[0]->getName()) {
        $group = $data[1]->searchByName($name);

        if ($group) {
            return false;
        }
    }
    return true;
}

?>
