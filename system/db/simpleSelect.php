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
 * ����� ��� ��������� ������� SELECT SQL-��������
 *
 * @package system
 * @subpackage db
 * @version 0.2
 */

class simpleSelect
{
    /**
     * �������� �������
     *
     * @var criteria
     */
    private $criteria;

    /**
     * ������ ���� ������
     *
     * @var mzzPdo
     */
    private $db;

    /**
     * �����������
     *
     * @param criteria $criteria
     */
    public function __construct($criteria)
    {
        $this->criteria = $criteria;
    }

    /**
     * ���������� SQL-������
     *
     * @return string SQL-������
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
                // ���� ���� � ����� ������� ��� ���� - �� ������ �������� �����
                unset($selectClause[$alias]);
            } else {
                $aliases[] = $alias;
            }

            if ($select instanceof sqlFunction ) {
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
            (isset($val['alias']) ? ' ' . $val['alias'] : '') .
            ' ON ' . $val['criterion']->generate($this);
        }

        foreach ($this->criteria->keys() as $key) {
            $criterion = $this->criteria->getCriterion($key);
            $whereClause[]  = $criterion->generate($this, $this->criteria->getTable());
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

    /**
     * ��������� ������� ��� ������ � ��
     *
     * @return mzzPdo
     */
    public function getDb()
    {
        if (!$this->db) {
            $this->db = db::factory();
        }
        return $this->db;
    }

    /**
     * ������������� ��������
     *
     * @param string $value
     * @return string
     */
    public function quote($value)
    {
        return $this->getDb()->quote($value);
    }

    /**
     * ������������� �������
     *
     * @param string $alias
     * @return string
     */
    public function quoteAlias($alias)
    {
        return '`' . $alias . '`';
    }

    /**
     * ������������� ��� �����
     *
     * @param string $field
     * @return string
     */
    public function quoteField($field)
    {
        $field = str_replace('.', '`.`', $field);
        return '`' . $field . '`';
    }

    /**
     * ������������� ��� ������
     *
     * @param string $table
     * @return string
     */
    public function quoteTable($table)
    {
        return '`' . $table . '`';
    }
}

?>