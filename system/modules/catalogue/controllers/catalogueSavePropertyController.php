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
 * catalogueSavePropertyController: ���������� ��� ������ saveProperty ������ catalogue
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
        $validator->add('required', 'name', '���������� ������� ��� ��������');
        $validator->add('required', 'title', '���������� ���� ����� ����� ��������');
        $validator->add('required', 'type', '���������� ������� ��� ����');

        if ($isEdit) {
            $id = $this->request->get('id', 'integer', SC_PATH);
            $property = $catalogueMapper->getProperty($id);

            if ($property['type'] == 'select') {
                $property['args'] = unserialize($property['args']);
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
