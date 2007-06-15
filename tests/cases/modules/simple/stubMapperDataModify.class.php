<?php

class stubMapperDataModify extends simpleMapper
{
    protected $name = 'simple';
    protected $className = 'stubSimple';

    protected function insertDataModify(&$fields)
    {
        $fields['bar'] = new sqlFunction('LOWER', $fields['bar']);
    }

    protected function updateDataModify(&$fields)
    {
        $fields['bar'] = new sqlFunction('UPPER', $fields['bar']);
    }

    public function convertArgsToId($args)
    {
    }
}

class stubMapperDataModifyWithOperator extends simpleMapper
{
    protected $name = 'simple';
    protected $className = 'stubSimple';

    protected function insertDataModify(&$fields)
    {
        $fields['bar'] = new sqlOperator('*', array((int)$fields['bar'], 10));
    }

    protected function updateDataModify(&$fields)
    {
        $fields['bar'] = new sqlOperator('*', array((int)$fields['bar'], 5));
    }

    public function convertArgsToId($args)
    {
    }
}

?>