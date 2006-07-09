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

    public function setTable($table)
    {
        $this->table = $table;
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
}



?>