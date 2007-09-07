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
        $validator->add('required', 'question', 'Необходимо задать тему голосования');
        $validator->add('regex', 'created', 'Неправильный формат даты', '#^(([0-1]\d|[2][0-3])\:[0-5]\d\:[0-5]\d\s([0-2]\d|[3][0-1])\/([0]\d|[1][0-2])\/[2][0]\d{2})$#');
        $validator->add('regex', 'expired', 'Неправильный формат даты', '#^(([0-1]\d|[2][0-3])\:[0-5]\d\:[0-5]\d\s([0-2]\d|[3][0-1])\/([0]\d|[1][0-2])\/[2][0]\d{2})$#');
        $validator->add('callback', 'expired', 'Дата окончания не может быть меньше даты старта', array(array($this, 'checkExpiredDate'), $question));

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
            $created = $this->request->get('created', 'string', SC_POST);
            $expired = $this->request->get('expired', 'string', SC_POST);

            $question->setCreated($this->getTimestampByField($created));
            $question->setExpired($this->getTimestampByField($expired));

            $titles = (array)$this->request->get('answers', 'array', SC_POST);
            $types = (array)$this->request->get('answers_type', 'array', SC_POST);

            $question->setQuestion($question_name);
            $question->setAnswers($titles, $types);

            $questionMapper->save($question);

            return jipTools::redirect();
        }
    }

    private function getTimestampByField($field)
    {
        $date = explode(' ', $field);
        $time = explode(':', $date[0]);
        $date = explode('/', $date[1]);
        return mktime($time[0], $time[1], $time[2], $date[1], $date[0], $date[2]);
    }

    public function checkExpiredDate($expired, $question)
    {
        $stamp = (is_null($question->getCreated())) ? $this->getTimestampByField$this->request->get('created', 'string', SC_POST)) : $question->getCreated();
        return ($this->getTimestampByField($expired) > $stamp);
    }
}

?>