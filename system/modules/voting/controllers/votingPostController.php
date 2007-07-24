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

        $id = $this->request->get('id', 'integer');
        $questionMapper = $this->toolkit->getMapper('voting', 'question');
        $answerMapper = $this->toolkit->getMapper('voting', 'answer');
        $voteMapper = $this->toolkit->getMapper('voting', 'vote');

        $question = $questionMapper->searchById($id);

        $answers = $this->request->get('answer', 'array', SC_POST);

        foreach ($answers as $answer_id) {
            if ($answer_id != 0) {
                $answer = $answerMapper->searchById($answer_id);

                $vote = $voteMapper->create();
                $vote->setUser($user);
                $vote->setQuestion($question);
                $vote->setAnswer($answer);

                if ($answer->getTypeTitle() == 'text') {
                    $text = $this->request->get('answer_' . $answer_id, 'string', SC_POST);
                    $vote->setText($text);
                }

                $voteMapper->save($vote);
            }
        }
        $backurl = $this->request->get('url', 'string', SC_POST);
        if (!$backurl) {
            $url = new url('default');
            $backurl = $url->get();
        }

        return $this->response->redirect($backurl);


        $answers = array();
        foreach ($vote->getAnswers() as $ans) {
            $answers[] = $ans->getId();
        }

        if (!$answer || !in_array($answer->getId(), $answers)) {
            //@todo: а чо тут ваще выводить? шаблон? или ваще эксшепшн кидать?
            return 'а вот хер!';
        }

        $voteMapper = $this->toolkit->getMapper('voting', 'vote');
        $newVote = $voteMapper->create();
        $newVote->setUser($user);
        $newVote->setQuestion($vote);
        $newVote->setAnswer($answer);
        exit;
        $voteMapper->save($newVote);

        $backurl = $this->request->get('url', 'string', SC_POST);
        if (!$backurl) {
            $url = new url('default');
            $backurl = $url->get();
        }

        return $this->response->redirect($backurl);
    }
}

?>