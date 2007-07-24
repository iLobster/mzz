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
 * question: класс для работы c данными
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class question extends simple
{
    protected $name = 'voting';

    public function getAnswers()
    {
        return $this->mapper->getAllAnswers($this->getId());
    }

    public function setAnswers(Array $answers, Array $types)
    {
        $answerMapper = systemToolkit::getInstance()->getMapper('voting', 'answer');
        $oldAnswers = $this->getAnswers();

        $answer_ids = array();
        $answer_types = array();
        foreach ($oldAnswers as $answ) {
            $answer_ids[] = $answ->getId();
        }

        $tmpDelete = array_diff($answer_ids, array_keys($answers));
        $tmpInsert = array_diff(array_keys($answers), $answer_ids);

        foreach ($tmpDelete as $delete) {
            $answerMapper->delete($delete);
        }

        foreach ($tmpInsert as $insert) {
            $answer = $answerMapper->create();
            $answer->setType($types[$insert]);
            $answer->setQuestion($this);
            $answer->setTitle($answers[$insert]);
            $answerMapper->save($answer);
        }
    }

    public function getVotes()
    {
        $toolkit = systemToolkit::getInstance();
        $user = $toolkit->getUser();
        return $this->mapper->getVotes($this->getId(), $user);
    }

    public function getResultsCount()
    {
        $voteMapper = systemToolkit::getInstance()->getMapper('voting', 'vote');
        return $voteMapper->getResultsCount($this->getId());
    }
}

?>