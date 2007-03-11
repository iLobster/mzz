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
 * catalogueObjectForm: ����� ��� ������ save ������ page
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
class catalogueObjectForm
{
    /**
     * ����� ��������� �����
     *
     * @param string $action ������� ��������
     * @param array $properties ��������
     * @param array $type ������ �������� ����
     * @return object ��������������� �����
     */
    static function getForm( simpleCatalogue $catalogue, Array $properties )
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('withId');
        $url->setAction('edit');
        $url->setSection('catalogue');
        $url->addParam('id', $catalogue->getId());

        $form = new HTML_QuickForm('frmEdit', 'POST', $url->get());


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

        $defaults = array();
        foreach($catalogue->exportOldProperties() as $property => $value){
            $defaults[$property] = $value;
        }

        $form->setDefaults($defaults);
        $form->addElement('reset', 'reset', '������','onclick=\'javascript: jipWindow.close();\'');
        $form->addElement('submit', 'submit', '���������');
        return $form;
    }
}
?>