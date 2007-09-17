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
 * forumCreateCategoryController: ���������� ��� ������ createCategory ������ forum
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumSaveCategoryController extends simpleController
{
    public function getView()
    {
        $action = $this->request->getAction();
        $isEdit = $action == 'editcategory';

        $id = $this->request->get('id', 'integer');

        $categoryMapper = $this->toolkit->getMapper('forum', 'category');

        if ($isEdit) {
            $category = $categoryMapper->searchByKey($id);
        } else {
            $category = $categoryMapper->create();
        }

        $validator = new formValidator();

        $validator->add('required', 'title', '���������� ���� �������� ���������');
        $validator->add('numeric', 'order', '�������� ������� ���������� ������ ���� ��������');

        if ($validator->validate()) {
            $category->setTitle($this->request->get('title', 'string', SC_POST));
            $category->setOrder($this->request->get('order', 'integer', SC_POST));
            $categoryMapper->save($category);

            return jipTools::redirect();
        }

        if ($isEdit) {
            $url = new url('withId');
            $url->add('id', $id);
        } else {
            $url = new url('default2');
        }

        $url->setAction($action);

        $this->smarty->assign('category', $category);
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('action', $url->get());
        return $this->smarty->fetch('forum/saveCategory.tpl');
    }
}

?>