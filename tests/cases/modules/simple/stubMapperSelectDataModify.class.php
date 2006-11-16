<?php

class stubMapperSelectDataModify extends simpleMapper
{
    protected $name = 'simple';
    protected $className = 'stubSimple';

    protected function selectDataModify()
    {
        $modifyFields = array();

        $modifyFields['stubSimple' . self::TABLE_KEY_DELIMITER . 'foo'] = new sqlFunction('REVERSE', strtolower($this->className) . '.foo', true);

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