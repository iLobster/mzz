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

fileLoader::load('catalogue/forms/catalogueAddStepOneForm');
fileLoader::load('catalogue/forms/catalogueAddStepTwoForm');

fileLoader::load('catalogue/forms/catalogueSaveForm');

/**
 * catalogueCreateController: контроллер для метода create модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueCreateController extends simpleController
{
    public function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $catalogueFolderMapper = $this->toolkit->getMapper('catalogue', 'catalogueFolder');

        $path = $this->request->get('name', 'string', SC_PATH);

        $catalogueFolder = $catalogueFolderMapper->searchByPath($path);

        $types = $catalogueMapper->getAllTypes();
        $form = catalogueAddStepOneForm::getForm($types, $catalogueFolder);

        if($form->validate() == false){
            $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
            $form->accept($renderer);

            $this->smarty->assign('form', $renderer->toArray());
            $this->smarty->assign('folder', $catalogueFolder->getId());
            return $this->smarty->fetch('catalogue/addStep1.tpl');
        } else {
            $values = $form->exportValues();

            $properties = $catalogueMapper->getProperties($_POST['typeId']);

            $fields = array();
            foreach($properties as $property){
                $fields[] = $property['name'];
            }

            $catalogue = $catalogueMapper->create();
            $catalogue->setType($_POST['typeId']);
            $catalogue->setCreated(777);
            $catalogue->setEditor(10);

            $catalogue->setFolder($catalogueFolder);

            foreach ($fields as $field) {
                $catalogue->setProperty($field, $_POST[$field]);
            }
            $catalogueMapper->save($catalogue);

            return jipTools::redirect(/*$url->get()*/);

            print_r($_POST);
            exit();
            if(!isset($values['type'])){
                $values['type'] = $this->request->get('typeId', 'integer', SC_POST);
            }

            $type = $catalogueMapper->getType($values['type']);
            $properties = $catalogueMapper->getProperties($type['id']);

            $formStepTwo = catalogueAddStepTwoForm::getForm($type, $properties, $catalogueFolder);

            $fields = array();
            foreach($properties as $property){
                $fields[] = $property['name'];
            }

            if($formStepTwo->validate() == false){
                $renderer2 = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
                $formStepTwo->accept($renderer2);

                $this->smarty->assign('fields', $fields);
                $this->smarty->assign('type', $type);
                $this->smarty->assign('form', $renderer2->toArray());
                return $this->smarty->fetch('catalogue/addStep2.tpl');
            } else {
                $objectValues = $formStepTwo->exportValues();

                $catalogue = $catalogueMapper->create();
                $catalogue->setType($values['type']);
                $catalogue->setCreated(777);
                $catalogue->setEditor(10);

                $catalogue->setFolder($catalogueFolder);

                foreach ($fields as $field) {
                    $catalogue->setProperty($field, $objectValues[$field]);
                }
                $catalogueMapper->save($catalogue);

                /*
                $url = new url('withAnyParam');
                $url->setAction('list');
                $url->setSection('catalogue');
                $url->addParam('name', $catalogueFolder->getPath());
                */
                return jipTools::redirect(/*$url->get()*/);
            }
        }
    }
}

?>