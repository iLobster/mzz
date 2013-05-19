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
 * Класс для генерации простых UPDATE SQL-запросов
 *
 * @package system
 * @subpackage db
 * @version 0.1
 */
class simpleUpdate extends simpleSQLGenerator
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

    public function toString(array $data)
    {
        if (!sizeof($data)) {
            throw new mzzRuntimeException('Data for UPDATE query expected, empty array given');
        }

        $whereClause = array();
        $table = $this->quoteTable($this->criteria->getTable());

        $dataString = '';
        foreach ($data as $field => $value) {
            $dataString .= $this->quoteField($field) . ' = ' . $this->valueToString($value) . ', ';
        }
        $dataString = substr($dataString, 0, -2);

        foreach ($this->criteria->keys() as $key) {
            $criterion = $this->criteria->getCriterion($key);
            $whereClause[]  = $criterion->generate($this, $this->criteria->getTable(), $this->criteria->getAlias());
        }

        return 'UPDATE ' . $table . ' SET ' . $dataString . ($whereClause ? ' WHERE ' . implode(' AND ', $whereClause) : '');
    }
}

?>