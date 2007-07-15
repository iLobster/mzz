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

/**
 *  ласс дл€ генерации простых SELECT SQL-запросов
 *
 * @package system
 * @subpackage db
 * @version 0.1.3
 */

class simpleSelect
{
    /**
     *  ритерии выборки
     *
     * @var criteria
     */
    private $criteria;

    /**
     *  онструктор
     *
     * @param criteria $criteria
     */
    public function __construct($criteria)
    {
        $this->criteria = $criteria;
    }

    /**
     * ¬озвращает SQL-запрос
     *
     * @return string SQL-запрос
     */
    public function toString()
    {
        $selectClause = array();
        $joinClause = array();
        $whereClause = array();
        $orderByClause = array();
        $aliases = array();

        $i = 0;
        foreach ($this->criteria->getSelectFields() as $select) {
            $alias = $this->criteria->getSelectFieldAlias($select);

            if($alias && in_array($alias, $aliases)) {
                // если поле с таким алиасом уже есть - то старое замен€ем новым
                unset($selectClause[$alias]);
            } else {
                $aliases[] = $alias;
            }

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

            if ($alias) {
                $field .= ' AS `' . $alias . '`';
            } else {
                $alias = ++$i;
            }

            $selectClause[$alias] = $field;
        }

        foreach ($this->criteria->getJoins() as $val) {
            if ($val['table'] instanceof criteria) {
                $subquery = new simpleSelect($val['table']);
                $val['table'] = '(' . $subquery->toString() . ')';
            } else {
                $val['table'] = '`' . $val['table'] . '`';
            }

            $joinClause[] = ' ' . $val['type'] . ' JOIN ' . $val['table'] .
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

        if (is_array($table)) {
            $tableAlias = $table['alias'];
            $table = $table['table'];
        }

        if ($table instanceof criteria) {
            $subselect = new simpleSelect($table);
            $table = '(' . $subselect->toString() . ')' . (isset($tableAlias) ? ' `' . $tableAlias . '`' : '');
        } elseif ($table) {
            $table = '`' . $table . '`' . (isset($tableAlias) ? ' `' . $tableAlias . '`' : '');
        }

        $qry = 'SELECT ' .
        ($this->criteria->getDistinct() ? 'DISTINCT ' : '') .
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