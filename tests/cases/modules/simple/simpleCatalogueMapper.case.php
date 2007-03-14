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
        'name' => array ('name' => 'name','accessor' => 'getName', 'mutator' => 'setName'),
        );

        $this->fixture = array(
        1 => array('id' => 1, 'type_id' => 1, 'name' => 'name_1', 'editor' => 1, 'created' => 666),
        2 => array('id' => 2, 'type_id' => 2, 'name' => 'name_2','editor' => 2, 'created' => 999),
        );

        $this->db = DB::factory();
        $this->cleardb();
    }

    private function fixture()
    {
        $valString = '';
        foreach ($this->fixture as $id => $data) {
            $valString .= "('" . $data['id'] . "', '" . $data['type_id']. "', '" . $data['name']. "', '" . $data['editor']. "', '" . $data['created']. "'),";
        }
        $valString = substr($valString, 0,  -1);

        $this->db->query('INSERT INTO `simple_catalogue` (`id`, `type_id`, `name`, `editor`, `created`) VALUES ' . $valString);
        $this->db->query("INSERT INTO `simple_catalogue_properties` (`id`, `name`, `title`, `type_id`) VALUES (1, 'property_1', 'title_1', 1), (2, 'property_2', 'title_2', 1), (3, 'property_3', 'title_3', 1), (4, 'property_4', 'title_4', 2)");
        $this->db->query("INSERT INTO `simple_catalogue_properties_types` (`id`, `name`) VALUES (1, 'char'), (2, 'float')");
        $this->db->query("INSERT INTO `simple_catalogue_types` (`id`, `name`, `title`) VALUES (1, 'type_1', 'type_title_1'), (2, 'type_2', 'type_title_2')");
        $this->db->query("INSERT INTO `simple_catalogue_types_props` (`id`, `type_id`, `property_id`) VALUES (1, 1, 1), (2, 1, 2), (3, 1, 3), (4, 2, 3), (5, 2, 4)");
    }

    public function setUp()
    {
        $this->fixture();
        $this->mapper = new stubCatalogueMapper('simple');
        $this->mapper->setMap($this->map);
        $this->db->query("INSERT INTO `user_user` (`login`) VALUES ('GUEST')");
        $this->db->query("INSERT INTO `sys_classes` (`name`, `module_id`) VALUES ('stubsimple', 1), ('catalogue', 1)");
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `simple_catalogue`');
        $this->db->query('TRUNCATE TABLE `simple_catalogue_properties`');
        $this->db->query('TRUNCATE TABLE `simple_catalogue_properties_types`');
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
        $this->db->query("INSERT INTO `simple_catalogue_data` (`id`, `property_type`, `char`) VALUES (1, 1, 'foobar'), (1, 2, 'baz')");
        $this->db->query("INSERT INTO `simple_catalogue_data` (`id`, `property_type`, `float`) VALUES (2, 5, 666)");

        $catalogue = $this->mapper->searchOneByField('id', 1);

        $this->assertEqual($catalogue->getId(), 1);
        $this->assertEqual($catalogue->getName(), 'name_1');
        $this->assertEqual($catalogue->getType(), 1);
        $this->assertEqual($catalogue->getTypeTitle(), 'type_title_1');

        $this->assertEqual($catalogue->getProperty('property_1'), 'foobar');
        $this->assertEqual($catalogue->getProperty('property_2'), 'baz');

        $this->assertEqual($catalogue->getPropertyTitle('property_1'), 'title_1');
        $this->assertEqual($catalogue->getPropertyTitle('property_2'), 'title_2');

        $this->assertEqual($catalogue->getPropertyType('property_1'), 'char');
        $this->assertEqual($catalogue->getPropertyType('property_2'), 'char');

        $catalogue2 = $this->mapper->searchOneByField('id', 2);
        $this->assertEqual($catalogue2->getName(), 'name_2');
        $this->assertEqual($catalogue2->getProperty('property_4'), 666);
    }

    public function testGetFewObjects()
    {
        $this->db->query("INSERT INTO `simple_catalogue_data` (`id`, `property_type`, `char`) VALUES (1, 1, 'foobar'), (1, 2, 'baz')");
        $this->db->query("INSERT INTO `simple_catalogue_data` (`id`, `property_type`, `float`) VALUES (2, 5, 666)");

        $objects = $this->mapper->searchAll();

        $this->assertEqual($objects[1]->getProperty('property_1'), 'foobar');
        $this->assertEqual($objects[2]->getProperty('property_4'), 666);
    }

    public function testSearchByDynamicProperty()
    {
        $this->db->query("INSERT INTO `simple_catalogue_data` (`id`, `property_type`, `char`) VALUES (1, 1, 'foobar'), (1, 2, 'baz')");
        $this->db->query("INSERT INTO `simple_catalogue_data` (`id`, `property_type`, `float`) VALUES (2, 5, 666)");

        $object = $this->mapper->searchAllByField('property_4', 666);

        $this->assertEqual(sizeof($object), 1);
        $this->assertEqual($object[2]->getId(), 2);
        $this->assertEqual($object[2]->getProperty('property_4'), 666);
    }

    public function testSet()
    {
        $this->db->query("INSERT INTO `simple_catalogue_data` (`id`, `property_type`, `char`) VALUES (1, 1, 'foobar'), (1, 2, 'baz')");
        $this->db->query("INSERT INTO `simple_catalogue_data` (`id`, `property_type`, `float`) VALUES (2, 5, 666)");

        $catalogue = $this->mapper->searchOneByField('id', 2);

        $this->assertEqual($catalogue->getId(), 2);
        $this->assertEqual($catalogue->getProperty('property_4'), 666);

        $catalogue->setProperty('property_4', $new = 12345.6);
        $this->mapper->save($catalogue);

        $this->assertEqual($catalogue->getProperty('property_4'), $new);

        $catalogue->setProperty('not_exists_property', 'someval');
        $this->mapper->save($catalogue);

        $this->assertNull($catalogue->getProperty('not_exists_property'));
    }

    public function testCreate()
    {
        $catalogue = $this->mapper->create();

        $catalogue->setType($type = 2);
        $catalogue->setCreated($created = 777);
        $catalogue->setEditor($editor = 10);

        $catalogue->setProperty('property_3', $val1 = 'bar');
        $catalogue->setProperty('property_4', $val2 = 123);

        $this->mapper->save($catalogue);

        $this->assertEqual($catalogue->getType(), $type);
        $this->assertEqual($catalogue->getCreated(), $created);
        $this->assertEqual($catalogue->getEditor(), $editor);
        $this->assertEqual($catalogue->getProperty('property_3'), $val1);
        $this->assertEqual($catalogue->getProperty('property_4'), $val2);

        $res = $this->db->getOne("SELECT COUNT(*) FROM `simple_catalogue_data` WHERE `id` = 3 AND ((`property_type` = 4 AND `char` = 'bar') OR (`property_type` = 5 AND `float` = 123))");
        $this->assertEqual($res, 2);
    }

    public function testGetType()
    {
        $type = $this->mapper->getType($id = 1);

        $this->assertEqual($type['id'], $id);
        $this->assertEqual($type['name'], 'type_1');
        $this->assertEqual($type['title'], 'type_title_1');
    }

    public function testGetNonExistingClass()
    {
        $type = $this->mapper->getType($id = 999);
        $this->assertFalse($type);
    }

    public function testGetProperty()
    {
        $property = $this->mapper->getProperty($id = 1);

        $this->assertEqual($property['id'], $id);
        $this->assertEqual($property['name'], 'property_1');
        $this->assertEqual($property['title'], 'title_1');
        $this->assertEqual($property['type_id'], 1);
        $this->assertEqual($property['type'], 'char');
    }

    public function testGetPropertiesOfType()
    {
        $properties = $this->mapper->getProperties($type_id = 1);

        $this->assertEqual(count($properties), 3);
        $this->assertEqual($properties[0]['id'], 1);
        $this->assertEqual($properties[0]['name'], 'property_1');
        $this->assertEqual($properties[0]['title'], 'title_1');
        $this->assertEqual($properties[0]['type_id'], $type_id);
        $this->assertEqual($properties[0]['type'], 'char');
    }

    public function testAddAndUpdateType()
    {
        $id = $this->mapper->addType($name = 'testAddName', $title = 'testAddTitle', array());

        $type = $this->mapper->getType($id);

        $this->assertEqual($type['id'], $id);
        $this->assertEqual($type['name'], $name);
        $this->assertEqual($type['title'], $title);

        $this->mapper->updateType($id, $newname = 'testUpdateName', $newtitle = 'testUpdateTitle', array());

        $type = $this->mapper->getType($id);

        $this->assertEqual($type['id'], $id);
        $this->assertEqual($type['name'], $newname);
        $this->assertEqual($type['title'], $newtitle);
    }

    public function testDeleteType()
    {
        $type = $this->mapper->getType($id = 1);
        $this->assertTrue($type);

        $this->mapper->deleteType($id);
        $type = $this->mapper->getType($id);

        $this->assertFalse($type);
    }

    public function testAddAndUpdateProperty()
    {
        $id = $this->mapper->addProperty($name = 'testAddPropertyName', $title = 'testAddPropertyTitle', $type = 1);

        $property = $this->mapper->getProperty($id);

        $this->assertEqual($property['id'], $id);
        $this->assertEqual($property['name'], $name);
        $this->assertEqual($property['title'], $title);
        $this->assertEqual($property['type_id'], $type);

        $this->mapper->updateProperty($id, $newname = 'testUpdatePropertyName', $newtitle = 'testUpdatePropertyTitle', $newtype = 2);

        $property = $this->mapper->getProperty($id);

        $this->assertEqual($property['id'], $id);
        $this->assertEqual($property['name'], $newname);
        $this->assertEqual($property['title'], $newtitle);
        $this->assertEqual($property['type_id'], $newtype);
    }

    public function testDeleteProperty()
    {

        $property = $this->mapper->getProperty($id = 1);
        $this->assertTrue($property);

        $this->mapper->deleteProperty($id);
        $property = $this->mapper->getProperty($id);

        $this->assertFalse($property);
    }
}

?>