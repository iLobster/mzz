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
 * votingSavecategoryController: контроллер для метода savecategory модуля voting
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class votingSavecategoryController extends simpleController
{
    public function getView()
    {
        $categoryMapper = $this->toolkit->getMapper('voting', 'voteCategory');
        $action = $this->request->getAction();
        $isEdit = ($action == 'editcategory');
        $id = $this->request->get('id', 'integer');
        $category = ($isEdit) ? $categoryMapper->searchById($id) : $categoryMapper->create();

        $validator = new formValidator();
        $validator->add('required', 'name', 'Необходимо задать имя категории');
        $validator->add('callback', 'name', 'Имя категории должно быть уникальным', array(array($this, 'checkName'), $category));

        if (!$validator->validate()) {
            $url = new url(($isEdit) ? 'withId' : 'default2');
            $url->setAction($action);
            $url->add('id', $id);

            $this->smarty->assign('category', $category);
            $this->smarty->assign('action', $url->get());
            $this->smarty->assign('errors', $validator->getErrors());
            $this->smarty->assign('isEdit', $isEdit);
            return $this->smarty->fetch('voting/savecategory.tpl');
        } else {
            $name = $this->request->get('name', 'string', SC_POST);
            $title = $this->request->get('title', 'string', SC_POST);

            $category->setName($name);
            $category->setTitle($title);

            $categoryMapper->save($category);

            return jipTools::redirect();
        }
    }

    public function checkName($name, $category)
    {
        if ($name == $category->getName()) {
            return true;
        }
        $categoryMapper = $this->toolkit->getMapper('voting', 'voteCategory');
        return is_null($categoryMapper->searchOneByField('name', $name));
    }
}

?>