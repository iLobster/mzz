<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/modules/catalogue/forms/catalogueCreateForm.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: catalogueCreateForm.php 1410 2007-03-08 02:52:55Z striker $
 */

fileLoader::load('catalogue/forms/catalogueAssignForm');

/**
 * catalogueCreateForm: ����� ��� ������ create ������ catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
class catalogueCreateForm
{
    /**
     * ����� ��������� �����
     *
     * @param string $action ������� ��������
     * @param array $properties ��������
     * @param array $type ������ �������� ����
     * @return object ��������������� �����
     */
    static function getForm(Array $types, catalogueFolder $folder, $curType, Array $properties)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('withAnyParam');
        $url->setAction('create');
        $url->setSection('catalogue');
        $url->addParam('name', $folder->getPath());

        $form = new HTML_QuickForm('frmSave', 'POST', $url->get());

        $select = array();
        foreach($types as $type){
            $select[$type['id']] = $type['title'];
        }

        $form->addElement('select', 'type', '���', $select, array("id" => "type", "onchange" => "javascript:loadForm(this.value);", "onkeypress" => "this.onchange();"));

        $form->setDefaults(array('type' => $curType));

        catalogueAssignForm::assign($form, $properties);

        $form->applyFilter('__ALL__', 'trim');

        $form->addElement('reset', 'reset', '������','onclick=\'javascript: jipWindow.close();\'');
        $form->addElement('submit', 'submit', '���������');
        return $form;
    }
}
?>