<?php

class ormSimpleMapper extends mapper
{
    protected $table = 'ormSimple';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk')),
        'foo' => array(
            'accessor' => 'getFoo',
            'mutator' => 'setFoo'),
        'bar' => array(
            'accessor' => 'getBar',
            'mutator' => 'setBar'),
        'related' => array(
            'accessor' => 'getRelated',
            'mutator' => 'setRelated'));
}

class ormSimpleOtherMapper extends ormSimpleMapper
{
    protected $class = 'ormSimpleOther';
}

class ormSimple extends entity
{

}

class ormRelated extends entity
{

}

class ormSimpleOther extends entity
{

}

?>