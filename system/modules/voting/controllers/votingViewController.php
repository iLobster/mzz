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
 * votingViewController: контроллер для метода view модуля voting
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class votingViewController extends simpleController
{
    public function getView()
    {
        $id = $this->request->getInteger('id');
        $questionMapper = $this->toolkit->getMapper('voting', 'question');

        $question = $questionMapper->searchById($id);

        if (!$question) {
            return $questionMapper->get404()->run();
        }

        $this->smarty->assign('question', $question);

        if ($question->isExpired()) {
            return $this->smarty->fetch('voting/results.tpl');
        }

        $votes = $question->getVotes();
        if (!empty($votes)) {
            $this->smarty->assign('answers', $question->getAnswers());
            $this->smarty->assign('votes', $votes);
            return $this->smarty->fetch('voting/alreadyVote.tpl');
        }

        $url = new url('withId');
        $url->setAction('post');
        $url->add('id', $question->getId());

        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('backURL', $this->request->getRequestUrl());
        return $this->smarty->fetch('voting/view.tpl');
    }
}

?>