<?php

class stubMapperDataModify extends simpleMapper
{
    protected $name = 'simple';


    protected function insertDataModify(&$fields)
    {
        $fields['bar'] = new sqlFunction('UNIX_TIMESTAMP');
    }

    protected function updateDataModify(&$fields)
    {
        $fields['bar'] = new sqlFunction('UNIX_TIMESTAMP');
    }
}

?>