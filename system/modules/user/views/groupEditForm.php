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
 * groupEditForm: ����� ��� ������ edit ������ user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

class groupEditForm
{
    /**
     * ����� ��������� �����
     *
     * @param object $group ������������� ������
     * @param string $section ������� ������
     * @param string $action ������� ����
     * @param object $groupMapper ������ ��� �����
     * @return object ��������������� �����
     */
    static function getForm($group, $section, $action, $groupMapper)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url();
        $url->setAction($action);
        $url->setSection($section);

        if ($action == 'groupEdit') {
            $url->addParam($group->getId());
        }

        $form = new HTML_QuickForm('groupEdit', 'POST', $url->get());

        if ($action == 'groupEdit') {
            $defaultValues = array();
            $defaultValues['name']  = $group->getName();
            $form->setDefaults($defaultValues);
        }

        $form->addElement('text', 'name', '���:', 'size=30');

        $form->registerRule('isUniqueName', 'callback', 'createGroupValidation');
        $form->addRule('name', '������ � ����� ������ ��� ����������', 'isUniqueName', array($group, $groupMapper));

        $form->addElement('reset', 'reset', '������','onclick=\'javascript: window.close();\'');
        $form->addElement('submit', 'submit', '���������');
        return $form;
    }
}

function createGroupValidation($name, $data)
{
    if (!is_object($data[0]) || $name !== $data[0]->getName()) {
        $group = $data[1]->searchByName($name);

        if ($group) {
            return false;
        }
    }
    return true;
}

?>
