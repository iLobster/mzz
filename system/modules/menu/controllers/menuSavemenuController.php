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
    public function getView()
    {
        $menuMapper = $this->toolkit->getMapper('menu', 'menu');

        $action = $this->request->getAction();
        $isEdit = ($action == 'editmenu');

        $id = $this->request->get('id', 'integer', SC_PATH);
        $menu = $isEdit ? $menuMapper->searchById($id) : $menuMapper->create();

        $validator = new formValidator();
        $validator->add('required', 'name', 'Необходимо имя');
        $validator->add('required', 'title', 'Необходим заголовок');

        if (!$validator->validate()) {
            $url = new url($isEdit ? 'withId' : 'default2');
            $url->setSection($this->request->getSection());
            $url->setAction($action);
            if ($isEdit) {
                $url->addParam('id', $menu->getId());
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