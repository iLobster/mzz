<?php
/**
 * $URL: http://svn.web/repository/mzz/system/modules/catalogue/controllers/catalogueEditObjectController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: catalogueEditObjectController.php 641 2007-03-02 22:39:51Z zerkms $
 */

fileLoader::load('catalogue/forms/catalogueObjectForm');

/**
 * catalogueEditObjectController: контроллер для метода editObject модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueEditObjectController extends simpleController
{
    public function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');

        $objectId = $this->request->get('id', 'integer', SC_PATH);

        $catalogue = $catalogueMapper->searchById($objectId);

        $form = catalogueObjectForm::getForm($catalogue);

        if($form->validate() == false){
            $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
            $form->accept($renderer);

            $this->smarty->assign('fields', array_keys($catalogue->exportOldProperties()));
            $this->smarty->assign('form', $renderer->toArray());
            return $this->smarty->fetch('catalogue/object.tpl');
        } else {
            $values = $form->exportValues();

            foreach(array_keys($catalogue->exportOldProperties()) as $property){
                $catalogue->setProperty($property, $values[$property]);
            }

            $catalogueMapper->save($catalogue);
            return jipTools::redirect();
        }
    }
}

?>