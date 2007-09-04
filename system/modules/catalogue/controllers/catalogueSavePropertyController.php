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
 * @version 0.2
 */
class catalogueSavePropertyController extends simpleController
{
    protected function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $action = $this->request->getAction();
        $isEdit = ($action == 'editProperty');
        ///$isAjax = $this->request->get('_ajax', 'string', SC_REQUEST);

        $property = array();
        $isAjax = false;

        if ($isEdit) {
            $id = $this->request->get('id', 'integer', SC_PATH);
            $property = $catalogueMapper->getProperty($id);
        }

        if (($loadType = $this->request->get('loadType', 'string', SC_REQUEST)) !== null) {
            $isAjax = true;
        } elseif ($isEdit) {
            $loadType = $property['type_id'];
        } else {
            $loadType = $this->request->get('type_id', 'integer', SC_REQUEST);
            $property['type_id'] = $loadType;
        }

        $typesTemp = $catalogueMapper->getAllPropertiesTypes();
        $types = array();
        $select = array('' => '');
        foreach ($typesTemp as $type_tmp) {
            $types[$type_tmp['id']] = $type_tmp['name'];
            $select[$type_tmp['id']] = $type_tmp['name'] . ' - ' . $type_tmp['title'];
        }

        $loadType = !empty($loadType) ? (is_numeric($loadType) ? $types[$loadType] : $loadType) : null;

        $validator = new formValidator();
        $validator->add('required', 'name', 'У свойства должно быть имя из допустимых символов (a-Z0-9)');
        $validator->add('required', 'title', 'Укажите название свойства (имя для отображения)');
        $validator->add('required', 'type_id', 'Укажите тип значения свойства');

        if ($loadType == 'dynamicselect') {
            $validator->add('required', 'typeConfig[section]', 'Укажите секцию');
            $validator->add('required', 'typeConfig[module]', 'Укажите модуль');
            $validator->add('required', 'typeConfig[class]', 'Укажите класс доменного объекта');
            $validator->add('required', 'typeConfig[searchMethod]', 'Укажите метод поиска данных');
            $validator->add('required', 'typeConfig[extractMethod]', 'Укажите метод извлечения данных из доменного объекта');

            $fieldNames = array('section', 'module', 'class', 'searchMethod', 'extractMethod');
            foreach ($fieldNames as $fieldName) {
                $validator->add('regex', 'typeConfig[' . $fieldName . ']', 'В значении допустимы только [a-z0-9_]', '/^[a-z0-9_]+$/i');
            }
        }

