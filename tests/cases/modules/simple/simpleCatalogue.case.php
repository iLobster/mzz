<?php

//fileLoader::load('simple/simpleMapper');
fileLoader::load('cases/modules/simple/stubSimple.class');

class simpleCatalogueTest extends unitTestCase
{
    private $simple;
    private $db;

    public function __construct()
    {
        $this->map = array(
        'id'  => array ('name' => 'id', 'accessor' => 'getId',  'mutator' => 'setId', 'once' => 'true'),
        'obj_id' => array ('name' => 'obj_id','accessor' => 'getObjId', 'mutator' => 'setObjId'),
        'created' => array ('name' => 'created','accessor' => 'getCreated', 'mutator' => 'setCreated'),
        'editor' => array ('name' => 'editor','accessor' => 'getEditor', 'mutator' => 'setEditor'),
        'type_id' => array ('name' => 'type_id','accessor' => 'getType', 'mutator' => 'setType'),
        );

        $this->db = DB::factory();
        $this->mapper = new stubMapper('simple');
        $this->mapper->setMap($this->map);
        $this->cleardb();
    }

    public function setUp()
    {
        $this->simple = new stubSimpleCatalogue($this->map);
        $this->db->query("INSERT INTO `user_user` (`login`) VALUES ('GUEST')");
        $this->db->query("INSERT INTO `sys_classes` (`name`, `module_id`) VALUES ('stubSimpleCatalogue', 1)");
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `simple_catalogue`');
        $this->db->query('TRUNCATE TABLE `user_user`');
        $this->db->query('TRUNCATE TABLE `sys_classes`');
    }

    public function testAccessorsAndMutators()
    {
        $this->simple->setId($id = 1);
        $this->simple->import($this->simple->export());

        $props = array('Editor', 'Created');
        foreach ($props as $prop) {
            $getprop = 'get' . $prop;
            $setprop = 'set' . $prop;

            $this->assertNull($this->simple->$getprop());

            $val = 'foo';
            $this->simple->$setprop($val);


            $this->assertNull($this->simple->$getprop());

            $this->simple->import($this->simple->export());

            $this->assertEqual($val, $this->simple->$getprop());

            $val2 = 'bar';
            $this->simple->$setprop($val2);


            $this->assertEqual($val, $this->simple->$getprop());

            $this->simple->import($this->simple->export());

            $this->assertEqual($val2, $this->simple->$getprop());
        }
    }

    public function testGetAndSetProperties()
    {
        $properties = array(
            'p1' => array(
                'id'  =>  $id_1 = 'id_1',
                'name'  =>  $name_1 = 'name_1',
                'title'  =>  $title_1 = 'title_1',
                'type'  =>  $type_1 = 'char',
                'type_id'  =>  $type_id_1 = 1,
                'value'  =>  $value_1 = 'value1',
                'isShort'  =>  $isShort_1 = false
            ),
            'p2' => array(
                'id'  =>  $id_2 = 'id_2',
                'name'  =>  $name_2 = 'name_2',
                'title'  =>  $title_2 = 'title_2',
                'type'  =>  $type_2 = 'int',
                'type_id'  =>  $type_id_2 = 2,
                'value'  =>  $value_2 = '123456',
                'isShort'  =>  $isShort_2 = false
            ),
        );

        $this->simple->importProperties($properties);

        $this->assertEqual($this->simple->exportProperties(), array());

        $this->assertEqual($this->simple->getPropertyValue('p1'), $value_1);
        $this->assertEqual($this->simple->getPropertyTitle('p1'), $title_1);
        $this->assertEqual($this->simple->getPropertyType('p1'), $type_1);

        $p2 = $this->simple->getProperty('p2');
        $this->assertEqual($p2['value'], $value_2);
        $this->assertEqual($p2['title'], $title_2);
        $this->assertEqual($p2['type'], $type_2);

        $this->simple->setProperty('p3', 'value3');

        $this->assertNull($this->simple->getPropertyValue('p3'));

        $this->simple->importProperties($this->simple->exportProperties());

        $this->assertEqual($this->simple->getProperty('p3'), 'value3');
    }
}

?>