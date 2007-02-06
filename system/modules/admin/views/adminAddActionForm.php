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
 * @version 0.1.1
 */

class adminAddActionForm
{
    /**
     * ����� ��������� �����
     *
     */
    static function getForm($data, $db, $action, $action_name, $actionsInfo)
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

        $defaultValues = array();

        if ($action == 'editAction') {
            $defaultValues['name']  = $action_name;

            $default = array('title' => '', 'info' => '', 'icon' => '');

            $info = $actionsInfo[$action_name];
            $info = array_merge($default, $info);

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
        $form->addElement('select', 'alias', '�����', $aliases);

        $select = $form->addElement('select', 'dest', '������� ���������:', $dest);
        if (sizeof($dest) == 1) {
            $val = current(array_keys($dest));
            $select->setSelected($val);
            $select->freeze();
        }

        $form->addElement('text', 'name', '��������:', 'size="30"');
        $form->addElement('advcheckbox', 'jip', '���� ���� ������ ���� � jip', 'jip = "1"', null, array(0, 1));
        $form->addElement('advcheckbox', 'inacl', '���� ���� �� ������ ���� ��������������� � acl', 'inACL = "0"', null, array(0, 1));
        $form->addElement('text', 'title', '��������� � ���� jip', 'size="30"');
        $form->addElement('text', 'icon', '���� �� ����� ����� �� ������ � ���� jip', 'size="30"');
        $form->addElement('text', 'confirm', '��������� ��������� ��� ���������� ������� �����', 'size="30"');

        $form->addElement('reset', 'reset', '������', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', '���������');

        $form->registerRule('isUniqueName', 'callback', 'addClassValidate');
        $form->addRule('name', '����� ���� � ������ ��� ���� ��� �������� ���� ��� �������� ����������� �������', 'isUniqueName', array($db, $action_name));
        $form->addRule('name', '���� ����������� � ����������', 'required');

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
                    WHERE `ca`.`class_id` = 10 AND `a`.`name` = ' . $data[0]->quote($name));

    return $res['cnt'] == 0;
}

?>