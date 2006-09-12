<?php

class stub2SimpleMapper extends simpleMapper
{
    protected $className = 'stub2Simple';
    protected $name = 'stub2Simple';

    protected function getMap()
    {
        return array(
        'somefield' => array ('name' => 'somefield', 'accessor' => 'getSomefield',  'mutator' => 'setSomefield'),
        'otherfield' => array ('name' => 'otherfield', 'accessor' => 'getOtherfield',  'mutator' => 'setOtherfield'),
        );
    }

}

?>