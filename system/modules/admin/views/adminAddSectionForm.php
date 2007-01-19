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
 * adminAddSectionForm: форма для метода addSection модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminAddSectionForm
{
    /**
     * метод получения формы
     *
     */
    static function getForm($data, $db, $action)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url();
        $url->setAction($action);
        $url->addParam('id', $data['id']);

        $form = new HTML_QuickForm('addSection', 'POST', $url->get());

        if ($action == 'editSection') {
            $defaultValues = array();
            $defaultValues['name']  = $data['name'];
            $form->setDefaults($defaultValues);
        }

        $form->addElement('text', 'name', 'Название:', 'size="30"');

        $form->addElement('reset', 'reset', 'Отмена', 'onclick="javascript: hideJip();"');
        $form->addElement('submit', 'submit', 'Сохранить');

        $form->registerRule('isUniqueName', 'callback', 'addSectionValidate');
        $form->addRule('name', 'имя раздела должно быть уникально и содержать латинские буквы и цифры', 'isUniqueName', array($db));
        $form->addRule('name', 'поле обязательно к заполнению', 'required');

        return $form;
    }
}

function addSectionValidate($name, $data)
{
    if (strlen($name) === 0 || preg_match('/[^a-z0-9_\-]/i', $name)) {
        return false;
    }

    $stmt = $data[0]->prepare('SELECT COUNT(*) AS `cnt` FROM `sys_sections` WHERE `name` = :name');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    $res = $stmt->fetch();

    return $res['cnt'] == 0;
}

?>