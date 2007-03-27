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
 * adminAddActionForm: форма для метода addAction модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.3
 */
class adminAddActionForm
{
    /**
     * метод получения формы
     *
     */
    static function getForm($data, $db, $action, $action_name, $actionsInfo)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('withId');
        $url->setAction($action);
        $url->addParam('id', $data['c_id']);
        if ($action == 'editAction') {
            $url->setRoute('adminAction');
            $url->addParam('action_name', $action_name);
        }

        $form = new HTML_QuickForm('addAction', 'POST', $url->get());

        $defaultValues = array();

        if ($action == 'editAction') {
            $defaultValues['name']  = $action_name;

            $default = array('title' => '', 'info' => '', 'icon' => '');

            $info = $actionsInfo[$action_name];
            $info = array_merge($default, $info);

            $defaultValues['controller'] = $info['controller'];
            $defaultValues['title'] = $info['title'];
            $defaultValues['icon'] = $info['icon'];
            if (isset($info['confirm'])) {
                $defaultValues['confirm'] = $info['confirm'];
            }
            if (isset($info['alias'])) {
                $defaultValues['alias'] = $info['alias'];
            }
            $defaultValues['jip'] = (!empty($info['jip']));
            $defaultValues['inacl'] = (isset($info['inACL']) && $info['inACL'] == 0);

        } else {
            $defaultValues['icon'] = '/templates/images/';
        }

        $form->setDefaults($defaultValues);

        $toolkit = systemToolkit::getInstance();
        $adminMapper = $toolkit->getMapper('admin', 'admin');
        $dest = $adminMapper->getDests(true, $data['m_name']);

        $aliases = array(0 => '');
        foreach ($actionsInfo as $key => $val) {
            if ($action_name != $key) {
                $aliases[$key] = isset($val['title']) ? $val['title'] : $key;
            }
        }
        $form->addElement('select', 'alias', 'Алиас:', $aliases);

        $select = $form->addElement('select', 'dest', 'Каталог генерации:', $dest);
        if (sizeof($dest) == 1) {
            $val = current(array_keys($dest));
            $select->setSelected($val);
            $select->freeze();
        }

        $form->addElement('text', 'name', 'Название:', 'size="30"');
        $form->addElement('text', 'controller', 'Контроллер:', 'size="30"');
        $form->addElement('advcheckbox', 'jip', 'Добавить в JIP:', '', null, array(0, 1));
        $form->addElement('advcheckbox', 'inacl', 'Не регистрировать в ACL:', '', null, array(0, 1));
        $form->addElement('text', 'title', 'Заголовок для меню JIP:', 'size="30"');
        $form->addElement('text', 'icon', 'Путь от корня сайта до иконки для меню JIP:', 'size="30"');
        $form->addElement('text', 'confirm', 'Сообщение при выполнении данного действия:', 'size="30"');

        $form->addElement('reset', 'reset', 'Отмена', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', 'Сохранить');

        $form->registerRule('isUniqueName', 'callback', 'addClassValidate');
        $form->addRule('name', 'Такое действие у класса уже есть или введённое вами имя содержит запрещённые символы', 'isUniqueName', array($db, $action_name, $data));
        $form->addRule('name', 'Поле обязательно к заполнению', 'required');

        return $form;
    }
}

function addClassValidate($name, $data)
{
    if (strlen($name) === 0 || preg_match('/[^a-z0-9_\-]/i', $name)) {
        return false;
    }

    if ($name == $data[1]) {
        return true;
    }

    $res = $data[0]->getRow('SELECT COUNT(*) AS `cnt` FROM `sys_classes_actions` `ca`
                   INNER JOIN `sys_actions` `a` ON `a`.`id` = `ca`.`action_id`
                    WHERE `ca`.`class_id` = ' . $data[2]['c_id'] . ' AND `a`.`name` = ' . $data[0]->quote($name));

    return $res['cnt'] == 0;
}

?>