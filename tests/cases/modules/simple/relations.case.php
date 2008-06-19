<?php

fileLoader::load('cases/modules/simple/stubMapper.class');

class testRelations extends unitTestCase
{
    private $map1;
    static public $map2 = array(
    'id'  => array ('name' => 'id', 'accessor' => 'getId',  'mutator' => 'setId', 'once' => 'true'),
    'foo' => array ('name' => 'foo','accessor' => 'getFoo', 'mutator' => 'setFoo'),
    'bar' => array ('name' => 'bar','accessor' => 'getBar', 'mutator' => 'setBar'),
    'obj_id' => array ('name' => 'obj_id','accessor' => 'getObjId', 'mutator' => 'setObjId'),
    );
    private $mapper;

    public function __construct()
    {
        $this->map1 = array(
        'id'  => array ('name' => 'id', 'accessor' => 'getId',  'mutator' => 'setId', 'once' => 'true'),
        'foo' => array ('name' => 'foo','accessor' => 'getFoo', 'mutator' => 'setFoo'),
        'bar' => array ('name' => 'bar','accessor' => 'getBar', 'mutator' => 'setBar', 'owns' => 'stubSimple2.bar', 'join_type' => 'left'),
        'obj_id' => array ('name' => 'obj_id','accessor' => 'getObjId', 'mutator' => 'setObjId'),
        );



        $this->db = DB::factory();
        $this->mapper = new stubSimpleMapper('simple');
        $this->mapper->setMap($this->map1);

        $this->cleardb();

        $this->db->query("INSERT INTO `user_user` (login) VALUES('GUEST')");
        //$this->db->query("INSERT IGNORE INTO `sys_classes`(id, name) VALUES(3, 'stubSimpleForTree')");
    }

    private function fillDb()
    {
        $this->db->query("INSERT INTO `simple_stubSimple` (`id`, `foo`, `bar`) VALUES (1, 'foo1', 'bar1'), (2, 'foo2', 'bar2'), (3, 'foo3', NULL)");
        $this->db->query("INSERT INTO `simple_stubSimple2` (`id`, `foo`, `bar`) VALUES (1, 's2_foo1', 'bar1'), (2, 's2_foo2', 'bar2')");
    }

    public function setUp()
    {
        $this->simple = new stubSimple($this->mapper, $this->map1);
        $this->db->query("INSERT INTO `user_user` (`login`) VALUES ('GUEST')");
        $this->db->query("INSERT INTO `sys_classes` (`name`, `module_id`) VALUES ('stubSimple', 1)");
        $this->fillDb();
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `simple_stubSimple`');
        $this->db->query('TRUNCATE TABLE `simple_stubSimple2`');

        $this->db->query('TRUNCATE TABLE `user_user`');
        $this->db->query('TRUNCATE TABLE `sys_classes`');
    }

    public function testGetWithNull()
    {
        $objects = $this->mapper->searchAll();
        $this->assertEqual(3, count($objects));

        $object = $this->mapper->searchByKey(3);
        $this->assertEqual($object->getFoo(), 'foo3');
        $this->assertNull($object->getBar());
    }

    public function testSaveWithNull()
    {
        $object = $this->mapper->searchByKey(1);
        $this->assertEqual($object->getBar()->getFoo(), 's2_foo1');

        $object->setBar(null);
        $this->mapper->save($object);

        $object_new = $this->mapper->searchByKey(1);
        $this->assertNull($object_new->getBar());
        $this->assertNull($object->getBar());
    }
}

class stubSimple2Mapper extends simpleMapper
{
    protected $name = 'simple';
    protected $className = 'stubSimple2';

    public function convertArgsToObj($args)
    {
    }

    public function getMap()
    {
        return testRelations::$map2;
    }
}

class stubSimple2 extends simple
{
}

?>