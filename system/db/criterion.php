<?php

class criterion
{
    const C_OR = 'OR';
    const C_AND = 'AND';

    private $field;
    private $value;
    private $comparsion;
    private $db;
    private $clauses;
    private $conjunctions = array();

    public function __construct($field = null, $value = null, $comparsion = null)
    {
        $this->db = db::factory();
        $this->field = $field;
        $this->value = $value;
        $this->comparsion = !empty($comparsion) ? $comparsion : criteria::EQUAL;
    }

    public function generate()
    {
        $result = '';

        if (!is_null($this->field)) {
            // для конструкции `field` IN ('val1', 'val2')
            if ($this->comparsion === criteria::IN) {

                $result .= '`' . $this->field . '` ' . $this->comparsion . ' (';
                // тут наверное нужно проверять ещё и sizeof($this->value)
                foreach ($this->value as $val) {
                    $result .= $this->db->quote($val) . ', ';
                }
                $result = substr($result, 0, -2);
                $result .= ')';

            } elseif ($this->comparsion === criteria::BETWEEN) {
                $result .= '`' . $this->field . '` ' . $this->comparsion . ' ' . $this->db->quote($this->value[0]) . ' AND ' . $this->db->quote($this->value[1]);
            } else {
                $result .= '`' . $this->field . '` ' . $this->comparsion . ' ' . $this->db->quote($this->value);
            }
        }

        if (sizeof($this->conjunctions) > 0) {
            if (strlen($result)) {
                $result = '(' . $result . ')';
            }
            foreach ($this->conjunctions as $key => $val) {
                if ($val) {
                    $result .= ' ' . $val . ' ';
                }
                $result .= '(' . $this->clauses[$key]->generate() . ')';
            }
        }

        return $result;
    }

    public function addAnd($criterion)
    {
        $this->clauses[] = $criterion;
        $this->conjunctions[] = self::C_AND;
        return $this;
    }

    public function addOr($criterion)
    {
        $this->clauses[] = $criterion;
        $this->conjunctions[] = self::C_OR;
        return $this;
    }

    public function add($criterion)
    {
        $this->clauses[] = $criterion;
        $this->conjunctions[] = '';
        return $this;
    }

    public function getField()
    {
        return $this->field;
    }

    public function getValue()
    {
        return $this->value;
    }
}

?>