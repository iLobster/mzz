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
        print_r($_POST);
        exit;
        $user = $this->toolkit->getUser();

        $id = $this->request->get('id', 'integer');
        $questionMapper = $this->toolkit->getMapper('voting', 'question');
        $answerMapper = $this->toolkit->getMapper('voting', 'answer');

        $vote = $questionMapper->searchById($id);

        $answer_id = $this->request->get('answer', 'integer', SC_POST);
        $answer = $answerMapper->searchById($answer_id);

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