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
 * catalogueAddPropertyController: контроллер для метода addProperty модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueAddPropertyController extends simpleController
{
    public function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');

        $action = $this->request->getAction();

        if($action == 'editProperty'){
            $id = $this->request->get('id', 'integer', SC_PATH);
            $property = $catalogueMapper->getProperty($id);
            $form = cataloguePropertyForm::getForm($property);
        } else {
            $form = cataloguePropertyForm::getForm();
        }

        if($form->validate() == false){
            $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
            $form->accept($renderer);
            $this->smarty->assign('form', $renderer->toArray());
            return $this->smarty->fetch('catalogue/property.tpl');
        } else {
            $values = $form->exportValues();
            if($action == 'editProperty'){
                $catalogueMapper->updateProperty($id, $values['name'], $values['title']);
            } else {
                $catalogueMapper->addProperty($values['name'], $values['title']);
            }
            return jipTools::redirect();
        }
    }
}

?>