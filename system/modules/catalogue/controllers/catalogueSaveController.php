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

fileLoader::load('catalogue/forms/catalogueSaveForm');

/**
 * catalogueSaveController: контроллер для метода save модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueSaveController extends simpleController
{
    public function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $catalogueFolderMapper = $this->toolkit->getMapper('catalogue', 'catalogueFolder');
        $id = $this->request->get('id', 'integer', SC_PATH);

        $folderId = $this->request->get('folderId', 'integer', SC_POST);
        $typeId = $this->request->get('typeId', 'integer', SC_POST);

        $folder = $catalogueFolderMapper->searchById($folderId);

        $properties = $catalogueMapper->getProperties($id);

        $form = catalogueSaveForm::getForm($properties, $folder, $typeId);

        $fields = array();
        foreach($properties as $property){
            $fields[] = $property['name'];
        }

        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $form->accept($renderer);

        $this->smarty->assign('form', $renderer->toArray());
        $this->smarty->assign('fields', $fields);

        return $this->smarty->fetch('catalogue/save.tpl');
    }
}

?>