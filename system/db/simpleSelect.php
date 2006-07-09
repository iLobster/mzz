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
        foreach ($this->criteria->keys() as $key) {
            $criterion = $this->criteria->getCriterion($key);
            $whereClause[]  = $criterion->generate();
        }
        return 'SELECT * FROM `' . $this->criteria->getTable() . '`' .
        ($whereClause ? ' WHERE ' . implode(' AND ', $whereClause) : '');
    }
}

?>