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
 * votingSaveController: ���������� ��� ������ save ������ voting
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class votingSaveController extends simpleController
{
    public function getView()
    {
        $categoryMapper = $this->toolkit->getMapper('voting', 'voteCategory');
        $questionMapper = $this->toolkit->getMapper('voting', 'question');
        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');
        $id = $this->request->get('id', 'integer');

        if ($isEdit) {
            $question = $questionMapper->searchById($id);
        } else {
            $category = $categoryMapper->searchById($id);
            $question = $questionMapper->create();
        }

        $validator = new formValidator();
        $validator->add('required', 'question', '���������� ������ ���� �����������');

        if (!$validator->validate()) {
            $url = new url('withId');
            $url->setAction($action);
            $url->add('id', $id);

            $answerMapper = $this->toolkit->getMapper('voting', 'answer');

            $this->smarty->assign('question', $question);
            $this->smarty->assign('answers_types', $answerMapper->getAnswersTypes());
            $this->smarty->assign('action', $url->get());
            $this->smarty->assign('errors', $validator->getErrors());
            $this->smarty->assign('isEdit', $isEdit);
            return $this->smarty->fetch('voting/save.tpl');
        } else {
            if (!$isEdit) {
                $question->setCategory($category);
            }
            $question_name = $this->request->get('question', 'string', SC_POST);

            $titles = (array)$this->request->get('answers', 'array', SC_POST);
            $types = (array)$this->request->get('answers_type', 'array', SC_POST);

            $question->setQuestion($question_name);
            $question->setAnswers($titles, $types);

            $questionMapper->save($question);

            return jipTools::redirect();
        }
    }
}

?>