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
 * @version 0.2
 */

class menuSaveController extends simpleController
{
    protected function getView()
    {
        $itemMapper = $this->toolkit->getMapper('menu', 'menuItem');
        $menuMapper = $this->toolkit->getMapper('menu', 'menu');
        $this->acceptLang($itemMapper);

        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');
        $isRoot = ($action == 'createRoot');
        $id = $this->request->getInteger('id');

        if ($isRoot) {

            $menu = $menuMapper->searchById($id);
            if (!$menu) {
                return $this->forward404($menuMapper);
            }
        } else {
            $parentItem = $itemMapper->searchById($id);
            if (!$parentItem) {
                return $this->forward404($itemMapper);
            }
            $menu = $parentItem->getMenu();
        }

        $types = $itemMapper->getMenuItemsTypes();
        $this->smarty->assign('types', $types);

        $typeId = $this->request->getInteger('type', SC_POST);
        if ($isEdit) {
            $item = $itemMapper->searchById($id);
            if (!$item) {
                return $this->forward404($itemMapper);
            }
            $menu = $item->getMenu();

            if ($typeId) {
                $objectArray = $item->export();
                $objectArray['type_id'] = $typeId;
                $item = $itemMapper->createItemFromRow($objectArray);
                unset($objectArray);
            } else {
                $typeId = $item->getType();
            }
        } else {
            $types = $itemMapper->getMenuItemsTypes();
            $item = (isset($types[$typeId])) ? $itemMapper->create($typeId) : null;
        }

        $this->smarty->assign('typeId', $typeId);

        $validator = new formValidator();
        if ($item) {
            $validator->add('required', 'title', 'Укажите заголовок');

            $args = array(
            'routeName' => $this->request->getString('route', SC_POST),
            'parts' => $this->request->getArray('parts', SC_POST),
            'routeActive' => $this->request->getArray('routeActive', SC_POST),
            'routeActiveParts' => $this->request->getArray('activeParts', SC_POST),
            'regexp' => $this->request->getString('activeRegExp', SC_POST),
            'url' => $this->request->getString('url', SC_POST)
            );

            $helper = $this->createMenuItemHelper($item);
            $helper->injectItem($validator, $item, $this->smarty, $args);
            if ($validator->validate()) {
                $helper->setArguments($item, $args);

                $title = $this->request->getString('title', SC_POST);
                $item->setTitle($title);
                $item->setMenu($menu);

                //simple hack for mark this field changed
                $item->setType($item->getType());

                if (!$isEdit) {
                    $parent = ($isRoot) ? 0 : $parentItem->getId();
                    $item->setParent($parent);
                    $item->setOrder($itemMapper->getMaxOrder($parent, $menu->getId()) + 1);
                }

                $itemMapper->save($item);
                return jipTools::redirect();
            }
        }

        $url = new url('withId');
        $url->setAction($action);
        if (!$isRoot) {
            $url->add('id', $isEdit ? $item->getId() : $id);
        } else {
            $url->add('id', $menu->getId());
        }

        $this->smarty->assign('item', $item);
        $this->smarty->assign('request', $this->request);
        $this->smarty->assign('i18nEnabled', systemConfig::$i18nEnable);
        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('isRoot', $isRoot);
        $this->smarty->assign('errors', $validator->getErrors());

        if ($item && $this->request->getBoolean('onlyProperties', SC_POST)) {
            $this->smarty->disableMain();
            return $this->smarty->fetch('menu/properties.tpl');
        }

        return $this->smarty->fetch('menu/save.tpl');
    }

    protected function createMenuItemHelper($item)
    {
        $class = get_class($item) . 'Helper';
        fileLoader::load('menu/helpers/' . $class);
        return new $class;
    }
}

?>