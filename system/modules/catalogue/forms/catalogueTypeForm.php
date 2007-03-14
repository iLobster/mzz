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
 * catalogueTypeForm: форма для метода save модуля page
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
class catalogueTypeForm
{
    /**
     * метод получения формы
     *
     * @param string $action текущее действие
     * @param array $properties свойства
     * @param array $type массив значений типа
     * @return object сгенерированная форма
     */
    static function getForm(array $properties, $type = false, $fulltpl = null, $litetpl = null)
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
            $defaultValues['fulltpl']  = $type['fulltpl'];
            if(!empty($type['properties'])){
                array_unshift($type['properties'], 0);
                $defaultValues['properties']  = array_flip($type['properties']);
            }
        }

        $form = new HTML_QuickForm($action, 'POST', $url->get());
        $form->setDefaults($defaultValues);

        $form->addElement('text', 'name', 'Name:', 'size="30"');
        $form->addElement('text', 'title', 'Заголовок:', 'size="30"');

        foreach($properties as $property){
            $form->addElement('checkbox', 'properties['.$property['id'].']', null , $property['title']);
        }
        $form->addElement('textarea', 'fulltpl', 'Полный шаблон:');

        $form->addElement('reset', 'reset', 'Отмена','onclick=\'javascript: jipWindow.close();\'');
        $form->addElement('submit', 'submit', 'Сохранить');
        return $form;
    }
}
?>