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
 * votingSaveController: контроллер для метода save модуля voting
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class votingSaveController extends simpleController
{
    public function getView()
    {
        $questionMapper = $this->toolkit->getMapper('voting', 'question');
        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');

        $id = $this->request->get('id', 'integer');
        $question = ($isEdit) ? $questionMapper->searchById($id) : $questionMapper->create();

        $validator = new formValidator();
        $validator->add('required', 'name', 'Необходимо задать имя голосования');
        $validator->add('callback', 'name', 'Имя голосования должно быть уникальным', array(array($this, 'uniqueName')));
        $validator->add('required', 'question', 'Необходимо задать тему голосования');

        if (!$validator->validate()) {
            $url = new url(($isEdit) ? 'withId' : 'default2');
            $url->setAction($action);
            $url->addParam('id', $id);

            $answerMapper = $this->toolkit->getMapper('voting', 'answer');

            $this->smarty->assign('question', $question);
            $this->smarty->assign('answers_types', $answerMapper->getAnswersTypes());
            $this->smarty->assign('action', $url->get());
            $this->smarty->assign('errors', $validator->getErrors());
            $this->smarty->assign('isEdit', $isEdit);
            return $this->smarty->fetch('voting/save.tpl');
        } else {
            $name = $this->request->get('name', 'string', SC_POST);
            $question_name = $this->request->get('question', 'string', SC_POST);

            $titles = (array)$this->request->get('answers', 'array', SC_POST);
            $types = (array)$this->request->get('answers_type', 'array', SC_POST);

            $question->setName($name);
            $question->setQuestion($question_name);
            $question->setAnswers($titles, $types);
            $questionMapper->save($question);

            return jipTools::redirect();
        }
    }

    public function uniqueName($name)
    {
        $questionMapper = $this->toolkit->getMapper('voting', 'question');
        $questionsTmp = $questionMapper->searchAll();
        $questions = array();
        foreach ($questionsTmp as $do) {
            $questions[] = $do->getName();
        }

        return !in_array($name, $questions);
    }
}

?>