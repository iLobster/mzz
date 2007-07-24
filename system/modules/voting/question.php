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

        $tmpDelete = array_diff(array_keys($oldAnswers), array_keys($answers));
        $tmpInsert = array_diff(array_keys($answers), array_keys($oldAnswers));

        foreach ($tmpDelete as $delete) {
            $answerMapper->delete($delete);
            if (isset($answers[$delete])) {
                unset($answers[$delete]);
            }
        }

        foreach ($answers as $id => $title) {
            if (in_array($id, $tmpInsert)) {
                $answer = $answerMapper->create();
                $answer->setQuestion($this);
            } else {
                $answer = $answerMapper->searchById($id);
            }

            $answer->setTitle($title);
            $answer->setType(isset($types[$id]) ? $types[$id] : 0);
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