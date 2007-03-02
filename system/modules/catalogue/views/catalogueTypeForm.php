<?php
/**
 * $URL: http://svn.web/repository/mzz/system/modules/catalogue/views/catalogueTypeForm.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: catalogueTypeForm.php 637 2007-03-02 03:07:52Z zerkms $
 */

/**
 * catalogueTypeForm: ����� ��� ������ save ������ page
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
class catalogueTypeForm
{
    /**
     * ����� ��������� �����
     *
     * @param string $action ������� ��������
     * @param array $properties ��������
     * @param array $type ������ �������� ����
     * @return object ��������������� �����
     */
    static function getForm(array $properties, $type = false)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $defaultValues = array();
        
        $action = ( is_array($type) ) ? 'edit' : 'add';
        
        $url = new url('default2');
        $url->setAction('addType');
        $url->setSection('catalogue');
		
		if ($action == 'edit') {
            $url->setAction('editType');
			$url->setRoute('withId');
			$url->addParam('id', $type['id']);

            $defaultValues['name']  = $type['name'];
            $defaultValues['title']  = $type['title'];

            array_unshift($type['properties'], 0);
            $defaultValues['properties']  = array_flip($type['properties']);
		}
		
        $form = new HTML_QuickForm($action, 'POST', $url->get());
        $form->setDefaults($defaultValues);

        $form->addElement('text', 'name', 'Name:', 'size="30"');
        $form->addElement('text', 'title', '���������:', 'size="30"');

        foreach($properties as $property){
            $checkbox = $form->addElement('checkbox', 'properties['.$property['id'].']', null , $property['title']);
        }
        
        $form->addElement('reset', 'reset', '������','onclick=\'javascript: jipWindow.close();\'');
        $form->addElement('submit', 'submit', '���������');
        return $form;
    }
}
?>