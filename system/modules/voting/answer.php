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
 * answer: класс для работы c данными
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class answer extends simple
{
    protected $name = 'voting';

    public function getResults()
    {
        $voteMapper = systemToolkit::getInstance()->getMapper('voting', 'vote');
        return $voteMapper->getResults($this->getQuestion()->getId(), $this->getId());
    }

    public function getTypeTitle()
    {
        $type_id = $this->getType();
        $types = $this->mapper->getAnswersTypes();

        if (!isset($types[$type_id])) {
            throw new mzzRuntimeException('Неверное значение для типа ответа - ' . $type_id);
        }
        return $types[$type_id];
    }
}

?>