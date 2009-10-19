<?php

class softDeletePlugin extends observer
{
    protected $options = array(
        'field' => 'deleted');

    public function preSqlDelete(criteria $criteria)
    {
        $db = $this->mapper->db();

        $update = new simpleUpdate($criteria);
        $db->query($update->toString(array(
            $this->options['field'] => 1)));

        return true;
    }

    public function preSqlSelect(criteria $criteria)
    {
        $criteria->where($this->options['field'], 0);
    }
}

?>