<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/modules/catalogue/forms/catalogueAssignForm.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: catalogueAssignForm.php 1377 2007-03-04 12:37:57Z mz $
 */

/**
 * catalogueAssignForm: ���������� ����� ����� �� �������
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
class catalogueAssignForm
{
    /**
     * ����� ���������� � ����� ����� �� �������
     *
     * @param HTML_QuickForm $form ������ �����
     * @param array $properties ��������
     */
    static function assign(HTML_QuickForm $form, Array $properties)
    {
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

                case 'float':
                    $form->addElement('text', $name, $title, 'size="30"');
                    $form->addRule($name, '���� "'.$title.'" ����������� ��� ����������', 'required');
                    $form->addRule($name, '���� "'.$title.'" ����� ��������� ������ �������� (float)', 'numeric', '', 'client');
                    break;

                default:
                    break;
            }
        }
    }
}
?>