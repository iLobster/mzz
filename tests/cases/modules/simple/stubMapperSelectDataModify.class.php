<?php

class stubMapperSelectDataModify extends simpleMapper
{
    protected $name = 'simple';
    protected $className = 'stubSimple';

    protected function selectDataModify(&$modifyFields)
    {
        $modifyFields['stubSimple' . self::TABLE_KEY_DELIMITER . 'foo'] = new sqlFunction('REVERSE', $this->className . '.foo', true);
    }

    protected function insertDataModify(&$fields)
    {
        $fields['foo'] = new sqlFunction('REVERSE', $fields['foo']);
    }

    public function convertArgsToObj($args)
    {
    }
}

?>