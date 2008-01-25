<?php

class stubMapperAddFields extends simpleMapper
{
    protected $name = 'simple';
    protected $className = 'stubSimple';

    protected function addFields(&$criteria)
    {
        $criteria->addSelectField(new sqlFunction('REVERSE', 'foo', true), $this->className . self::TABLE_KEY_DELIMITER . 'foo');
    }

    public function convertArgsToObj($args)
    {
    }
}

?>