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
 * adminAddClassForm: ����� ��� ������ addClass ������ admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminAddClassForm
{
    /**
     * ����� ��������� �����
     *
     */
    static function getForm($data, $db, $action, $module_name)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('withId');
        $url->setAction($action);
        $url->addParam('id', $data['id']);

        $form = new HTML_QuickForm('addClass', 'POST', $url->get());

        if ($action == 'editClass') {
            $defaultValues = array();
            $defaultValues['name']  = $data['name'];
            $form->setDefaults($defaultValues);
        }

        $toolkit = systemToolkit::getInstance();
        $adminMapper = $toolkit->getMapper('admin', 'admin');
        $dest = $adminMapper->getDests(true, $module_name);

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
        $form->addRule('name', '��� ������ ������ ���� ��������� � ��������� ��������� ����� � �����', 'isUniqueName', array($db));
        $form->addRule('name', '���� ����������� � ����������', 'required');

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