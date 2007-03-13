<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('catalogue/forms/cataloguePropertyForm');

/**
 * catalogueSavePropertyController: контроллер для метода editProperty модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueSavePropertyController extends simpleController
{
    public function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');

        $isEdit = ($this->request->getAction() == 'editProperty');

        $typesTemp = $catalogueMapper->getAllPropertiesTypes();
        $types = array();
        foreach($typesTemp as $type){
            $types[$type['id']] = $type['title'] . ' (' . $type['name'] . ')';
        }

        if($isEdit){
            $id = $this->request->get('id', 'integer', SC_PATH);
            $property = $catalogueMapper->getProperty($id);
            $form = cataloguePropertyForm::getForm($property, $types);
        } else {
            $form = cataloguePropertyForm::getForm(false, $types);
        }

        if($form->validate() == false){
            $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
            $form->accept($renderer);
            $this->smarty->assign('form', $renderer->toArray());
            $this->smarty->assign('isEdit', $isEdit);
            return $this->smarty->fetch('catalogue/property.tpl');
        } else {
            $values = $form->exportValues();
            if($isEdit){
                $catalogueMapper->updateProperty($id, $values['name'], $values['title'], $values['type']);
            } else {
                $catalogueMapper->addProperty($values['name'], $values['title'], $values['type']);
            }
            return jipTools::redirect();
        }
    }
}

?>