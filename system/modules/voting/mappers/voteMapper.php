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

fileLoader::load('voting/vote');

/**
 * voteMapper: маппер
 *
 * @package modules
 * @subpackage vote
 * @version 0.1
 */

class voteMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'voting';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'vote';

    public function searchByAnswer($answer_id)
    {
        return $this->searchAllByField('answer_id', $answer_id);
    }

    public function getResults($question_id, $answer_id)
    {
        $db = DB::factory();
        $criteria = new criteria($this->table);
        $criteria->addSelectField('COUNT(*)', 'count')->add('question_id', $question_id)->add('answer_id', $answer_id);
        $select = new simpleSelect($criteria);
        return $db->getOne($select->toString());
    }

    public function getResultsCount($question_id)
    {
        $db = DB::factory();
        $criteria = new criteria($this->table);
        $criteria->addSelectField('COUNT(*)', 'count')->add('question_id', $question_id);
        $select = new simpleSelect($criteria);
        return $db->getOne($select->toString());
    }

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return integer
     */
    public function convertArgsToId($args)
    {
        return 1;
    }
}

?>