<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/modules/catalogue/forms/catalogueSaveForm.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: catalogueSaveForm.php 1410 2007-03-08 02:52:55Z striker $
 */

/**
 * catalogueSaveForm: ����� ��� ������ save ������ page
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

        if($curType != 0){
            $form->setDefaults(array('type' => $curType));
        }

        foreach($properties as $property){
            $name = $property['name'];
            $title = $property['title'];
            switch($property['type']){
                case 'char':
                    $form->addElement('text', $name, $title, 'size="30"');
                    $form->addRule($property['name'], '���� "'.$title.'" ����������� ��� ����������', 'required', '', 'client');
                    break;

                case 'int':
                    $form->addElement('text', $name, $title, 'size="30"');
                    $form->addRule($name, '���� "'.$title.'" ����������� ��� ����������', 'required');
                    $form->addRule($name, '���� "'.$title.'" ����� ��������� ������ �������� (int)', 'numeric', '', 'client');
                    break;

                case 'text':
                    $form->addElement('textarea', $name, $title);
                    $form->addRule($name, '���� "'.$title.'" ����������� ��� ����������', 'required');
                    break;

                default:
                    break;
            }
        }

        $form->applyFilter('__ALL__', 'trim');

        $form->addElement('reset', 'reset', '������','onclick=\'javascript: jipWindow.close();\'');
        $form->addElement('submit', 'submit', '���������');
        return $form;
    }
}
?>