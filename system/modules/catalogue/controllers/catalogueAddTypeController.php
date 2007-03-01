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

/**
 * catalogueAddTypeController: ���������� ��� ������ addType ������ catalogue
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
        
        fileLoader::load('catalogue/views/catalogueAddTypeForm');
        $form = catalogueAddTypeForm::getForm($this->request->getAction(), $properties);
        
        if($form->validate() == false){
            $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
            $form->accept($renderer);

            $this->smarty->assign('form', $renderer->toArray());
            $this->smarty->assign('properties', $properties);
            return $this->smarty->fetch('catalogue/addType.tpl');
        }else{
            $values = $form->exportValues();
            if(isset($values['properties'])){
                $properties = array();
                foreach($values['properties'] as $id => $value){
                    $properties[] = $id;
                }
                unset($values['properties']);
            }
            $catalogueMapper->addType($values['name'], $values['title'], $properties);
            return jipTools::redirect();
        }
    }
}

?>