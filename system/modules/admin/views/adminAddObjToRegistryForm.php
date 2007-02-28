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

        $url = new url('default2');
        $url->setAction($action);

        $form = new HTML_QuickForm('addObjToRegistry', 'POST', $url->get());
        array_unshift($data, '');
        $form->addElement('select', 'section', '������:', $data, 'id="addobj_section" onchange="addObjChangeClass(this)" onkeypress="this.onchange()"');
        $form->addElement('select', 'class', '�����:', null, 'id="addobj_class" style="width: 150px;" disabled="disabled"');
        $form->addElement('reset', 'reset', '������', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', '���������');

        $form->registerRule('isClassSectionExists', 'callback', 'addObjToRegistryValidate');
        $form->addRule('class', '������������� ������ ������������ � ����� ���� ������ ����� ������ ������ 0', 'isClassSectionExists', array($db));
        $form->addRule('class', '����� �� ������', 'required');
        return $form;
    }
}

function addObjToRegistryValidate($id, $data)
{
    if (strlen($id) === 0 || preg_match('/[^0-9]/i', $id) || $id <= 0) {
        return false;
    }

    $stmt = $data[0]->prepare('SELECT COUNT(*) AS `cnt` FROM `sys_classes_sections` WHERE `id` = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetch();

    return $res['cnt'] == 1;
}

?>