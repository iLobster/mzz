<?php

fileLoader::load('page');
fileLoader::load('page/mappers/pageMapper');

Mock::generate('pageMapper');

class pageTest extends unitTestCase
{
    private $page;

    public function setUp()
    {
        $map = array(
        'id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId', 'once' => 'true' ),
        'obj_id' => array ('name' => 'obj_id', 'accessor' => 'getObjectId', 'mutator' => 'setObjectId', 'once' => 'true' ),
        'name' => array ( 'name' => 'name', 'accessor' => 'getName', 'mutator' => 'setName'),
        'title' => array ( 'name' => 'title', 'accessor' => 'getTitle', 'mutator' => 'setTitle'),
        'content' => array ('name' => 'content', 'accessor' => 'getContent', 'mutator' => 'setContent')
        );

        $this->mapper = new pageMapper('page');
        $this->page = new page($map);
    }



}

?>