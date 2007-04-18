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
 * catalogueCreateController: контроллер для метода create модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueCreateController extends simpleController
{
    public function getView()
    {
        $user = $this->toolkit->getUser();
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $catalogueFolderMapper = $this->toolkit->getMapper('catalogue', 'catalogueFolder');

        $path = $this->request->get('name', 'string', SC_PATH);
        $folder = $catalogueFolderMapper->searchByPath($path);

        $types = $catalogueMapper->getAllTypes();
        if (empty($types)) {
            $controller = new messageController('Отсутствуют типы', messageController::WARNING);
            return $controller->run();
        }

        $type = $this->request->get('type', 'integer', SC_GET | SC_POST);
        $properties = $catalogueMapper->getProperties($type);

        $validator = new formValidator();
        $validator->add('required', 'name', 'Необходимо назвать новый элемент');
        $validator->add('required', 'type', 'Необходимо указать тип');

        foreach ($properties as $property) {
            if ($property['type'] == 'int') {
                $validator->add('numeric', $property['name'], 'Нужен int');
            } elseif ($property['type'] == 'float') {
                $validator->add('numeric', $property['name'], 'Нужен float');
            }
        }

        if (!$validator->validate()){
            $url = new url('withAnyParam');
            $url->setSection($this->request->getSection());
            $url->setAction('create');
            $url->addParam('name', $folder->getPath());

            $select = array();
            foreach($types as $type_tmp){
                $select[$type_tmp['id']] = $type_tmp['title'];
            }

            $this->smarty->assign('action', $url->get());
            $this->smarty->assign('errors', $validator->getErrors());
            $this->smarty->assign('folder', $folder);
            $this->smarty->assign('properties', $properties);
            $this->smarty->assign('select', $select);
            $this->smarty->assign('type', $type);
            return $this->smarty->fetch('catalogue/create.tpl');
        } else {
            $name = $this->request->get('name', 'string', SC_POST);

            $item = $catalogueMapper->create();
            $item->setType($type);
            $item->setName($name);
            $item->setFolder($folder);
            $item->setEditor($user);
            $item->setCreated(mktime());

            foreach($properties as $property){
                $propValue = $this->request->get($property['name'], 'mixed', SC_POST);
                $item->setProperty($property['name'], $propValue);
            }

            $catalogueMapper->save($item);

            return jipTools::redirect();
        }
    }
}

?>