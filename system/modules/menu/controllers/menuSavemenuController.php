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
 * menuSavemenuController: ���������� ��� ������ create ������ menu
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

        $name = $this->request->get('name', 'string');
        $menu = $isEdit ? $menuMapper->searchByName($name) : $menuMapper->create();

        $validator = new formValidator();
        $validator->add('required', 'name', '���������� ���');
        $validator->add('required', 'title', '��������� ���������');

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
            $title = $this->request->get('title', 'string', SC_POST);
            $name = $this->request->get('name', 'string', SC_POST);

            $menu->setTitle($title);
            $menu->setName($name);

            $menuMapper->save($menu);
            return jipTools::redirect();
        }
    }
}

?>