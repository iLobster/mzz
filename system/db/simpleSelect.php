<?php

fileLoader::load('db/criteria');

class simpleSelect
{
    private $criteria;

    public function __construct($criteria)
    {
        $this->criteria = $criteria;
    }

    public function toString()
    {
        $selectClause = array();
        $joinClause = array();
        $whereClause = array();
        $orderByClause = array();

        foreach ($this->criteria->getSelectFields() as $select) {
            $alias = $this->criteria->getSelectFieldAlias($select);

            $isFunction = (bool)strpos($select, '(');

            if (($dotpos = strpos($select, '.')) !== false) {
                $tbl = substr($select, 0, $dotpos);
                $fld = substr($select, $dotpos + 1);

                $field = '`' . $tbl . '`.' . ($fld == '*' ? '*' : '`' . $fld . '`');
            } else {
                $field = $isFunction ? $select : '`' . $select . '`';
            }

            $field .= ($alias ? ' AS `' . $alias . '`' : '');
            $selectClause[] = $field;
        }

        $enableCount = $this->criteria->getEnableCount();

        foreach ($this->criteria->getJoins() as $val) {
            $joinClause[] = ' LEFT JOIN ' . $val['table'] . ' ON ' . $val['criterion']->generate();
        }

        foreach ($this->criteria->keys() as $key) {
            $criterion = $this->criteria->getCriterion($key);
            $whereClause[]  = $criterion->generate();
        }

        $orderByClause = $this->criteria->getOrderByFields();

        $qry = 'SELECT ' . ($enableCount ? 'SQL_CALC_FOUND_ROWS ' : '') .
        ($selectClause ? implode(', ', $selectClause) : '*') .
        (($table = $this->criteria->getTable()) ? ' FROM `' . $table . '`' : '') .
        ($joinClause ? implode($joinClause) : '') .
        ($whereClause ? ' WHERE ' . implode(' AND ', $whereClause) : '') .
        ($orderByClause ? ' ORDER BY ' . implode(', ', $orderByClause) : '') .
        (($limit = $this->criteria->getLimit()) ? ' LIMIT ' . (($offset = $this->criteria->getOffset()) ? $offset . ', ' : '') . $limit : '');

        return $qry;
    }
}

?>