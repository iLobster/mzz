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
 * adminAddObjToRegistryForm: ����� ��� ������ addObjToRegistryForm ������ admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminAddObjToRegistryForm
{
    /**
     * ����� ��������� �����
     *
     */
    static function getForm($data, $db, $action)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url();
        $url->setAction($action);

        $form = new HTML_QuickForm('addObjToRegistry', 'POST', $url->get());

        $form->addElement('text', 'obj_id', '������������� �������:', 'size="10" id="obj_id"');

        $form->addElement('select', 'class_section', '��� ������ � ������:', $data);

        $form->addElement('reset', 'reset', '������', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', '���������');

        $form->registerRule('isClassSectionExists', 'callback', 'addObjToRegistryValidate');
        $form->addRule('class_section', '������������� ������ ������������ � ����� ���� ������ ����� ������', 'isClassSectionExists', array($db));
        $form->addRule('class_section', '�������� �� ������', 'required');
        $form->addRule('obj_id', '������������� ������ ���� ����� ������', 'alphanumeric');
        $form->addRule('obj_id', '��������� ������������� �������', 'required');

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