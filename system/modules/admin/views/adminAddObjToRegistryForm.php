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
 * adminAddObjToRegistryForm: форма для метода addObjToRegistryForm модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminAddObjToRegistryForm
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

        $form = new HTML_QuickForm('addObjToRegistry', 'POST', $url->get());

        $form->addElement('text', 'obj_id', 'Идентификатор объекта:', 'size="10" id="obj_id"');

        $form->addElement('select', 'class_section', 'Для класса в секции:', $data);

        $form->addElement('reset', 'reset', 'Отмена', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', 'Сохранить');

        $form->registerRule('isClassSectionExists', 'callback', 'addObjToRegistryValidate');
        $form->addRule('class_section', 'Идентификатор должен существовать и может быть только целым числом', 'isClassSectionExists', array($db));
        $form->addRule('class_section', 'Выберите из списка', 'required');
        $form->addRule('obj_id', 'Идентификатор должен быть целым числом', 'alphanumeric');
        $form->addRule('obj_id', 'Необходим идентификатор объекта', 'required');

        return $form;
    }
}

function addObjToRegistryValidate($id, $data)
{
    if (strlen($id) === 0 || preg_match('/[^0-9]/i', $id)) {
        return false;
    }

    $stmt = $data[0]->prepare('SELECT COUNT(*) AS `cnt` FROM `sys_classes_sections` WHERE `id` = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetch();

    return $res['cnt'] == 1;
}

?>