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
 * catalogueSaveController: контроллер для метода save модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueSaveController extends simpleController
{
    protected function getView()
    {
        $user = $this->toolkit->getUser();
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $catalogueFolderMapper = $this->toolkit->getMapper('catalogue', 'catalogueFolder');

        $id = $this->request->get('id', 'integer', SC_PATH);

        if (empty($id)) {
            $path = $this->request->get('name', 'string', SC_PATH);
            $catalogueFolder = $catalogueFolderMapper->searchByPath($path);
        }

        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');

        $item = $isEdit ? $catalogueMapper->searchById($id) : $catalogueMapper->create();
        $defType = $isEdit ? $item->getFolder()->getDefType() : $catalogueFolder->getDefType();

        $validator = new formValidator();
        $validator->add('required', 'name', 'Необходимо назвать новый элемент');

        if (!$isEdit) {
            $validator->add('required', 'type', 'Необходимо указать тип');
            $types = $catalogueMapper->getAllTypes();
            if (empty($types)) {
                $controller = new messageController('Отсутствуют типы', messageController::WARNING);
                return $controller->run();
            }
            $type = $this->request->get('type', 'integer', SC_GET | SC_POST);
            if (empty($type)) {
                $type = $defType;
            }
            $properties = $catalogueMapper->getProperties($type);
        } else {
            $properties = $item->exportOldProperties();
        }

        foreach ($properties as $property) {
            switch ($property['type']) {
                case 'int':
                    $validator->add('numeric', $property['name'], 'Нужен int');
                    break;

                case 'float':
                    $validator->add('numeric', $property['name'], 'Нужен float');
                    break;

                case 'datetime':
                    $validator->add('regex', $property['name'], 'Неправильный формат даты', '#^(([0-1]\d|[2][0-3])\:[0-5]\d\:[0-5]\d\s([0-2]\d|[3][0-1])\/([0]\d|[1][0-2])\/[2][0]\d{2})$#');
                    break;
            }
        }

        if (!empty($item) || (!$isEdit && isset($catalogueFolder) && !is_null($catalogueFolder))) {
            if (!$validator->validate()) {
                $url = new url('withAnyParam');
                $url->setSection($this->request->getSection());
                $url->setAction($action);
                $url->addParam('name', $isEdit ? $item->getId() : $catalogueFolder->getPath());

                if (!$isEdit) {
                    foreach($types as $type_tmp){
                        $select[$type_tmp['id']] = $type_tmp['title'];
                    }
                    $this->smarty->assign('select', $select);
                    $this->smarty->assign('folder', $catalogueFolder);
                }

                $this->smarty->assign('item', $item);
                $this->smarty->assign('type', ($isEdit) ? $item->getTypeId() : $type);
                $this->smarty->assign('defType', $defType);
                $this->smarty->assign('properties', $properties);
                $this->smarty->assign('action', $url->get());
                $this->smarty->assign('errors', $validator->getErrors());
                $this->smarty->assign('isEdit', $isEdit);
                return $this->smarty->fetch('catalogue/save.tpl');
            } else {
                $name = $this->request->get('name', 'string', SC_POST);
                $item->setName($name);

                if (!$isEdit) {
                    $item->setType($type);
                    $item->setFolder($catalogueFolder);
                    $item->setCreated(mktime());
                    $item->setEditor($user);
                }

                foreach ($properties as $prop) {
                    $propValue = $this->request->get($prop['name'], 'mixed', SC_POST);

                    if ($prop['type'] == 'datetime') {
                        if (!empty($propValue)) {
                            $date = explode(' ', $propValue);
                            $time = explode(':', $date[0]);
                            $date = explode('/', $date[1]);
                            $propValue = mktime($time[0], $time[1], $time[2], $date[1], $date[0], $date[2]);
                        }
                    }

                    $item->setProperty($prop['name'], $propValue);
                }

                $catalogueMapper->save($item);

                return jipTools::redirect();
            }
        }

        return $catalogueMapper->get404()->run();
    }
}

?>