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
 * adminMainClassForm: форма для метода mainClass модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminMainClassForm
{
    /**
     * метод получения формы
     *
     */
    static function getForm($data, $classes, $db)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('withId');
        $url->setAction('mainClass');
        $url->addParam('id', $data['id']);

        $form = new HTML_QuickForm('mainClass', 'POST', $url->get());

        $defaultValues = array();
        $defaultValues['main_class']  = $data['main_class'];
        $form->setDefaults($defaultValues);

        $select = $form->addElement('select', 'main_class', '"Главный" класс:', $classes);

        $form->addElement('reset', 'reset', 'Отмена', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', 'Сохранить');

        $form->registerRule('isUniqueName', 'callback', 'addMainClassValidate');
        $form->addRule('name', 'выбранный класс не существует или принадлежит другому модулю', 'isUniqueName', array($db, $data));

        return $form;
    }
}

function addMainClassValidate($id, $data)
{
    $stmt = $data[0]->prepare('SELECT COUNT(*) AS `cnt` FROM `sys_classes` WHERE `id` = :id AND `module_id` = :module');
    $stmt->bindValue(':id', $name, PDO::PARAM_INT);
    $stmt->bindValue(':module', $$data[1]['id'], PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetch();

    return $res['cnt'] == 0;
}

?>