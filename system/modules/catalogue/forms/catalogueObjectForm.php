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

fileLoader::load('catalogue/forms/catalogueAssignForm');

/**
 * catalogueObjectForm: форма для метода save модуля page
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
class catalogueObjectForm
{
    /**
     * метод получения формы
     *
     * @param string $action текущее действие
     * @param array $properties свойства
     * @param array $type массив значений типа
     * @return object сгенерированная форма
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
        $form->addElement('text', 'name', 'Имя');
        $form->addRule('name', 'Введите имя', 'required');
        catalogueAssignForm::assign($form, $properties);

        $defaults = array('name' => $catalogue->getName());
        foreach($catalogue->exportOldProperties() as $propertyName => $property){
            $defaults[$propertyName] = $property['value'];
        }
        $form->applyFilter('__ALL__', 'trim');

        $form->setDefaults($defaults);
        $form->addElement('reset', 'reset', 'Отмена','onclick=\'javascript: jipWindow.close();\'');
        $form->addElement('submit', 'submit', 'Сохранить');
        return $form;
    }
}
?>