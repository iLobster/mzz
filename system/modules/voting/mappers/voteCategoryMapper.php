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

    public function getQuestions($id)
    {
        $questionMapper = systemToolkit::getInstance()->getMapper('voting', 'question');
        return $questionMapper->searchAllByField('category_id', $id);
    }

    public function getActual($id)
    {
        $actualQuestions = array();;
        $questions = $this->getQuestions($id);

        if (empty($questions)) {
            return null;
        }

        foreach ($questions as $question) {
            $votes = $question->getVotes();
            if (empty($votes)) {
                $actualQuestions[] = $question;
            }
        }

        if (empty($actualQuestions)) {
            $actualQuestions = array_values($questions);
        }

        return $actualQuestions[rand(0, (count($actualQuestions) - 1))];
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
            $category = $this->searchByName($args['name']);
        } else {
            $category = $this->searchById($args['id']);
        }

        if ($category) {
            return $category;
        }

        throw new mzzDONotFoundException();
    }
}

?>