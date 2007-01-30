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
 * adminAddClassForm: форма для метода addClass модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminAddClassForm
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

        $form = new HTML_QuickForm('addClass', 'POST', $url->get());

        if ($action == 'editClass') {
            $defaultValues = array();
            $defaultValues['name']  = $data['name'];
            $form->setDefaults($defaultValues);
        }

        $dest = array();
        if (is_writable($system = systemConfig::$pathToSystem . DIRECTORY_SEPARATOR . 'modules')) {
            $dest['sys'] = $system;
        }
        if (is_writable($app = systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'modules')) {
            $dest['app'] = $app;
        }

        $select = $form->addElement('select', 'dest', 'Каталог генерации:', $dest);
        if (sizeof($dest) == 1) {
            $val = current(array_keys($dest));
            $select->setSelected($val);
            $select->freeze();
        }

        $form->addElement('text', 'name', 'Название:', 'size="30"');

        $form->addElement('reset', 'reset', 'Отмена', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', 'Сохранить');

        $form->registerRule('isUniqueName', 'callback', 'addClassValidate');
        $form->addRule('name', 'имя класса должно быть уникально и содержать латинские буквы и цифры', 'isUniqueName', array($db));
        $form->addRule('name', 'поле обязательно к заполнению', 'required');

        return $form;
    }
}

function addClassValidate($name, $data)
{
    if (strlen($name) === 0 || preg_match('/[^a-z0-9_\-]/i', $name)) {
        return false;
    }

    $stmt = $data[0]->prepare('SELECT COUNT(*) AS `cnt` FROM `sys_classes` WHERE `name` = :name');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    $res = $stmt->fetch();

    return $res['cnt'] == 0;
}

?>