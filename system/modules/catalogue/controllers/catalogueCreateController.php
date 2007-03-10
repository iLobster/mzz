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

        $createType = $this->request->get('typeId', 'integer', SC_POST);

        if($createType){
            $properties = $catalogueMapper->getProperties($createType);
            $form = catalogueSaveForm::getForm($properties, $catalogueFolder, $createType);

            if($form->validate() == false){
                return 'Ошибки при вводе данных в форму';
            } else {
                $fields = array();
                foreach($properties as $property){
                    $fields[] = $property['name'];
                }

                $values = $form->exportValues();

                $catalogue = $catalogueMapper->create();
                $catalogue->setType($createType);
                $catalogue->setCreated(777);
                $catalogue->setEditor(10);

                $catalogue->setFolder($catalogueFolder);

                foreach ($fields as $field) {
                    $catalogue->setProperty($field, $values[$field]);
                }
                $catalogueMapper->save($catalogue);
                return jipTools::redirect();
            }
        } else {
            $this->smarty->assign('folder', $catalogueFolder->getId());
            $this->smarty->assign('types', $types);
            return $this->smarty->fetch('catalogue/create.tpl');
        }
    }
}

?>