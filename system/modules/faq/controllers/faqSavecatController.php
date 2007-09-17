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
 * faqSavecatController: ���������� ��� ������ createcat ������ faq
 *
 * @package modules
 * @subpackage faq
 * @version 0.1
 */

class faqSavecatController extends simpleController
{
    public function getView()
    {
        $categoryMapper = $this->toolkit->getMapper('faq', 'faqCategory');

        $name = $this->request->get('name', 'integer');

        $action = $this->request->getAction();
        $isEdit = ($action == 'editcat');

        $category = ($isEdit) ? $categoryMapper->searchByName($name) : $categoryMapper->create();

        $validator = new formValidator();
        $validator->add('required', 'name', '������� ��� ������');
        $validator->add('required', 'title', '������� ��� ������');


        if (!$validator->validate()) {
            $url = new url('withAnyParam');
            $url->setSection('faq');
            $url->setAction($action);
            $url->add('name', $category->getName());

            $this->smarty->assign('category', $category);
            $this->smarty->assign('action', $url->get());
            $this->smarty->assign('isEdit', $isEdit);
            $this->smarty->assign('errors', $validator->getErrors());
            return $this->smarty->fetch('faq/savecat.tpl');
        } else {
            $name = $this->request->get('name', 'string', SC_POST);
            $title = $this->request->get('title', 'string', SC_POST);

            $category->setName($name);
            $category->setTitle($title);

            $categoryMapper->save($category);
            return jipTools::redirect();
        }
    }
}

?>