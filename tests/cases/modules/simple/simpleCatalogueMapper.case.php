<?php

//fileLoader::load('db/sqlFunction');

class simpleCatalogueMapperTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $map;
    private $fixture;

    public function __construct()
    {
        $this->map = array(
        'id'  => array ('name' => 'id', 'accessor' => 'getId',  'mutator' => 'setId', 'once' => 'true'),
        'obj_id' => array ('name' => 'obj_id','accessor' => 'getObjId', 'mutator' => 'setObjId'),
        'created' => array ('name' => 'created','accessor' => 'getCreated', 'mutator' => 'setCreated'),
        'editor' => array ('name' => 'editor','accessor' => 'getEditor', 'mutator' => 'setEditor'),
        'type_id' => array ('name' => 'type_id','accessor' => 'getType', 'mutator' => 'setType'),
        );

        $this->fixture = array(
        1 => array('id' => 1, 'type_id' => 1, 'editor' => 1, 'created' => 666),
        2 => array('id' => 2, 'type_id' => 2, 'editor' => 2, 'created' => 999),
        );

        $this->db = DB::factory();
        $this->cleardb();
    }

    private function fixture()
    {
        $valString = '';
        foreach ($this->fixture as $id => $data) {
            $valString .= "('" . $data['id'] . "', '" . $data['type_id']. "', '" . $data['editor']. "', '" . $data['created']. "'),";
        }
        $valString = substr($valString, 0,  -1);

        $this->db->query('INSERT INTO `simple_catalogue` (`id`, `type_id`, `editor`, `created`) VALUES ' . $valString);
        $this->db->query("INSERT INTO `simple_catalogue_properties` (`id`, `name`, `title`) VALUES (1, 'property_1', 'title_1'), (2, 'property_2', 'title_2'), (3, 'property_3', 'title_3'), (4, 'property_4', 'title_4')");
        $this->db->query("INSERT INTO `simple_catalogue_types` (`id`, `name`, `title`) VALUES (1, 'type_1', 'type_title_1'), (2, 'type_2', 'type_title_2')");
        $this->db->query("INSERT INTO `simple_catalogue_types_props` (`id`, `type_id`, `property_id`) VALUES (1, 1, 1), (2, 1, 2), (3, 1, 3), (4, 2, 3), (5, 2, 4)");
    }

    public function setUp()
    {
        $this->fixture();
        $this->mapper = new stubCatalogueMapper('simple');
        $this->mapper->setMap($this->map);
        $this->db->query("INSERT INTO `user_user` (`login`) VALUES ('GUEST')");
        $this->db->query("INSERT INTO `sys_classes` (`name`, `module_id`) VALUES ('stubsimple', 1)");
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `simple_catalogue`');
        $this->db->query('TRUNCATE TABLE `simple_catalogue_properties`');
        $this->db->query('TRUNCATE TABLE `simple_catalogue_types`');
        $this->db->query('TRUNCATE TABLE `simple_catalogue_types_props`');
        $this->db->query('TRUNCATE TABLE `simple_catalogue_data`');

        $this->db->query('TRUNCATE TABLE `sys_obj_id`');
        $this->db->query('TRUNCATE TABLE `user_user`');
        $this->db->query('TRUNCATE TABLE `sys_classes`');
    }

    public function testGetWithNotSetted()
    {
        $catalogue = $this->mapper->searchOneByField('id', 2);
        $this->assertEqual($catalogue->getId(), 2);
        $this->assertNull($catalogue->getProperty('property_1'));
        $this->assertNull($catalogue->getProperty('any_property_name'));
    }

    public function testGet()
    {
        $this->db->query("INSERT INTO `simple_catalogue_data` (`id`, `property_type`, `value`) VALUES (1, 1, 'foobar'), (1, 2, 'baz'), (2, 5, 'mzz')");

        $catalogue = $this->mapper->searchOneByField('id', 1);
        $this->assertEqual($catalogue->getId(), 1);
        $this->assertEqual($catalogue->getProperty('property_1'), 'foobar');
        $this->assertEqual($catalogue->getProperty('property_2'), 'baz');

        $catalogue2 = $this->mapper->searchOneByField('id', 2);
        $this->assertEqual($catalogue2->getProperty('property_4'), 'mzz');
    }

    public function testGetFewObjects()
    {
        $this->db->query("INSERT INTO `simple_catalogue_data` (`id`, `property_type`, `value`) VALUES (1, 1, 'foobar'), (1, 2, 'baz'), (2, 5, 'mzz')");

        $objects = $this->mapper->searchAll();

        $this->assertEqual($objects[1]->getProperty('property_1'), 'foobar');
        $this->assertEqual($objects[2]->getProperty('property_4'), 'mzz');
    }

    public function testSearchByDynamicProperty()
    {
        $this->db->query("INSERT INTO `simple_catalogue_data` (`id`, `property_type`, `value`) VALUES (1, 1, 'foobar'), (1, 2, 'baz'), (2, 5, 'mzz')");
        $object = $this->mapper->searchAllByField('property_4', 'mzz');

        $this->assertEqual(sizeof($object), 1);
        $this->assertEqual($object[2]->getId(), 2);
        $this->assertEqual($object[2]->getProperty('property_4'), 'mzz');
    }
}

?>