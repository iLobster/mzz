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
 * adminAddSectionForm: ����� ��� ������ addSection ������ admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.2
 */
class adminAddSectionForm
{
    /**
     * ����� ��������� �����
     *
     */
    static function getForm($data, $db, $action, $nameRO)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('withId');
        $url->setAction($action);
        $url->addParam('id', $data['id']);

        $form = new HTML_QuickForm('addSection', 'POST', $url->get());

        if ($action == 'editSection') {
            $defaultValues = array();
            $defaultValues['name']  = $data['name'];
            $defaultValues['title']  = $data['title'];
            $defaultValues['order']  = $data['order'];
            $form->setDefaults($defaultValues);
        }

        $name = $form->addElement('text', 'name', '��������:', 'size="30"');
        if ($nameRO) {
            $name->freeze();
        }

        $form->addElement('text', 'title', '���������:', 'size="30"');
        $form->addElement('text', 'order', '������� ����������:', 'size="30"');

        $form->addElement('reset', 'reset', '������', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', '���������');

        if (!$nameRO) {
            $form->registerRule('isUniqueName', 'callback', 'addSectionValidate');
            $form->addRule('name', '��� ������� ������ ���� ��������� � ��������� ��������� ����� � �����', 'isUniqueName', array($db));
            $form->addRule('name', '���� ����������� � ����������', 'required');
        }

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