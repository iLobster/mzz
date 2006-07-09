<?php

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
        $whereClause = array();
        $orderByClause = array();

        foreach ($this->criteria->getSelectFields() as $select) {
            $isFunction = (bool)strpos($select, '(');

            $alias = $this->criteria->getSelectFieldAlias($select);
            $field = $isFunction ? $select : '`' . $select . '`';
            $field .= ($alias ? ' AS `' . $alias . '`' : '');
            $selectClause[] = $field;
        }

        $enableCount = $this->criteria->getEnableCount();

        foreach ($this->criteria->keys() as $key) {
            $criterion = $this->criteria->getCriterion($key);
            $whereClause[]  = $criterion->generate();
        }

        $orderByClause = $this->criteria->getOrderByFields();

        $qry = 'SELECT ' . ($enableCount ? 'SQL_CALC_FOUND_ROWS ' : '') .
        ($selectClause ? implode(', ', $selectClause) : '*') .
        (($table = $this->criteria->getTable()) ? ' FROM `' . $table . '`' : '').
        ($whereClause ? ' WHERE ' . implode(' AND ', $whereClause) : '') .
        ($orderByClause ? ' ORDER BY ' . implode(', ', $orderByClause) : '') .
        (($limit = $this->criteria->getLimit()) ? ' LIMIT ' . (($offset = $this->criteria->getOffset()) ? $offset . ', ' : '') . $limit : '');

        return $qry;
    }
}

?>