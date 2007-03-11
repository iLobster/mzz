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

fileLoader::load('catalogue/forms/catalogueCreateForm');

/**
 * catalogueCreateController: контроллер дл€ метода create модул€ catalogue
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
        if (empty($types)){
            $controller = new messageController('ќтсутствуют типы', messageController::WARNING);
            return $controller->run();
        }

        $createType = $this->request->get('type', 'integer', SC_GET | SC_POST);

        /*if ($this->request->getMethod() == 'POST'){
            $createType = $this->request->get('type', 'integer', SC_POST);
        }*/

        $properties = $catalogueMapper->getProperties( ($createType == 0) ? $types[0]['id'] : $createType);

        $form = catalogueCreateForm::getForm($types, $folder, $createType, $properties);

        $fields = array();
        foreach($properties as $property){
            $fields[] = $property['name'];
        }

        if ($form->validate() == false){
            $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
            $renderer->setRequiredTemplate('{if $error}<font color="red"><strong>{$label}</strong></font>{else}{if $required}<span style="color: red;">*</span> {/if}{$label}{/if}');
            $renderer->setErrorTemplate('{if $error}<div class="formErrorElement">{$html}</div><font color="gray" size="1">{$error}</font>{else}{$html}{/if}');
            $form->accept($renderer);

            $this->smarty->assign('form', $renderer->toArray());
            $this->smarty->assign('folder', $folder);
            $this->smarty->assign('fields', $fields);
            return $this->smarty->fetch('catalogue/create.tpl');
        } else {
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
        }
    }
}

?>