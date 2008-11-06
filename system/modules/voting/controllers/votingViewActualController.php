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
        $prefix = $this->request->getString('tplPrefix');
        $tpl = 'voting';
        if (!empty($prefix)) {
            $tpl .= '/' . $prefix;
        }
        $name = $this->request->getString('name');
        $categoryMapper = $this->toolkit->getMapper('voting', 'voteCategory');
        $category = $categoryMapper->searchByName($name);

        if (!$category) {
            return $categoryMapper->get404()->run();
        }
        $question = $category->getLast();
        if (is_null($question)) {
            return null;
        }

        if (!$question->getAcl('view')) {
            $this->smarty->assign('question', $question);
            return $this->smarty->fetch($tpl . '/results.tpl');
        }

        $votes = $question->getVotes();
        if (!empty($votes)) {
            $this->smarty->assign('question', $question);
            $this->smarty->assign('answers', $question->getAnswers());
            $this->smarty->assign('votes', $votes);
            return $this->smarty->fetch($tpl . '/alreadyVote.tpl');
        }

        $this->smarty->assign('question', $question);

        $url = new url('withId');
        $url->setAction('post');
        $url->add('id', $question->getId());

        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('backURL', $this->request->getRequestUrl());
        return $this->smarty->fetch($tpl . '/view.tpl');
    }
}

?>