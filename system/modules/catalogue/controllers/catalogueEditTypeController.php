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

fileLoader::load('catalogue/forms/catalogueTypeForm');

/**
 * catalogueEditTypeController: контроллер для метода editType модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueEditTypeController extends simpleController
{
    public function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');

        $properties = $catalogueMapper->getAllProperties();

        $type_id = $this->request->get('id', 'integer', SC_PATH);

        $type = $catalogueMapper->getType($type_id);
        foreach($catalogueMapper->getProperties($type_id) as $property){
            $type['properties'][] = $property['id'];
        }

        $form = catalogueTypeForm::getForm($properties, $type);

		if($form->validate() == false){
            $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
            $form->accept($renderer);

            $this->smarty->assign('form', $renderer->toArray());
            return $this->smarty->fetch('catalogue/type.tpl');
        }else{
            $values = $form->exportValues();
            if(!isset($values['properties'])){
                $values['properties'] = array();
            }
            $catalogueMapper->updateType($type_id ,$values['name'], $values['title'], array_keys($values['properties']));
            return jipTools::redirect();
        }
    }
}

?>