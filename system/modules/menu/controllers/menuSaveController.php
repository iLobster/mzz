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
 * menuSaveController: ���������� ��� ������ create ������ menu
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuSaveController extends simpleController
{
    public function getView()
    {
        $itemMapper = $this->toolkit->getMapper('menu', 'item');

        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');

        $id = $this->request->get('id', 'integer', SC_PATH);
        $item = $isEdit ? $itemMapper->searchById($id) : $itemMapper->create();

        $validator = new formValidator();
        $validator->add('required', 'title', '��������� ���������');
        $validator->add('required', 'url', '��������� �����');

        if (!$validator->validate()) {
            $url = new url('withId');
            $url->setSection($this->request->getSection());
            $url->setAction($action);
            $url->addParam('id', $isEdit ? $item->getId() : $id);

            $this->smarty->assign('item', $item);
            $this->smarty->assign('action', $url->get());
            $this->smarty->assign('errors', $validator->getErrors());
            $this->smarty->assign('isEdit', $isEdit);
            return $this->smarty->fetch('menu/save.tpl');
        } else {
            $title = $this->request->get('title', 'string', SC_POST);
            $url = $this->request->get('url', 'string', SC_POST);

            $item->setTitle($title);
            $item->setProperty('url', $url);

            if (!$isEdit) {
                $item->setMenu($itemMapper->searchById($id)->getMenu());
                $item->setType(1);
                $item->setParent($id);
            }

            $itemMapper->save($item);
            return jipTools::redirect();
        }
    }
}

?>