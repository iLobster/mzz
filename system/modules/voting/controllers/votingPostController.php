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

/**
 * votingPostController: контроллер для метода post модуля voting
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class votingPostController extends simpleController
{
    public function getView()
    {
        $user = $this->toolkit->getUser();

        $id = $this->request->getInteger('id');

        $questionMapper = $this->toolkit->getMapper('voting', 'question');
        $answerMapper = $this->toolkit->getMapper('voting', 'answer');
        $voteMapper = $this->toolkit->getMapper('voting', 'vote');

        $question = $questionMapper->searchById($id);

        if (!$question) {
            return $questionMapper->get404()->run();
        }

        $votes = $question->getVotes();

        $answers = (array)$this->request->getArray('answer', SC_POST);
        $validAnswers = array_keys($question->getAnswers());

        foreach ($answers as $answer_id) {
            if (in_array($answer_id, $validAnswers)) {
                $answer = $answerMapper->searchById($answer_id);

                $text = (($answer->getTypeTitle() == 'text')) ? $this->request->getString('answer_' . $answer_id, SC_POST) : null;
                $voteMapper->vote($question, $answer, $user, $text);
            }
        }
        $backurl = $this->request->getString('url', SC_POST);
        if (!$backurl) {
            $url = new url('withId');
            $url->setAction('results');
            $url->add('id', $question->getId());
            $backurl = $url->get();
        }

        return $this->response->redirect($backurl);
    }
}

?>