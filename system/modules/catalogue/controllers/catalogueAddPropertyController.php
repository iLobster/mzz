<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 1309 2007-02-13 05:54:09Z zerkms $
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

        $form = cataloguePropertyForm::getForm();

        if($form->validate() == false){
            $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
            $form->accept($renderer);
            $this->smarty->assign('form', $renderer->toArray());
            return $this->smarty->fetch('catalogue/property.tpl');
        } else {
            $values = $form->exportValues();
            $catalogueMapper->addProperty($values['name'], $values['title']);
            return jipTools::redirect();
        }
    }
}

?>