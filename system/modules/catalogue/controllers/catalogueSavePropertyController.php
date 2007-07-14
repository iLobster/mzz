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
    protected function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $action = $this->request->getAction();
        $isEdit = ($action == 'editProperty');

        $ajaxRequest = $this->request->get('ajaxRequest', 'string', SC_REQUEST);


        $typesTemp = $catalogueMapper->getAllPropertiesTypes();
        $types = array();
        $select = array('' => '');
        foreach ($typesTemp as $type_tmp) {
            $types[$type_tmp['id']] = $type_tmp['name'];
            $select[$type_tmp['id']] = $type_tmp['name'] . ' - ' . $type_tmp['title'];
        }

        $validator = new formValidator();
        $validator->add('required', 'name', 'Необходимо дать имя свойству');
        $validator->add('required', 'title', 'Необходимо указать заголовок для свойства');
        $validator->add('required', 'type_id', 'Необходимо указать тип значения свойства');

        if ($isEdit) {
            $id = $this->request->get('id', 'integer', SC_PATH);
            $property = $catalogueMapper->getProperty($id);

            switch ($property['type']) {
                case 'select':
                    $property['args'] = unserialize($property['args']);
                    break;
                case 'dynamicselect':
                    $property['args'] = unserialize($property['args']);
                    break;
                case 'img':
                    $property['args'] = unserialize($property['args']);
                    break;
            }
        }


        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $data = $adminMapper->getSectionsAndModulesWithClasses();
        $sections = array();

        foreach ($data as $name => $sectionInfo) {
            $sections[$sectionInfo['id']] = $name;
        }

        $modules = array();
        $classes = array();

        foreach ($data as $key => $section) {
            $classes[$key] = $section['modules'];
            $modules[$key] = array_keys($section['modules']);
        }

        if (!$validator->validate()) {
            $url = new url('default2');
            $url->setAction($action);
            $url->setSection($this->request->getSection());

            if ($isEdit) {
                $url->setRoute('withId');
                $url->addParam('id', $property['id']);
                $this->smarty->assign('property', $property);
            }



            if (!empty($ajaxRequest)) {
                $ajaxRequest = (is_numeric($ajaxRequest) ? $types[$ajaxRequest] : $ajaxRequest);
                switch ($ajaxRequest) {
                    case 'dynamicselect':



                        $dynamicselect_section = $isEdit && isset($property['args']['section']) ? $property['args']['section'] : false;

                        $this->smarty->assign('dynamicselect_section', $dynamicselect_section);
                        break;
                    case 'dynamicselect_modules':

                        $section_id = $this->request->get('for_id', 'integer', SC_REQUEST);
                        $modules = $adminMapper->searchModulesBySection($section_id);
                        $this->smarty->assign('data', $modules);
                        break;
                    case 'dynamicselect_classes':

                        $module_id = $this->request->get('for_id', 'integer', SC_REQUEST);
                        $classes = $adminMapper->searchClassesByModuleId($module_id);
                        $this->smarty->assign('data', $classes);
                        break;
                    case 'dynamicselect_methods':
                        $class_id = $this->request->get('for_id', 'integer', SC_REQUEST);
                        $classes = $adminMapper->getSearchMethods($class_id);
                        $this->smarty->assign('data', $classes);
                        break;
                    case 'dynamicselect_method':
                        $method_name = $this->request->get('method_name', 'string', SC_REQUEST);
                        $class_id = $this->request->get('class_id', 'integer', SC_REQUEST);
                        $data = $adminMapper->getMethodInfo($class_id, $method_name);
                        if ($data) {
                            $description = $data['description'];
                            unset($data['description']);
                            $this->smarty->assign('description', $description);
                        }
                        $this->smarty->assign('data', $data);
                        break;
                }
            }



            $propertyForm = array(
            'title' => $isEdit && isset($property['title']) ? $property['title'] : '',
            'name' => $isEdit && isset($property['name']) ? $property['name'] : '',
            'type' => $isEdit && isset($property['type']) ? $property['type'] : '',
            'type_id' => $isEdit && isset($property['type_id']) ? $property['type_id'] : ''
            );

            $this->smarty->assign(array(
            'types' => $types,
            'propertyForm' => $propertyForm,
            'selectdata' => $select,
            'isEdit' => $isEdit,
            'action' => $url->get(),
            'sections' => $sections,
            'modules' => $modules,
            'classes' => $classes,
            'ajaxRequest' => $ajaxRequest,
            'errors' => $validator->getErrors()));

            return $this->smarty->fetch('catalogue/property.tpl');
        } else {/*
            $name = $this->request->get('name', 'string', SC_POST);
            $title = $this->request->get('title', 'string', SC_POST);
            $type = $this->request->get('type_id', 'integer', SC_POST);

            $params = array();
            switch ($types[$type]) {
            case 'select':
            $values = (array) $this->request->get('selectvalues', 'mixed', SC_POST);
            $selectvalues = array();
            foreach ($values as $val) {
            $selectvalues[] = $val;
            }
            $params['args'] = serialize($selectvalues);
            break;

            case 'datetime':
            $params['args'] = $this->request->get('datetimeformat', 'string', SC_POST);
            break;

            case 'dynamicselect':
            $moduleName = $this->request->get('dynamicselect_module', 'string', SC_POST);
            $doName = $this->request->get('dynamicselect_do', 'string', SC_POST);
            $sectionName = $this->request->get('dynamicselect_section', 'string', SC_POST);
            $searchMethod = $this->request->get('dynamicselect_searchMethod', 'string', SC_POST);
            $extractMethod = $this->request->get('dynamicselect_extractMethod', 'string', SC_POST);
            $callbackParams = $this->request->get('dynamicselect_params', 'string', SC_POST);
            $nullElement = $this->request->get('dynamicselect_nullelement', 'integer', SC_POST);

            $params['args'] = serialize(array(
            'module'    =>  $moduleName,
            'do'    =>  $doName,
            'section'   =>  $sectionName,
            'searchMethod'  =>  $searchMethod,
            'extractMethod' =>  $extractMethod,
            'params' =>  $callbackParams,
            'nullElement'   =>  (bool)$nullElement
            ));
            break;

            case 'img':
            $moduleName = $this->request->get('img_module', 'string', SC_POST);
            $doName = $this->request->get('img_do', 'string', SC_POST);
            $sectionName = $this->request->get('img_section', 'string', SC_POST);
            $searchMethod = $this->request->get('img_searchMethod', 'string', SC_POST);
            $callbackParams = $this->request->get('img_params', 'string', SC_POST);

            $params['args'] = serialize(array(
            'module'    =>  $moduleName,
            'do'    =>  $doName,
            'section'   =>  $sectionName,
            'searchMethod'  =>  $searchMethod,
            'params' =>  $callbackParams
            ));
            break;
            }

            if ($isEdit) {
            $catalogueMapper->updateProperty($id, $name, $title, $type, $params);
            } else {
            $catalogueMapper->addProperty($name, $title, $type, $params);
            }
            return jipTools::redirect();*/
        }
    }
}

?>