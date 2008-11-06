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

    protected $votes = null;

    protected $results = false;

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
        if (is_null($this->votes)) {
            $toolkit = systemToolkit::getInstance();
            $user = $toolkit->getUser();
            $this->votes = $this->mapper->getVotes($this->getId(), $user);
        }

        return $this->votes;
    }

    public function getResultsCount()
    {
        $voteMapper = systemToolkit::getInstance()->getMapper('voting', 'vote', $this->section);
        return $voteMapper->getResultsCount($this->getId());
    }

    public function isStarted()
    {
        return (time() >= $this->getCreated());
    }

    public function isExpired()
    {
        return (time() >= $this->getExpired());
    }

    public function getAcl($name = null)
    {
        $allow = true;
        if ($name == 'post') {
            if (!$this->isStarted() || $this->isExpired() || (sizeof($this->getVotes()) != 0)) {
                $allow = false;
            }
        }

        return $allow && parent::getAcl($name);
    }

    public function getResult($answer)
    {
        if ($this->results === false) {
            $voteMapper = systemToolkit::getInstance()->getMapper('voting', 'vote');
            $this->results = $voteMapper->getResults($this->getId());
            if (!empty($this->results)) {
                $tmp = $this->results;
                foreach ($tmp as $result) {
                    $this->results[$result['answer_id']] = $result['count'];
                }
            }
        }

        return isset($this->results[$answer->getId()]) ? $this->results[$answer->getId()] : 0;
    }
}

?>