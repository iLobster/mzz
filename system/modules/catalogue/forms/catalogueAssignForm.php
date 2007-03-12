<?php
/**
 * $URL: http://svn.web/repository/mzz/system/modules/catalogue/forms/catalogueAssignForm.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: catalogueAssignForm.php 674 2007-03-11 22:27:52Z zerkms $
 */

/**
 * catalogueAssignForm: добавлени€ полей формы из массива
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
class catalogueAssignForm
{
    /**
     * метод добавлени€ в форму полей из массива
     *
     * @param HTML_QuickForm $form объект формы
     * @param array $properties свойства
     */
    static function assign(HTML_QuickForm $form, Array $properties)
    {
        foreach($properties as $property){
            $name = $property['name'];
            $title = $property['title'];
            switch($property['type']){
                case 'char':
                    $form->addElement('text', $name, $title, 'size="30"');
                    $form->addRule($property['name'], 'ѕоле "'.$title.'" об€зательно дл€ заполнени€', 'required', '', 'client');
                    break;

                case 'int':
                    $form->addElement('text', $name, $title, 'size="30"');
                    $form->addRule($name, 'ѕоле "'.$title.'" об€зательно дл€ заполнени€', 'required');
                    $form->addRule($name, 'ѕоле "'.$title.'" может принимать только значени€ (int)', 'numeric', '', 'client');
                    break;

                case 'text':
                    $form->addElement('textarea', $name, $title);
                    $form->addRule($name, 'ѕоле "'.$title.'" об€зательно дл€ заполнени€', 'required');
                    break;

                case 'float':
                    $form->addElement('text', $name, $title, 'size="30"');
                    $form->addRule($name, 'ѕоле "'.$title.'" об€зательно дл€ заполнени€', 'required');
                    $form->addRule($name, 'ѕоле "'.$title.'" может принимать только значени€ (float)', 'numeric', '', 'client');
                    break;

                default:
                    break;
            }
        }
    }
}
?>