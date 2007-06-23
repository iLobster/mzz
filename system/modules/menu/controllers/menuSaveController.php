<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('forms/validators/formValidator');

/**
 * menuSaveController: контроллер для метода create модуля menu
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuSaveController extends simpleController
{
    public function getView()
    {
        $itemMapper = $this->toolkit->getMapper('menu', 'menuItem');
        $menuMapper = $this->toolkit->getMapper('menu', 'menu');

        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');
        $isRoot = false;

        $id = $this->request->get('id', 'integer');
        if ($id === 0) {
            $menuName = $this->request->get('menu_name', 'string');
            $isRoot = true;
        }

        $item = $isEdit ? $itemMapper->searchById($id) : $itemMapper->create();
        $menu = $isRoot ? $menuMapper->searchByName($menuName) : $itemMapper->searchById($id)->getMenu();

        if (is_null($item) || ($isRoot && is_null($menu))) {
            return $menuMapper->get404()->run();
        }

        $validator = new formValidator();
        $validator->add('required', 'title', 'Необходим заголовок');

        if (!$isEdit) {
            $validator->add('required', 'type', 'Необходимо указать тип');
            $types = $itemMapper->getAllTypes();
            if (empty($types)) {
                $controller = new messageController('Отсутствуют типы', messageController::WARNING);
                return $controller->run();
            }
            $type = $this->request->get('type', 'integer', SC_GET | SC_POST);
            $properties = $itemMapper->getProperties($type);
        } else {
            $properties = $item->exportOldProperties();
        }

        if (!$validator->validate()) {
            $url = new url($isRoot ? 'menuCreateAction' : 'withId');
            if (!$isRoot) {
                $url->setSection($this->request->getSection());
                $url->setAction($action);
                $url->addParam('id', $isEdit ? $item->getId() : $id);
            } else {
                $url->addParam('id', $id);
                $url->addParam('menu_name', $menu->getName());
                $this->smarty->assign('menu', $menu);
            }

            if (!$isEdit) {
                $select = array('' => '');
                foreach($types as $type_tmp){
                    $select[$type_tmp['id']] = $type_tmp['title'];
                }
                $this->smarty->assign('select', $select);
                $this->smarty->assign('type', $type);
            }

            $this->smarty->assign('item', $item);
            $this->smarty->assign('id', $id);
            $this->smarty->assign('properties', $properties);
            $this->smarty->assign('request', $this->toolkit->getRequest());
            $this->smarty->assign('action', $url->get());
            $this->smarty->assign('errors', $validator->getErrors());
            $this->smarty->assign('isEdit', $isEdit);
            $this->smarty->assign('isRoot', $isRoot);
            return $this->smarty->fetch('menu/save.tpl');
        } else {
            $title = $this->request->get('title', 'string', SC_POST);

            $item->setTitle($title);

            if (!$isEdit) {
                $item->setMenu($menu);
                $item->setType($type);
                $item->setParent($id);
            }

            foreach ($properties as $prop) {
                $propValue = $this->request->get($prop['name'], 'mixed', SC_POST);
                $item->setProperty($prop['name'], $propValue);
            }

            $itemMapper->save($item);
            return jipTools::redirect();
        }
    }
}

?>