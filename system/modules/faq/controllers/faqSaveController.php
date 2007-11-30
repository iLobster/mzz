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
 * faqSaveController: контроллер для метода create модуля faq
 *
 * @package modules
 * @subpackage faq
 * @version 0.1
 */

class faqSaveController extends simpleController
{
    public function getView()
    {
        $faqMapper = $this->toolkit->getMapper('faq', 'faq');
        $categoryMapper = $this->toolkit->getMapper('faq', 'faqCategory');

        $id = $this->request->get('id', 'integer');

        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');

        $faq = ($isEdit) ? $faqMapper->searchById($id) : $faqMapper->create();

        $validator = new formValidator();
        $validator->add('required', 'question', 'Введите все данные');
        $validator->add('required', 'answer', 'Введите все данные');

        if ($isEdit) {
            $url = new url('withId');
            $url->setSection('faq');
            $url->setAction($action);
            $url->add('id', $faq->getId());
        } else {
            $name = $this->request->get('name', 'string');
            $category = $categoryMapper->searchByName($name);
            $this->smarty->assign('category', $category);

            $url = new url('withAnyParam');
            $url->setSection('faq');
            $url->setAction($action);
            $url->add('name', $category->getName());
        }


        if (!$validator->validate()) {
            $this->smarty->assign('faq', $faq);
            $this->smarty->assign('action', $url->get());
            $this->smarty->assign('isEdit', $isEdit);
            $this->smarty->assign('errors', $validator->getErrors());
            return $this->smarty->fetch('faq/save.tpl');
        } else {
            $question = $this->request->get('question', 'string', SC_POST);
            $answer = $this->request->get('answer', 'string', SC_POST);

            $faq->setQuestion($question);
            $faq->setAnswer($answer);

            if (!$isEdit) {
                $faq->setCategory($category);
            }

            $faqMapper->save($faq);
            return jipTools::redirect();
        }
    }
}

?>