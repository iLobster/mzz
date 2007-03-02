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
 * adminAddCfgForm: ����� ��� ������ addCfg ������ admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminAddCfgForm
{
    /**
     * ����� ��������� �����
     *
     * @param string $param ��� �������������� ���������
     * @param integer $module ������������� ������
     * @param string $action ������� ��������
     * @param string $value �������� �� ��������� ��� ���������
     * @return object ��������������� �����
     */
    static function getForm($param, $module, $action, $value = '')
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $isEdit = ($action == 'editCfg');

        if ($isEdit) {
            $url = new url('adminCfgEdit');
            $url->addParam('name', $param);
            $url->setAction('editCfg');
        } else {
            $url = new url('withId');
            $url->setSection('admin');
            $url->setAction('addCfg');
        }
        $url->addParam('id', $module);

        $form = new HTML_QuickForm($action, 'POST', $url->get());



        $defaultValues = array();
        if ($isEdit) {
            $defaultValues = array();
            $defaultValues['param']  = $param;
            $defaultValues['value']  = $value;
        }
        $form->setDefaults($defaultValues);

        $form->addElement('text', 'param', '��������:', 'size="60"');
        $form->addElement('text', 'value', '��������:', 'size="60"');

        $form->addElement('reset', 'reset', '������', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', '���������');

        $form->addRule('param', '���������� ������� ��� ���������', 'required');
        $form->addRule('param', '������������ ������� � ����� ���������', 'regex', '/^[a-z0-9_\-]+$/i');

        return $form;
    }
}

?>