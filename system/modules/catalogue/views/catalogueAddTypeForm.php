<?php
/**
 * $URL: http://svn.web/repository/mzz/system/modules/catalogue/views/catalogueAddTypeForm.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: catalogueAddTypeForm.php 637 2007-03-02 03:07:52Z zerkms $
 */

/**
 * catalogueAddTypeForm: форма для метода save модуля page
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
class catalogueAddTypeForm
{
    /**
     * метод получения формы
     *
     * @param string $action текущее действие
     * @param array $properties свойства
     * @param array $type массив значений типа
     * @return object сгенерированная форма
     */
    static function getForm($action, array $properties, array $type = array())
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('default2');
        $url->setAction($action);
        $url->setSection('catalogue');
        $form = new HTML_QuickForm($action, 'POST', $url->get());

        if ($action == 'editType') {
            $defaultValues = array();
            $defaultValues['name']  = $type['name'];
            $defaultValues['title']  = $type['title'];
            $form->setDefaults($defaultValues);
        }

        $form->addElement('text', 'name', 'Name:', 'size="30"');
        $form->addElement('text', 'title', 'Заголовок:', 'size="30"');

        foreach($properties as $property){
            $form->addElement('checkbox', 'properties['.$property['id'].']', null , $property['title']);
        }
        
        $form->addElement('reset', 'reset', 'Отмена','onclick=\'javascript: jipWindow.close();\'');
        $form->addElement('submit', 'submit', 'Сохранить');
        return $form;
    }
}
?>