<?php

fileLoader::load('user/group');
fileLoader::load('user/mappers/groupMapper');

//Mock::generate('groupMapper');

class groupzzzTest extends unitTestCase
{
    private $mapper;
    private $group;
    private $db;

    public function setUp()
    {
        $map = array(
        'id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId', 'once' => 'true' ),
        'obj_id' => array ('name' => 'obj_id', 'accessor' => 'getObjectId', 'mutator' => 'setObjectId', 'once' => 'true' ),
        'name' => array ( 'name' => 'name', 'accessor' => 'getName', 'mutator' => 'setName'),
        );

        //$this->mapper = new mockuserMapper('news');
        //$this->mapper = new userMapper('user');
        $this->group = new group($map);

        $this->db = DB::factory();
        $this->cleardb();
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `user_user_group`');
    }

    // получается совсем без тестов чтоли? ;)

}

?>