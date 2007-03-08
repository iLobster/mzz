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
    static function getForm( simpleCatalogue $catalogue )
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('withId');
        $url->setAction('edit');
        $url->setSection('catalogue');
        $url->addParam('id', $catalogue->getId());

        $form = new HTML_QuickForm('frmObject', 'POST', $url->get());

        $defaults = array();
        foreach($catalogue->exportOldProperties() as $property => $value){
            $form->addElement('text', $property, $catalogue->getTitle($property), 'size="30"');
            $defaults[$property] = $value;
        }
        $form->setDefaults($defaults);
        $form->addElement('reset', 'reset', 'Отмена','onclick=\'javascript: jipWindow.close();\'');
        $form->addElement('submit', 'submit', 'Сохранить');
        return $form;
    }
}
?>