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
 * @version $Id$
 */

fileLoader::load('db/criteria');
fileLoader::load('db/simpleSQLGenerator');

/**
 * Класс для генерации простых SELECT SQL-запросов
 *
 * @package system
 * @subpackage db
 * @version 0.2.4
 */
class simpleSelect extends simpleSqlGenerator
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
     * @return string SQL-запрос
     */
    public function toString()
    {
        $selectClause = array();
        $joinClause = array();
        $whereClause = array();
        $orderByClause = array();
        $havingClause = array();
        $groupByClause = array();
        $aliases = array();

        $i = 0;

        foreach ($this->criteria->getSelectFields() as $select) {
            $alias = $this->criteria->getSelectFieldAlias($select);

            if($alias && in_array($alias, $aliases)) {
                // если поле с таким алиасом уже есть - то старое заменяем новым
                unset($selectClause[$alias]);
            } else {
                $aliases[] = $alias;
            }

            if ($select instanceof sqlFunction || $select instanceof sqlOperator) {
                $field = $select->toString($this);
            } else {
                if (($dotpos = strpos($select, '.')) !== false) {
                    $tbl = substr($select, 0, $dotpos);
                    $fld = substr($select, $dotpos + 1);

                    $field = $this->quoteTable($tbl) . '.' . ($fld == '*' ? '*' : $this->quoteField($fld));
                } else {
                    $field = $this->quoteField($select);
                }
            }

            if ($alias) {
                $field .= ' AS ' . $this->quoteAlias($alias);
            } else {
                $alias = ++$i;
            }

            $selectClause[$alias] = $field;
        }

        foreach ($this->criteria->getJoins() as $val) {
            if ($val['table'] instanceof criteria) {
                $subquery = new simpleSelect($val['table']);
                $val['table'] = '(' . $subquery->toString($this) . ')';
            } else {
                $val['table'] = $this->quoteTable($val['table']);
            }

            $joinClause[] = ' ' . $val['type'] . ' JOIN ' . $val['table'] .
            (isset($val['alias']) ? ' ' . $this->quoteAlias($val['alias']) : '') .
            ' ON ' . $val['criterion']->generate($this);
        }

        foreach ($this->criteria->keys() as $key) {
            $criterion = $this->criteria->getCriterion($key);
            $whereClause[]  = $criterion->generate($this, $this->criteria->getTable(), $this->criteria->getAlias());
        }

        $table = $this->criteria->getTable();

        if (is_array($table)) {
            $tableAlias = $this->quoteAlias($table['alias']);
            $table = $table['table'];
        }

        if ($table instanceof criteria) {
            $subselect = new simpleSelect($table);
            $table = '(' . $subselect->toString($this) . ')' . (isset($tableAlias) ? ' ' . $tableAlias : '');
        } elseif ($table) {
            $table = $this->quoteTable($table) . (isset($tableAlias) ? ' ' . $tableAlias : '');
        }

        $orderBySettings = $this->criteria->getOrderBySettings();
        foreach ($this->criteria->getOrderByFields() as $key => $val) {
            if ($val instanceof sqlFunction) {
                $order = $val->toString($this);
            } elseif ($val instanceof criterion) {
                $order = $val->generate($this);
            } else {
                $order = $this->quoteField($val);

                if (strpos($val, '.') === false && (!isset($orderBySettings[$key]['alias']) || $orderBySettings[$key]['alias'] == true)) {
                    $order = (isset($tableAlias) ? $tableAlias : $table) . '.' . $order;
                }
            }

            $order .= ' ' . $orderBySettings[$key]['direction'];

            $orderByClause[] = $order;
        }

        $groupByClause = $this->criteria->getGroupBy();

        foreach ($this->criteria->getHaving() as $key => $val) {
            $havingClause[] = $val->generate($this, $this->criteria->getTable(), $this->criteria->getAlias());
        }

        $useIndex = $this->criteria->getUseIndex();
        $selectOptions = $this->criteria->getSelectOptions();

        $qry = 'SELECT ' .
        ($selectOptions ? implode(' ', $selectOptions) . ' ' : '') .
        ($this->criteria->getDistinct() ? 'DISTINCT ' : '') .
        ($selectClause ? implode(', ', $selectClause) : '*') .
        (($table) ? ' FROM ' . $table : '') .
        ($useIndex ? ' USE INDEX (' . implode(', ', $useIndex) . ')' : '') .
        ($joinClause ? implode($joinClause) : '') .
        ($whereClause ? ' WHERE ' . implode(' AND ', $whereClause) : '') .
        ($groupByClause ? ' GROUP BY ' . implode(', ', $groupByClause) : '') .
        ($havingClause ? ' HAVING ' . implode(' AND ', $havingClause) : '') .
        ($orderByClause ? ' ORDER BY ' . implode(', ', $orderByClause) : '') .
        (($limit = $this->criteria->getLimit()) ? ' LIMIT ' . (($offset = $this->criteria->getOffset()) ? $offset . ', ' : '') . $limit : '');

        return $qry;
    }
}

?>