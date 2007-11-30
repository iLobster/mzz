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
 * catalogueSaveTypeController: контроллер для метода saveType модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueSaveTypeController extends simpleController
{
    protected function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $properties_tmp = $catalogueMapper->getAllProperties();

        $properties = array();
        foreach ($properties_tmp as $property) {
            $properties[$property['id']] = $property;
        }

        $action = $this->request->getAction();
        $isEdit = ($action == 'editType');

        $type = array(
            'title'         =>  '',
            'name'          =>  '',
            'properties'    =>  array()
        );

        $validator = new formValidator();
        $validator->add('required', 'name', 'Необходимо назвать этот тип');
        $validator->add('required', 'title', 'Необходимо дать метку этому типу');

        if ($isEdit) {
            $type_id = $this->request->get('id', 'integer', SC_PATH);
            $type = $catalogueMapper->getType($type_id);

            $props_tmp = $catalogueMapper->getProperties($type_id);
            $type['properties'] = array();
            foreach ($props_tmp as $prop) {
                $type['properties'][$prop['id']] = $prop;
                unset($properties[$prop['id']]);
            }
        }

        if (!$validator->validate()) {
            $url = new url('default2');
            $url->setAction($action);

            if ($isEdit) {
                $url->setRoute('withId');
                $url->add('id', $type['id']);
            }

            $this->smarty->assign('properties', $properties);
            $this->smarty->assign('action', $url->get());
            $this->smarty->assign('type', $type);
            $this->smarty->assign('isEdit', $isEdit);
            $this->smarty->assign('errors', $validator->getErrors());
            return $this->smarty->fetch('catalogue/type.tpl');
        } else {
            $name = $this->request->get('name', 'string', SC_POST);
            $title = $this->request->get('title', 'string', SC_POST);

            $newProperties_tmp = (array) $this->request->get('properties', 'mixed', SC_POST);
            $newPropertiesIsFull = (array) $this->request->get('full', 'mixed', SC_POST);
            $newPropertiesIsShort = (array) $this->request->get('short', 'mixed', SC_POST);
            $newPropertiesSort = (array) $this->request->get('sort', 'mixed', SC_POST);

            $newProperties = array();
            foreach ($newProperties_tmp as $id => $value) {
                if ($value != 0) {
                    $newProperties[$id]['isFull'] = (isset($newPropertiesIsFull[$id]) && $newPropertiesIsFull[$id] != 0) ? 1 : 0;
                    $newProperties[$id]['isShort'] = (isset($newPropertiesIsShort[$id]) && $newPropertiesIsShort[$id] != 0) ? 1 : 0;
                    $newProperties[$id]['sort'] = (isset($newPropertiesSort[$id]) && $newPropertiesSort[$id] != 0) ? (int) $newPropertiesSort[$id] : 0;
                }
            }

            if ($isEdit) {
                $catalogueMapper->updateType($type_id , $name, $title, $newProperties);
            } else {
                $catalogueMapper->addType($name, $title, $newProperties);
            }

            return jipTools::redirect();
        }
    }
}

?>