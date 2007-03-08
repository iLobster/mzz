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
 * catalogueAddStepTwoForm: форма для метода save модуля page
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
class catalogueAddStepTwoForm
{
    /**
     * метод получения формы
     *
     * @param string $action текущее действие
     * @param array $properties свойства
     * @param array $type массив значений типа
     * @return object сгенерированная форма
     */
    static function getForm(Array $type, Array $properties, catalogueFolder $folder)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('withAnyParam');
        $url->setAction('create');
        $url->setSection('catalogue');
        $url->addParam('name', $folder->getPath());

        $form = new HTML_QuickForm('frmObject', 'POST', $url->get());
        
        foreach($properties as $property){
            $name = $property['name'];
            $title = $property['title'];
            switch($property['type']){
                case 'char':
                    $form->addElement('text', $name, $title, 'size="30"');
                    $form->addRule($property['name'], $property['title'].' обязательно для заполнения', 'required', '', 'client');
                    break;
                    
                case 'int':
                    $form->addElement('text', $name, $title, 'size="30"');
                    $form->addRule($name, $title . ' обязательно для заполнения', 'required');
                    $form->addRule($name, $title . ' может принимать только значения (int)', 'numeric', '', 'client');
                    break;
                
                case 'text':
                    $form->addElement('textarea', $name, $title);
                    $form->addRule($name, $title . ' обязательно для заполнения', 'required');
                    break;
                
                default:
                    break;
            }
        }
        $form->applyFilter('__ALL__', 'trim');

        $form->addElement('hidden', 'typeId', $type['id']);
        $form->addElement('reset', 'reset', 'Отмена','onclick=\'javascript: jipWindow.close();\'');
        $form->addElement('submit', 'submit', 'Сохранить');
        return $form;
    }
}
?>