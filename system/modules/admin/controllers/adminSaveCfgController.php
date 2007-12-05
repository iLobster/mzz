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
 * adminSaveCfgController: контроллер для метода SaveCfg модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.2
 */

class adminSaveCfgController extends simpleController
{
    protected function getView()
    {
        $action = $this->request->getAction();
        $isEdit = ($action == 'editCfg');

        $name = $this->request->get('name', 'string');
        $configMapper = $this->toolkit->getMapper('config', 'config', 'config');

        $property = array(
            'name' => '',
            'title' => '',
            'default' => ''
        );

        if ($isEdit) {
            $id = $this->request->get('id', 'string');
            $property = $configMapper->getProperty($id);
        }

        $validator = new formValidator();

        $validator->add('required', 'proptitle', 'Необходимо указать название параметра');
        $validator->add('required', 'propname', 'Необходимо указать имя параметра');
        $validator->add('regex', 'propname', 'Недопустимые символы в имени параметра', '/^[a-z0-9_\-]+$/i');

        //$validator->add('callback', 'param', 'Такой параметр уже есть у этого модуля', array('checkParamNotExists', $name, $params));

        if ($validator->validate()) {
            $type = $configMapper->searchTypeByName($name);

            $typesProperties = $configMapper->getProperties($type['id']);

            $proptype = $this->request->get('proptype', 'integer', SC_POST);
            $propname = $this->request->get('propname', 'string', SC_POST);
            $proptitle = $this->request->get('proptitle', 'string', SC_POST);
            $propdefault = $this->request->get('propdefault', 'string', SC_POST);

            if ($isEdit) {
                $configMapper->updateProperty($id, $propname, $proptitle, $propdefault, $proptype, array());
            } else {
                $newPropId = $configMapper->addProperty($propname, $proptitle, $propdefault, $proptype, array());
                $typesProperties = array();
                $typesProperties[$newPropId] = array(
                    'default' => $propdefault,
                    'sort' => 0
                );

                if ($type) {
                    $typesProperties_tmp = $configMapper->getProperties($type['id']);
                    foreach ($typesProperties_tmp as $tmp) {
                        $typesProperties[$tmp['id']] = $tmp;
                    }

                    $configMapper->updateType($type['id'], $type['name'], $type['title'], $typesProperties);
                } else {
                    $configMapper->addType($name, 'Модуль ' . $name, $typesProperties);
                }
            }

            return jipTools::closeWindow();
        }

        $properties_types_tmp = $configMapper->getAllPropertiesTypes();

        $properties = array();
        foreach ($properties_types_tmp as $prop) {
            $properties[$prop['id']] = $prop['title'] . ' (' . $prop['name'] . ')';
        }

        if ($isEdit) {
            $url = new url('withId');
            $url->add('id', $id);
        } else {
            $url = new url('withAnyParam');
            $url->setSection('admin');
        }
        $url->setAction($action);

        $this->smarty->assign('property', $property);

        $this->smarty->assign('name', $name);
        $this->smarty->assign('properties', $properties);

        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('form_action', $url->get());

        return $this->smarty->fetch('admin/saveCfg.tpl');
    }
}

function checkParamNotExists($param, $name, $params)
{
    if ($param == $name) {
        return true;
    }

    return !isset($params[$param]);
}
?>