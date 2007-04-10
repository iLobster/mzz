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

fileLoader::load('catalogue/forms/catalogueTypeForm');

/**
 * catalogueSaveTypeController: контроллер для метода saveType модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueSaveTypeController extends simpleController
{
    public function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $properties = $catalogueMapper->getAllProperties();

        $isEdit = ($this->request->getAction() == 'editType');

        if($isEdit){
            $type_id = $this->request->get('id', 'integer', SC_PATH);

            $type = $catalogueMapper->getType($type_id);
            foreach($catalogueMapper->getProperties($type_id) as $property){
                $type['properties'][$property['id']] = $property;
            }

            $form = catalogueTypeForm::getForm($properties, $type);
        } else {
            $form = catalogueTypeForm::getForm($properties);
        }

        if($form->validate() == false){
            $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
            $form->accept($renderer);
            $formArray = $renderer->toArray();
            $formArray['properties'] = isset($formArray['properties']) ? $formArray['properties'] : array();

            $this->smarty->assign('form', $formArray);
            $this->smarty->assign('isEdit', $isEdit);
            return $this->smarty->fetch('catalogue/type.tpl');
        } else {
            $values = $form->exportValues();
            $values['properties'] = (isset($values['properties'])) ? $values['properties'] : array();

            $properties = array();
            foreach (array_keys($values['properties']) as $id) {
                $properties[$id]['isShort'] = isset($values['full'][$id]) ? 1 : 0;
                $properties[$id]['sort'] = isset($values['sort'][$id]) ? $values['sort'][$id] : 0;
            }

            if($isEdit){
                $catalogueMapper->updateType($type_id ,$values['name'], $values['title'], $properties);
            } else {
                $catalogueMapper->addType($values['name'], $values['title'], $properties);
            }

            return jipTools::redirect();
        }
    }
}

?>