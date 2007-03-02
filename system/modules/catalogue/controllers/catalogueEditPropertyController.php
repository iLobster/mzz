<?php
/**
 * $URL: http://svn.web/repository/mzz/system/modules/catalogue/controllers/catalogueEditPropertyController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: catalogueEditPropertyController.php 641 2007-03-02 22:39:51Z zerkms $
 */

fileLoader::load('catalogue/forms/cataloguePropertyForm');

/**
 * catalogueEditPropertyController: контроллер для метода editProperty модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueEditPropertyController extends simpleController
{
    public function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $id = $this->request->get('id', 'integer', SC_PATH);

        $property = $catalogueMapper->getProperty($id);

        $form = cataloguePropertyForm::getForm($property);

        if($form->validate() == false){
            $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
            $form->accept($renderer);
            $this->smarty->assign('form', $renderer->toArray());
            return $this->smarty->fetch('catalogue/property.tpl');
        } else {
            $values = $form->exportValues();
            $catalogueMapper->updateProperty($id, $values['name'], $values['title']);
            return jipTools::redirect();
        }
    }
}

?>