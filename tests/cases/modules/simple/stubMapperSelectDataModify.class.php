<?php

class stubMapperSelectDataModify extends simpleMapper
{
    protected $name = 'simple';
    protected $className = 'stubSimple';

    protected function selectDataModify()
    {
        $modifyFields = array();

        // @todo Сделать, чтобы указывать
        // ГОТОВО
         $modifyFields['stubSimple_foo'] = new sqlFunction('REVERSE', 'foo', true);

        //$modifyFields['simple_foo'] = "REVERSE(`foo`)";
        return $modifyFields;
    }

    protected function insertDataModify(&$fields)
    {
        $fields['foo'] = new sqlFunction('REVERSE', $fields['foo']);

    }

    public function convertArgsToId($args)
    {
    }
}

?>