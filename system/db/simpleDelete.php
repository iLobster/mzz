<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('db/criteria');
fileLoader::load('db/simpleSQLGenerator');

/**
 * Класс для генерации простых DELETE SQL-запросов
 *
 * @package system
 * @subpackage db
 * @version 0.1
 */
class simpleDelete extends simpleSQLGenerator
{
    /**
     * Критерии выборки
     *
     * @var criteria
     */
    private $criteria;

    /**
     * Конструктор
     *
     * @param criteria $criteria
     */
    public function __construct($criteria)
    {
        $this->criteria = $criteria;
    }

    public function toString()
    {
        $whereClause = array();
        $table = $this->quoteTable($this->criteria->getTable());

        foreach ($this->criteria->keys() as $key) {
            $criterion = $this->criteria->getCriterion($key);
            $whereClause[]  = $criterion->generate($this, $this->criteria->getTable());
        }

        $qry = 'DELETE FROM ' . $table .
        ($whereClause ? ' WHERE ' . implode(' AND ', $whereClause) : '');

        return $qry;
    }
}

?>