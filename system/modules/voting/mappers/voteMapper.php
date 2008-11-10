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
 * voteMapper: маппер
 *
 * @package modules
 * @subpackage vote
 * @version 0.1
 */

class voteMapper
{
    protected $db = null;

    protected $section = null;

    protected $table = null;

    public function __construct($section)
    {
        $this->db = DB::factory();
        $this->section = $section;
        $this->table = $this->section . '_vote';
    }

    public function getTable()
    {
        return $this->table;
    }

    public function deleteByAnswer($answer_id)
    {
        return $this->db->query('DELETE FROM `' . $this->table . '` WHERE `answer_id` = ' . (int) $answer_id);
    }

    public function searchVotes($question, user $user)
    {
        return $this->db->getAll('SELECT * FROM `' . $this->table . '` WHERE `question_id` = ' . (int) $question . ' AND `user_id` = ' . (int) $user->getId());
    }

    public function vote(question $question, answer $answer, user $user, $text = null)
    {
        $toolkit = systemToolkit::getInstance();
        $questionMapper = $toolkit->getMapper('voting', 'question', $this->section);
        $stmt = $this->db->prepare('INSERT INTO `' . $this->table . '` (`question_id`, `answer_id`, `user_id`, `text`) VALUES (:question, :answer, :user, :text)');
        $stmt->bindParam('question', $question->getId());
        $stmt->bindParam('answer', $answer->getId());
        $stmt->bindParam('user', $user->getId());
        $stmt->bindParam('text', $text);
        if ($stmt->execute()) {
            $question->setVotesCount($question->getVotesCount() + 1);
            $questionMapper->save($question);
            return true;
        }
        return false;
    }

    public function getResults($question_id)
    {
        $criteria = new criteria($this->table);
        $criteria->addSelectField('answer_id');
        $criteria->addSelectField(new sqlFunction('count', '*', true), 'count')->add('question_id', $question_id);
        $criteria->addGroupBy('answer_id');
        $select = new simpleSelect($criteria);
        return $this->db->getAll($select->toString(), PDO::FETCH_ASSOC);
    }
}

?>