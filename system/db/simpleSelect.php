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
        $whereClause = array();
        $orderByClause = array();

        foreach ($this->criteria->keys() as $key) {
            $criterion = $this->criteria->getCriterion($key);
            $whereClause[]  = $criterion->generate();
        }

        $orderByClause = $this->criteria->getOrderByFields();

        /*
        if (!empty($orderBy)) {
            foreach($orderBy as $val) {
                $orderByClause[] = $val;
            }
        }*/

        $qry = 'SELECT * FROM `' . $this->criteria->getTable() . '`' .
        ($whereClause ? ' WHERE ' . implode(' AND ', $whereClause) : '') .
        ($orderByClause ? ' ORDER BY ' . implode(', ', $orderByClause) : '') .
        (($limit = $this->criteria->getLimit()) ? ' LIMIT ' . (($offset = $this->criteria->getOffset()) ? $offset . ', ' : '') . $limit : '');



        return $qry;
    }
}

?>