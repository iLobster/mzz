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
 * @version 0.1
 */
class adminAddSectionForm
{
    /**
     * ����� ��������� �����
     *
     */
    static function getForm($data, $db, $action)
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
            $form->setDefaults($defaultValues);
        }

        $form->addElement('text', 'name', '��������:', 'size="30"');

        $form->addElement('reset', 'reset', '������', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', '���������');

        $form->registerRule('isUniqueName', 'callback', 'addSectionValidate');
        $form->addRule('name', '��� ������� ������ ���� ��������� � ��������� ��������� ����� � �����', 'isUniqueName', array($db));
        $form->addRule('name', '���� ����������� � ����������', 'required');

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