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

fileLoader::load('voting/answer');

/**
 * answerMapper: маппер
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class answerMapper extends simpleMapper
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
    protected $className = 'answer';

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function getAnswersTypes()
    {
        return array(
            0 => 'radio',
            1 => 'checkbox',
            2 => 'text'
        );
    }

    public function delete($id)
    {
        $voteMapper = systemToolkit::getInstance()->getMapper('voting', 'vote');
        $voteMapper->deleteByAnswer($id);
        parent::delete($id);
    }

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return integer
     */
    public function convertArgsToObj($args)
    {
        if (isset($args['id'])) {
            $answer = $this->searchById($args['id']);

            if ($answer) {
                return $answer
            }
        }

        throw new mzzDONotFoundException();
    }
}

?>