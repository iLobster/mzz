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

fileLoader::load('voting/voteCategory');

/**
 * voteCategoryMapper: маппер
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class voteCategoryMapper extends simpleMapper
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
    protected $className = 'voteCategory';

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function searchByName($name)
    {
        return $this->searchOneByField('name', $name);
    }

    public function getActual($category)
    {
        $questionMapper = systemToolkit::getInstance()->getMapper('voting', 'question');
        $voteMapper = systemToolkit::getInstance()->getMapper('voting', 'vote');

        $criteria = new criteria;
        $criterion = new criterion('vote.question_id', 'question.id', criteria::EQUAL, true);
        $criterion->addAnd(new criterion('user_id', systemToolkit::getInstance()->getUser()->getId()));
        $criteria->addJoin($voteMapper->getTable(), $criterion, 'vote', criteria::JOIN_LEFT);
        $criteria->add('category_id', $category->getId())->add('vote.id', '', criteria::IS_NULL)->add('created', time(), criteria::LESS_EQUAL)->add('expired', time(), criteria::GREATER_EQUAL);
        $criteria->setOrderByFieldAsc(new sqlFunction('RAND'), false)->setLimit(1);

        return $questionMapper->searchOneByCriteria($criteria);
    }

    public function getLast($category)
    {
        $questions = $category->getQuestions();

        if (empty($questions)) {
            return null;
        }

        $tmp = array();
        foreach ($questions as $id => $question) {
            $tmp[$id] = $question->getExpired();
        }

        asort($tmp);
        end($tmp);

        return $questions[key($tmp)];
    }

    public function delete(voteCategory $do)
    {
        $questionMapper = systemToolkit::getInstance()->getMapper('voting', 'question');
        $questions = $this->getQuestions($do->getId());
        foreach ($questions as $question) {
            $questionMapper->delete($question);
        }
        parent::delete($do->getId());
    }

    /**
     * Возвращает доменный объект по аргументам
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        $action = systemToolkit::getInstance()->getRequest()->getAction();

        if ($action == 'viewActual') {
            if (isset($args['name'])) {
                $category = $this->searchByName($args['name']);
            }
        } else {
            if (isset($args['id'])) {
                $category = $this->searchById($args['id']);
            }
        }

        if ($category) {
            return $category;
        }

        throw new mzzDONotFoundException();
    }
}

?>