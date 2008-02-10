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
 * menuSavemenuController: контроллер для метода create модуля menu
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuSavemenuController extends simpleController
{
    protected function getView()
    {
        $menuMapper = $this->toolkit->getMapper('menu', 'menu');

        $action = $this->request->getAction();
        $isEdit = ($action == 'editmenu');

        $name = $this->request->getString('name');
        $menu = $isEdit ? $menuMapper->searchByName($name) : $menuMapper->create();

        $validator = new formValidator();
        $validator->add('required', 'name', 'Необходимо имя');
        $validator->add('required', 'title', 'Необходим заголовок');
        $validator->add('callback', 'name', 'Имя меню должно быть уникальным', array(array($this, 'checkName'), $menu));

        if (!$validator->validate()) {
            $url = new url($isEdit ? 'withAnyParam' : 'default2');
            $url->setAction($action);
            if ($isEdit) {
                $url->add('name', $menu->getName());
            }

            $this->smarty->assign('menu', $menu);
            $this->smarty->assign('action', $url->get());
            $this->smarty->assign('errors', $validator->getErrors());
            $this->smarty->assign('isEdit', $isEdit);
            return $this->smarty->fetch('menu/savemenu.tpl');
        } else {
            $title = $this->request->getString('title', SC_POST);
            $name = $this->request->getString('name', SC_POST);

            $menu->setTitle($title);
            $menu->setName($name);

            $menuMapper->save($menu);
            return jipTools::redirect();
        }
    }

    public function checkName($name, $menu)
    {
        if ($name == $menu->getName()) {
            return true;
        }
        $menuMapper = systemToolkit::getInstance()->getMapper('menu', 'menu');

        $criteria = new criteria();
        $criteria->add('name', $name);
        return is_null($menuMapper->searchOneByCriteria($criteria));
    }
}

?>