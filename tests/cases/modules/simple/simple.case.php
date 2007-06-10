<?php

fileLoader::load('simple/simpleMapper');
fileLoader::load('simple');
fileLoader::load('cases/modules/simple/stubMapper.class');
fileLoader::load('cases/modules/simple/stubSimple.class');

// simpleTest ���� �����
class testSimple extends unitTestCase
{
    private $simple;
    private $db;

    public function __construct()
    {
        $this->map = array(
        'id'  => array ('name' => 'id', 'accessor' => 'getId',  'mutator' => 'setId', 'once' => 'true'),
        'foo' => array ('name' => 'foo','accessor' => 'getFoo', 'mutator' => 'setFoo'),
        'bar' => array ('name' => 'bar','accessor' => 'getBar', 'mutator' => 'setBar'),
        'obj_id' => array ('name' => 'obj_id','accessor' => 'getObjId', 'mutator' => 'setObjId'),
        );

        $this->db = DB::factory();
        $this->mapper = new stubMapper('simple');
        $this->mapper->setMap($this->map);
        $this->cleardb();
    }

    public function setUp()
    {
        $this->simple = new stubSimple($this->mapper, $this->map);
        $this->db->query("INSERT INTO `user_user` (`login`) VALUES ('GUEST')");
        $this->db->query("INSERT INTO `sys_classes` (`name`, `module_id`) VALUES ('stubSimple', 1)");
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `simple_stubSimple`');
        $this->db->query('TRUNCATE TABLE `user_user`');
        $this->db->query('TRUNCATE TABLE `sys_classes`');
    }

    public function testAccessorsAndMutators()
    {
        $this->simple->setId($id = 1);
        $this->simple->import($this->simple->export());

        $props = array('Foo', 'Bar');
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

    public function testException()
    {
        try {
            $this->simple->getAny();
            $this->fail('������ ���� ������ EXCEPTION!');
        } catch (Exception $e) {
            $this->assertWantedPattern('/simple::getany/i', $e->getMessage());
        }

        try {
            $this->simple->setAny('any');
            $this->fail('������ ���� ������ EXCEPTION!');
        } catch (Exception $e) {
            $this->assertWantedPattern('/simple::setany/i', $e->getMessage());
        }
    }

    public function testGetIdNull()
    {
        $this->assertNull($this->simple->getId());
    }

    public function testSetIdWithoutValue()
    {
        try {
            $this->simple->setId();
            $this->fail('������ ���� ������ EXCEPTION!');
        } catch (Exception $e) {
            $this->assertWantedPattern('/simple::setid/i', $e->getMessage());
        }
    }

    public function testFieldsSetsOnce()
    {
        foreach(array('Id') as $val) {
            $setter = 'set' . $val;
            $getter = 'get' . $val;

            $first = '2';

            $this->simple->$setter($first);

            $this->mapper->save($this->simple);

            $this->assertIdentical($this->simple->$getter(), $first);

            $second = '5';
            $this->assertNotEqual($second, $first);

            $this->simple->$setter($second);

            $this->mapper->save($this->simple);

            $this->assertIdentical($this->simple->$getter(), $first);
        }
        // For import
        $this->simple->import(array('id' => $second));
        $this->mapper->save($this->simple);

        $this->assertIdentical($this->simple->$getter(), $first);
    }

    public function testFieldsSetsNotOnce()
    {
        foreach(array('Foo','Bar') as $val) {
            $setter = 'set' . $val;
            $getter = 'get' . $val;

            $first = '2';

            $this->simple->$setter($first);

            $this->mapper->save($this->simple);

            $this->assertIdentical($this->simple->$getter(), $first);

            $second = '5';
            $this->assertNotEqual($second, $first);

            $this->simple->$setter($second);

            $this->mapper->save($this->simple);

            $this->assertIdentical($this->simple->$getter(), $second);
        }
    }

    public function testFakeFields()
    {
        $this->simple->import(array('id' => $id = 666, 'fake' => $fake = 'fake_value'));
        $this->assertEqual($this->simple->getId(), $id);
        $this->assertEqual($this->simple->fakeField('fake'), $fake);
    }
}


?>