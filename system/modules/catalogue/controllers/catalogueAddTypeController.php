<?php
/**
 * $URL: http://svn.web/repository/mzz/system/modules/catalogue/controllers/catalogueAddTypeController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: catalogueAddTypeController.php 637 2007-03-02 03:07:52Z zerkms $
 */

fileLoader::load('catalogue/forms/catalogueTypeForm');

/**
 * catalogueAddTypeController: контроллер для метода addType модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueAddTypeController extends simpleController
{
    public function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $properties = $catalogueMapper->getAllProperties();

        $form = catalogueTypeForm::getForm($properties);

        if($form->validate() == false){
            $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
            $form->accept($renderer);

            $this->smarty->assign('form', $renderer->toArray());
            return $this->smarty->fetch('catalogue/type.tpl');
        } else {
            $values = $form->exportValues();
            if(!isset($values['properties'])){
                $values['properties'] = array();
            }
            $catalogueMapper->addType($values['name'], $values['title'], array_keys($values['properties']));
            return jipTools::redirect();
        }
    }
}

?>