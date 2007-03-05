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
            $form->addElement('text', $property['name'], $property['title'], 'size="30"');
            $form->addRule($property['name'], $property['title'].' is required', 'required');
        }

        $form->addElement('hidden', 'typeId', $type['id']);
        $form->addElement('reset', 'reset', 'Отмена','onclick=\'javascript: jipWindow.close();\'');
        $form->addElement('submit', 'submit', 'Сохранить');
        return $form;
    }
}
?>