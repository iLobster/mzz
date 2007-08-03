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
 * votingPostController: ���������� ��� ������ post ������ voting
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

        $id = $this->request->get('id', 'integer');

        $questionMapper = $this->toolkit->getMapper('voting', 'question');
        $answerMapper = $this->toolkit->getMapper('voting', 'answer');
        $voteMapper = $this->toolkit->getMapper('voting', 'vote');

        $question = $questionMapper->searchById($id);

        $votes = $question->getVotes();
        if (!empty($votes) || !$question->isStarted() || $question->isExpired()) {
            return 'Not allowed';
        }

        $answers = $this->request->get('answer', 'array', SC_POST);
        $validAnswers = array_keys($question->getAnswers());

        foreach ($answers as $answer_id) {
            if (in_array($answer_id, $validAnswers)) {
                $answer = $answerMapper->searchById($answer_id);

                $text = (($answer->getTypeTitle() == 'text')) ? $this->request->get('answer_' . $answer_id, 'string', SC_POST) : null;
                $voteMapper->create($question, $answer, $user, $text);
            }
        }
        $backurl = $this->request->get('url', 'string', SC_POST);
        if (!$backurl) {
            $url = new url('default');
            $backurl = $url->get();
        }

        return $this->response->redirect($backurl);
    }
}

?>