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
 * adminAddActionForm: ����� ��� ������ addAction ������ admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminAddActionForm
{
    /**
     * ����� ��������� �����
     *
     */
    static function getForm($data, $db, $action, $action_name)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url();
        $url->setAction($action);
        $url->addParam('id', $data['c_id']);
        if ($action == 'editAction') {
                $url->addParam('action_name', $action_name);
        }

        $form = new HTML_QuickForm('addAction', 'POST', $url->get());

        if ($action == 'editAction') {
            $defaultValues = array();
            $defaultValues['name']  = $action_name;
            $form->setDefaults($defaultValues);
        }

        $toolkit = systemToolkit::getInstance();
        $adminMapper = $toolkit->getMapper('admin', 'admin');
        $dest = $adminMapper->getDests(true, $data['m_name']);

        $select = $form->addElement('select', 'dest', '������� ���������:', $dest);
        if (sizeof($dest) == 1) {
            $val = current(array_keys($dest));
            $select->setSelected($val);
            $select->freeze();
        }

        $form->addElement('text', 'name', '��������:', 'size="30"');

        $form->addElement('reset', 'reset', '������', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', '���������');

        $form->registerRule('isUniqueName', 'callback', 'addClassValidate');
        $form->addRule('name', '����� ���� � ������ ��� ���� ��� �������� ���� ��� �������� ����������� �������', 'isUniqueName', array($db));
        $form->addRule('name', '���� ����������� � ����������', 'required');

        return $form;
    }
}

function addClassValidate($name, $data)
{
    if (strlen($name) === 0 || preg_match('/[^a-z0-9_\-]/i', $name)) {
        return false;
    }

    $res = $data[0]->getRow('SELECT COUNT(*) AS `cnt` FROM `sys_classes_actions` `ca`
                   INNER JOIN `sys_actions` `a` ON `a`.`id` = `ca`.`action_id`
                    WHERE `ca`.`class_id` = 10 AND `a`.`name` = ' . $data[0]->quote($name));

    return $res['cnt'] == 0;
}

?>