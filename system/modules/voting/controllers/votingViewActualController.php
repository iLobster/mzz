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
 * votingViewActualController: контроллер для метода viewActual модуля voting
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class votingViewActualController extends simpleController
{
    public function getView()
    {
        $name = $this->request->get('name', 'integer');
        $categoryMapper = $this->toolkit->getMapper('voting', 'voteCategory');
        $category = $categoryMapper->searchByName($name);

        $question = $category->getActual();

        if (is_null($question)) {
            $question = $category->getLast();

            if (is_null($question)) {
                return null;
            }

            $this->smarty->assign('question', $question);
            return $this->smarty->fetch('voting/results.tpl');
        }

        $votes = $question->getVotes();
        if (!empty($votes)) {
            $this->smarty->assign('question', $question);
            $this->smarty->assign('answers', $question->getAnswers());
            $this->smarty->assign('votes', $votes);
            return $this->smarty->fetch('voting/alreadyVote.tpl');
        }

        $this->smarty->assign('question', $question);

        $url = new url('withId');
        $url->setAction('post');
        $url->add('id', $question->getId());

        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('backURL', $this->request->getRequestUrl());
        return $this->smarty->fetch('voting/view.tpl');
    }
}

?>