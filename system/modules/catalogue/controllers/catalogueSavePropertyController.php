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

fileLoader::load('forms/validators/formValidator');

/**
 * catalogueSavePropertyController: контроллер для метода saveProperty модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueSavePropertyController extends simpleController
{
    public function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');

        $action = $this->request->getAction();
        $isEdit = ($action == 'editProperty');

        $typesTemp = $catalogueMapper->getAllPropertiesTypes();
        $types = array();
        foreach ($typesTemp as $type) {
            $types[$type['id']] = $type['title'] . ' (' . $type['name'] . ')';
        }

        $validator = new formValidator();
        $validator->add('required', 'name', 'Необходимо назвать это свойство');
        $validator->add('required', 'title', 'Необходимо дать метку этому свойству');
        $validator->add('required', 'type', 'Необходимо указать тип поля');

        if ($isEdit) {
            $id = $this->request->get('id', 'integer', SC_PATH);
            $property = $catalogueMapper->getProperty($id);
        }

        if (!$validator->validate()) {
            $url = new url('default2');
            $url->setAction($action);
            $url->setSection($this->request->getSection());

            if ($isEdit) {
                $url->setRoute('withId');
                $url->addParam('id', $property['id']);
            }

            $name = isset($property['name']) ? $property['name'] : '';
            $title = isset($property['title']) ? $property['title'] : '';
            $typeId = isset($property['type_id']) ? $property['type_id'] : '';

            $this->smarty->assign('name', $name);
            $this->smarty->assign('title', $title);
            $this->smarty->assign('type', $typeId);
            $this->smarty->assign('types', $types);
            $this->smarty->assign('isEdit', $isEdit);
            $this->smarty->assign('action', $url->get());
            $this->smarty->assign('errors', $validator->getErrors());
            return $this->smarty->fetch('catalogue/property.tpl');
        } else {
            $name = $this->request->get('name', 'string', SC_POST);
            $title = $this->request->get('title', 'string', SC_POST);
            $type = $this->request->get('type', 'integer', SC_POST);

            if($isEdit){
                $catalogueMapper->updateProperty($id, $name, $title, $type);
            } else {
                $catalogueMapper->addProperty($name, $title, $type);
            }
            return jipTools::redirect();
        }
    }
}

?>