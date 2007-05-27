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
        $select = array('' => '');
        foreach ($typesTemp as $type) {
            $types[$type['id']] = $type['name'];
            $select[$type['id']] = $type['title'] . ' (' . $type['name'] . ')';
        }

        $validator = new formValidator();
        $validator->add('required', 'name', 'Необходимо назвать это свойство');
        $validator->add('required', 'title', 'Необходимо дать метку этому свойству');
        $validator->add('required', 'type', 'Необходимо указать тип поля');

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
            }
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

            $this->smarty->assign('types', $types);
            $this->smarty->assign('selectdata', $select);
            $this->smarty->assign('isEdit', $isEdit);
            $this->smarty->assign('action', $url->get());
            $this->smarty->assign('errors', $validator->getErrors());
            return $this->smarty->fetch('catalogue/property.tpl');
        } else {
            $name = $this->request->get('name', 'string', SC_POST);
            $title = $this->request->get('title', 'string', SC_POST);
            $type = $this->request->get('type', 'integer', SC_POST);

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
