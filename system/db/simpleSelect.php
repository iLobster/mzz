<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage db
 * @version $Id$
*/

fileLoader::load('db/criteria');

/**
 * Класс для генерации простых SELECT SQL-запросов
 *
 * @package system
 * @subpackage db
 * @version 0.1
 */
class simpleSelect
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

    /**
     * Возвращает SQL-запрос
     *
     * @return string
     */
    public function toString()
    {
        $selectClause = array();
        $joinClause = array();
        $whereClause = array();
        $orderByClause = array();
        $aliases = array();

        foreach ($this->criteria->getSelectFields() as $select) {
            $alias = $this->criteria->getSelectFieldAlias($select);

            if(in_array($alias, $aliases) && $alias) continue;
            $aliases[] = $alias;

            if ($select instanceof sqlFunction ) {
                $field = $select->toString();
            } else {
                $isFunction = (bool)strpos($select, '(');

                if (($dotpos = strpos($select, '.')) !== false) {
                    $tbl = substr($select, 0, $dotpos);
                    $fld = substr($select, $dotpos + 1);

                    $field = '`' . $tbl . '`.' . ($fld == '*' ? '*' : '`' . $fld . '`');
                } else {
                    $field = $isFunction ? $select : '`' . $select . '`';
                }
            }

            $field .= ($alias ? ' AS `' . $alias . '`' : '');
            $selectClause[] = $field;
        }

        $enableCount = $this->criteria->getEnableCount();

        foreach ($this->criteria->getJoins() as $val) {
            $joinClause[] = ' ' . $val['type'] . ' JOIN ' . strtolower($val['table']) .
            (isset($val['alias']) ? ' ' . $val['alias'] : '') .
            ' ON ' . $val['criterion']->generate();
        }

        foreach ($this->criteria->keys() as $key) {
            $criterion = $this->criteria->getCriterion($key);
            $whereClause[]  = $criterion->generate($this->criteria->getTable());
        }

        $orderByClause = $this->criteria->getOrderByFields();

        $groupByClause = $this->criteria->getGroupBy();

        $table = $this->criteria->getTable();
        if ($table && is_array($table)) {
            $table = '`' . strtolower($table['table']) . '` `' . strtolower($table['alias']) . '`';
        } elseif ($table) {
            $table = '`' . strtolower($table) . '`';
        }

        $qry = 'SELECT ' . ($enableCount ? 'SQL_CALC_FOUND_ROWS ' : '') .
        ($selectClause ? implode(', ', $selectClause) : '*') .
        (($table) ? ' FROM ' . $table : '') .
        ($joinClause ? implode($joinClause) : '') .
        ($whereClause ? ' WHERE ' . implode(' AND ', $whereClause) : '') .
        ($groupByClause ? ' GROUP BY ' . implode(', ', $groupByClause) : '') .
        ($orderByClause ? ' ORDER BY ' . implode(', ', $orderByClause) : '') .
        (($limit = $this->criteria->getLimit()) ? ' LIMIT ' . (($offset = $this->criteria->getOffset()) ? $offset . ', ' : '') . $limit : '');

        return $qry;
    }
}

?>