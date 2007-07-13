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

fileLoader::load('voting/question');

/**
 * questionMapper: маппер
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class questionMapper extends simpleMapper
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
    protected $className = 'question';

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function searchByName($name)
    {
        return $this->searchOneByField('name', $name);
    }

    public function getAllAnswers($id)
    {
        $answerMapper = systemToolkit::getInstance()->getMapper('voting', 'answer');
        return $answerMapper->searchAllByField('question_id', $id);
    }

    public function getVote($id, $user)
    {
        $toolkit = systemToolkit::getInstance();
        $voteMapper = $toolkit->getMapper('voting', 'vote');

        $criteria = new criteria;
        $criteria->add('user_id', $user->getId())->add('question_id', $id);

        return $voteMapper->searchOneByCriteria($criteria);
    }

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return integer
     */
    public function convertArgsToId($args)
    {
        $action = systemToolkit::getInstance()->getRequest()->getAction();

        if ($action == 'view' || $action == 'results') {
            $question = $this->searchByName($args['name']);
        } else {
            $question = $this->searchById($args['id']);
        }

        if ($question) {
            return (int)$question->getObjId();
        }

        throw new mzzDONotFoundException();
    }
}

?>