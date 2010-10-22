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
 * Класс для генерации простых INSERT SQL-запросов
 *
 * @package system
 * @subpackage db
 * @version 0.1
 */
class simpleInsert extends simpleSQLGenerator
{
    /**
     * Критерии выборки
     *
     * @var criteria
     */
    protected $criteria;

    /**
     * Конструктор
     *
     * @param criteria $criteria
     */
    public function __construct($criteria)
    {
        $this->criteria = $criteria;
    }

    public function toString(array $data, $ext = null)
    {
        $table = $this->quoteTable($this->criteria->getTable());

        if (is_null($ext)) {
            $fieldsString = $this->getFieldsString(array_keys($data));
            $valuesString = $this->getValuesString(array(array_values($data)));
        } else {
            $this->validateArgs($data, $ext);
            $fieldsString = $this->getFieldsString($data);
            $valuesString = $this->getValuesString($ext);
        }

        return 'INSERT INTO ' . $table . ' (' . $fieldsString . ') VALUES ' . $valuesString;
    }

    protected function getFieldsString($fields)
    {
        if (!sizeof($fields)) {
            throw new mzzRuntimeException('Fields array expects at least one item');
        }

        $fieldsString = '';
        foreach ($fields as $field) {
            $fieldsString .= $this->quoteField($field) . ', ';
        }
        return substr($fieldsString, 0, -2);
    }

    protected function getValuesString($values)
    {
        $valuesString = '';
        foreach ($values as $data) {
            $valuesString .= '(';
            foreach (array_values($data) as $value) {
                $valuesString .= $this->valueToString($value) . ', ';
            }
            $valuesString = substr($valuesString, 0, -2) . '), ';
        }
        return substr($valuesString, 0, -2);
    }

    protected function validateArgs($data, $ext)
    {
        $fieldsCount = sizeof($data);
        foreach ($ext as $values) {
            if (sizeof($values) != $fieldsCount) {
                throw new mzzRuntimeException('Data array expects ' . $fieldsCount . ' items, ' . sizeof($values) . ' given');
            }
        }
    }
}

?>