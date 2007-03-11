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

//fileLoader::load('catalogue/forms/catalogueAddStepOneForm');
//fileLoader::load('catalogue/forms/catalogueAddStepTwoForm');

fileLoader::load('catalogue/forms/catalogueSaveForm');
fileLoader::load('catalogue/forms/catalogueCreateForm');

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
        $folder = $catalogueFolderMapper->searchByPath($path);

        $types = $catalogueMapper->getAllTypes();

        $createType = $this->request->get('type', 'integer', SC_GET);

        if ($this->request->getMethod() == 'POST'){
            if($createType == 0){
                $createType = $this->request->get('type', 'integer', SC_POST);
            }
        }
        $properties = array();
        if($createType != 0){
            $properties = $catalogueMapper->getProperties($createType);
        }
        $form = catalogueCreateForm::getForm($types, $folder, $createType, $properties);

        $fields = array();
        foreach($properties as $property){
            $fields[] = $property['name'];
        }

        if ($form->validate()){
            $values = $form->exportValues();

            $item = $catalogueMapper->create();
            $item->setType($values['type']);
            $item->setFolder($folder);
            $item->setEditor(1);
            $item->setCreated(1);

            foreach ($fields as $field) {
            	$item->setProperty($field, $values[$field]);
            }

            $catalogueMapper->save($item);

            return jipTools::redirect();
        } else {
            $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
            $form->accept($renderer);

            $this->smarty->assign('form', $renderer->toArray());
            $this->smarty->assign('folder', $folder);
            $this->smarty->assign('fields', $fields);
            return $this->smarty->fetch('catalogue/create.tpl');
        }
    }
}

?>