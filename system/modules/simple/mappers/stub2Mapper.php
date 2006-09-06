<?php
        
class stub2Mapper extends simpleMapper
{
    protected $className = 'simple';
    protected $name = 'simple';

    protected function getMap()
    {
        return array(
        'somefield' => array ('name' => 'somefield', 'accessor' => 'getSomefield',  'mutator' => 'setSomefield'),
        'otherfield' => array ('name' => 'otherfield', 'accessor' => 'getOtherfield',  'mutator' => 'setOtherfield'),
        );
    }

}

?>