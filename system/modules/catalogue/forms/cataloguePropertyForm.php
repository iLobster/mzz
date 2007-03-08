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
 * cataloguePropertyForm: форма для метода save модуля page
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
class cataloguePropertyForm
{
    /**
     * метод получения формы
     *
     * @param string $action текущее действие
     * @param array $properties свойства
     * @param array $type массив значений типа
     * @return object сгенерированная форма
     */
    static function getForm($property = false, Array $types = array())
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $defaultValues = array();

        $action = ( is_array($property) ) ? 'edit' : 'add';

        $url = new url('default2');
        $url->setAction('addProperty');
        $url->setSection('catalogue');

        if ($action == 'edit') {
            $url->setRoute('withId');
            $url->setAction('editProperty');
            $url->addParam('id', $property['id']);

            $defaultValues['name']  = $property['name'];
            $defaultValues['title']  = $property['title'];
            $defaultValues['type']  = $property['type_id'];
        }

        $form = new HTML_QuickForm($action, 'POST', $url->get());
        $form->setDefaults($defaultValues);

        $form->addElement('text', 'name', 'Name:', 'size="30"');
        $form->addElement('text', 'title', 'Заголовок:', 'size="30"');
        $form->addElement('select', 'type', 'Тип:', $types);

        $form->addElement('reset', 'reset', 'Отмена','onclick=\'javascript: jipWindow.close();\'');
        $form->addElement('submit', 'submit', 'Сохранить');
        return $form;
    }
}
?>