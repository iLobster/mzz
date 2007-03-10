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
 * adminAddModuleForm: форма для метода addModule модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.1
 */
class adminAddModuleForm
{
    /**
     * метод получения формы
     *
     */
    static function getForm($data, $db, $action, $nameRO, $classesSelect)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('withId');
        $url->setAction($action);
        $url->addParam('id', $data['id']);

        $form = new HTML_QuickForm('addModule', 'POST', $url->get());

        if ($action == 'editModule') {
            $defaultValues = array();
            $defaultValues['name']  = $data['name'];
            $defaultValues['title']  = $data['title'];
            $defaultValues['icon']  = $data['icon'];
            $defaultValues['order']  = $data['order'];
            $defaultValues['main_class']  = $data['main_class'];
            $form->setDefaults($defaultValues);

            $select = $form->addElement('select', 'main_class', '"Главный" класс:', $classesSelect);
            $form->registerRule('isUniqueName', 'callback', 'addMainClassValidate');
            $form->addRule('main_class', 'выбранный класс не существует или принадлежит другому модулю', 'isUniqueName', array($db, $data));
        }

        $toolkit = systemToolkit::getInstance();
        $adminMapper = $toolkit->getMapper('admin', 'admin');
        $dest = $adminMapper->getDests(true);

        $select = $form->addElement('select', 'dest', 'Каталог генерации:', $dest);
        if (sizeof($dest) == 1) {
            $val = current(array_keys($dest));
            $select->setSelected($val);
            $select->freeze();
        }

        $name = $form->addElement('text', 'name', 'Название:', 'size="30"');
        if ($nameRO) {
            $name->freeze();
        }

        $form->addElement('text', 'title', 'Заголовок:', 'size="30"');
        $form->addElement('text', 'icon', 'Иконка:', 'size="30"');
        $form->addElement('text', 'order', 'Порядок сортировки:', 'size="30"');

        $form->addElement('reset', 'reset', 'Отмена', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', 'Сохранить');

        if (!$nameRO) {
            $form->registerRule('isUniqueName', 'callback', 'addModuleValidate');
            $form->addRule('name', 'имя модуля должно быть уникально и содержать латинские буквы и цифры', 'isUniqueName', array($db));
            $form->addRule('name', 'поле обязательно к заполнению', 'required');
        }

        return $form;
    }
}

function addModuleValidate($name, $data)
{
    if (strlen($name) === 0 || preg_match('/[^a-z0-9_\-]/i', $name)) {
        return false;
    }

    $stmt = $data[0]->prepare('SELECT COUNT(*) AS `cnt` FROM `sys_modules` WHERE `name` = :name');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    $res = $stmt->fetch();

    return $res['cnt'] == 0;
}

function addMainClassValidate($id, $data)
{
    $stmt = $data[0]->prepare('SELECT COUNT(*) AS `cnt` FROM `sys_classes` WHERE `id` = :id AND `module_id` = :module');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':module', $data[1]['id'], PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetch();

    return $res['cnt'] == 1 || !$id;
}

?>