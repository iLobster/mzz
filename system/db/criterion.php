<?php

class criterion
{
    const C_OR = 'OR';
    const C_AND = 'AND';

    private $field;
    private $value;
    private $comparasion;
    private $db;
    private $clauses;
    private $conjunctions = array();

    public function __construct($field = null, $value = null, $comparasion = null)
    {
        $this->db = db::factory();
        $this->field = $field;
        $this->value = $value;
        $this->comparasion = !empty($comparasion) ? $comparasion : criteria::EQUAL;
    }

    public function generate()
    {
        $result = '';

        if (!is_null($this->field)) {
            // для конструкции `field` IN ('val1', 'val2')
            if ($this->comparasion === criteria::IN) {

                $result .= '`' . $this->field . '` ' . $this->comparasion . ' (';
                // тут наверное нужно проверять ещё и sizeof($this->value)
                foreach ($this->value as $val) {
                    $result .= $this->db->quote($val) . ', ';
                }
                $result = substr($result, 0, -2);
                $result .= ')';

            } elseif ($this->comparasion === criteria::BETWEEN) {
                $result .= '`' . $this->field . '` ' . $this->comparasion . ' ' . $this->db->quote($this->value[0]) . ' AND ' . $this->db->quote($this->value[1]);
            } else {
                $result .= '`' . $this->field . '` ' . $this->comparasion . ' ' . $this->db->quote($this->value);
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
}

?>