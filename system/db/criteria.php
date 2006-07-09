<?php
fileLoader::load('db/criterion');

class criteria
{
    const EQUAL = "=";
    const NOT_EQUAL = '<>';
    const GREATER = '>';
    const LESS = '<';
    const GREATER_EQUAL = '>=';
    const LESS_EQUAL = '<=';
    const IN = 'IN';
    const LIKE = 'LIKE';
    const BETWEEN = 'BETWEEN';

    private $table;
    private $map = array();
    private $orderBy = array();
    private $limit = 0;
    private $offset = 0;

    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function add($field, $value = null, $comparasion = null)
    {
        if ($field instanceof criterion) {
            if (!is_null($field->getField())) {
                $this->map[$field->getField()] = $field;
            } else {
                $this->map[] = $field;
            }
        } else {
            $this->map[$field] = new criterion($field, $value, $comparasion);
        }

        return $this;
    }

    public function keys()
    {
        return array_keys($this->map);
    }

    public function getCriterion($key)
    {
        if (isset($this->map[$key])) {
            return $this->map[$key];
        }
        return null;
    }

    public function setOrderByFieldAsc($field)
    {
        $this->orderBy[] = '`' . $field . '` ASC';
        return $this;
    }

    public function setOrderByFieldDesc($field)
    {
        $this->orderBy[] = '`' . $field . '` DESC';
        return $this;
    }

    public function getOrderByFields()
    {
        return $this->orderBy;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function setOffset($offset)
    {
        $this->offset = $offset;
        return $this;
    }
}



?>