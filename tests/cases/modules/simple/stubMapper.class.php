<?php

fileLoader::load('simple/simpleCatalogueMapper');
fileLoader::load('cases/modules/simple/stubSimple.class');

class stubSimpleMapper extends simpleMapper
{
    protected $name = 'simple';
    protected $className = 'stubSimple';
    protected $map = array(
    'id'  => array ('name' => 'id', 'accessor' => 'getId',  'mutator' => 'setId', 'once' => 'true'),
    'foo' => array ('name' => 'foo','accessor' => 'getFoo', 'mutator' => 'setFoo'),
    'bar' => array ('name' => 'bar','accessor' => 'getBar', 'mutator' => 'setBar'),
    'obj_id' => array ('name' => 'obj_id','accessor' => 'getObjId', 'mutator' => 'setObjId'),
    );

    public function convertArgsToObj($args)
    {
    }
}

class stubCatalogueMapper extends simpleCatalogueMapper
{
    protected $name = 'simple';
    protected $className = 'catalogue';

    public function convertArgsToObj($args)
    {
    }
}

class catalogue extends simpleCatalogue
{

}

?>