        if ($isEdit) {
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
        $sections = array();
        if ($loadType === 'img') {
            $data = $adminMapper->getSectionsModuleRegistered('fileManager');

            foreach ($data as $sectionInfo) {
                $sections[$sectionInfo['name']] = $sectionInfo['title'];
            }
        } else {
            $data = $adminMapper->getSectionsAndModulesWithClasses();

            foreach ($data as $name => $sectionInfo) {
                $sections[$sectionInfo['id']] = $name;
            }

            $modules = array();
            $classes = array();

            foreach ($data as $key => $section) {
                $classes[$key] = $section['modules'];
                $modules[$key] = array_keys($section['modules']);
            }
        }
        if (!$validator->validate()) {
            $url = new url('default2');
            $url->setAction($action);

            if ($isEdit) {
                $url->setRoute('withId');
                $url->add('id', $property['id']);
                $this->smarty->assign('property', $property);
            }

            if (!empty($loadType)) {

                if ($loadType == 'dynamicselect' || $loadType == 'img') {
                    $current_type_section = $isEdit && isset($property['args']['section']) ? $property['args']['section'] : false;
                    $this->smarty->assign('current_type_section', $current_type_section);
                } else {
                    switch ($loadType) {
                        case 'modules':

                            $section_id = $this->request->get('for_id', 'integer', SC_REQUEST);
                            $modules = $adminMapper->searchModulesBySection($section_id);
                            $this->smarty->assign('data', $modules);
                            break;
                        case 'classes':

                            $module_id = $this->request->get('for_id', 'integer', SC_REQUEST);
                            $classes = $adminMapper->searchClassesByModuleId($module_id);
                            $this->smarty->assign('data', $classes);
                            break;

                        case 'methods':
                            $class_id = $this->request->get('for_id', 'integer', SC_REQUEST);
                            $searchMethods = $adminMapper->getSearchMethods($class_id);
                            $this->smarty->assign('searchMethods', $searchMethods);
                            // методы извлечения данных
                            $extactMethods = $adminMapper->getClassExtractMethods($class_id);
                            $this->smarty->assign('extractMethods', $extactMethods);
                            break;

                        case 'folders':
                            $section = $this->request->get('section', 'string', SC_REQUEST);

                            $folderMapper = $this->toolkit->getMapper('fileManager', 'folder', $section);
                            $folders = $folderMapper->searchAll();

                            $foldersList = array();
                            foreach ($folders as $folder) {
                                $foldersList[$folder->getId()] = array($folder->getTitle(), $folder->getTreeLevel() - 1);
                            }
                            $this->smarty->assign('data', $foldersList);
                            break;

                        case 'method':
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
            }

            $propertyForm = $property;
            if (($typeConfig = $this->request->get('typeConfig', 'array', SC_POST)) !== null) {
                $propertyForm['typeConfig'] = $typeConfig;
            }

            if (is_array($propertyForm) && array_key_exists('args', $propertyForm)) {
                $propertyForm['typeConfig'] = $propertyForm['args'];
                unset($propertyForm['args']);
            }

            if ($loadType == 'datetime') {
                $propertyForm['typeConfig'] = $isEdit && isset($propertyForm['typeConfig']) ? $propertyForm['typeConfig'] : '%H:%M:%S %d/%m/%Y';
            }

            if (isset($propertyForm['typeConfig']) && is_array($propertyForm['typeConfig'])) {
                $propertyForm['typeConfig'] = new arrayDataspace($propertyForm['typeConfig']);
            }

            $propertyForm = new arrayDataspace($propertyForm);

            $this->smarty->assign(array(
            'types' => $types,
            'propertyForm' => $propertyForm,
            'selectdata' => $select,
            'isEdit' => $isEdit,
            'action' => $url->get(),
            'sections' => $sections,
            'isAjax' => $isAjax,
            'loadType' => $loadType,
            'errors' => $validator->getErrors()));

            if ($loadType !== 'img') {
                $this->smarty->assign('modules', $modules);
                $this->smarty->assign('classes', $classes);
            }
            return $this->smarty->fetch('catalogue/property.tpl');
        } else {
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
                    $typeConfig = new arrayDataspace($this->request->get('typeConfig', 'array', SC_POST));

                    $names = $adminMapper->getNamesOfSectionModuleClass($typeConfig['section'], $typeConfig['module'], $typeConfig['class']);
                    if (empty($names)) {
                        $controller = new messageController('Отсутствует информация о параметрах для динамического списка в БД', messageController::WARNING);
                        return $controller->run();
                    }
                    $names = $names[0];

                    $params['args'] = serialize(array(
                    'section'   =>  $names['section_name'],
                    'module'    =>  $names['module_name'],
                    'do'    =>  $names['class_name'],
                    'searchMethod'  =>  $typeConfig['searchMethod'],
                    'extractMethod' =>  $typeConfig['extractMethod'],
                    'args' =>  $typeConfig['methodArgs'],
                    'optional' =>  (boolean)$typeConfig['optional']
                    ));
                    break;

                case 'img':
                    $sectionName = $this->request->get('typeConfig[section]', 'string', SC_POST);
                    $folderId = $this->request->get('typeConfig[folder]', 'integer', SC_POST);

                    $params['args'] = serialize(array(
                    'section'   =>  $sectionName,
                    'folderId'  =>  $folderId
                    ));
                    break;
            }

            if ($isEdit) {
                $catalogueMapper->updateProperty($id, $name, $title, $type, $params);
            } else {
                $catalogueMapper->addProperty($name, $title, $type, $params);
            }
            return jipTools::redirect();
        }
    }
}

?>