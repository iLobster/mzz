<?php

fileLoader::load('db/sqlFunction');
fileLoader::load('simple/simpleMapper');
fileLoader::load('simple');
fileLoader::load('cases/modules/simple/stubMapper.class');
fileLoader::load('cases/modules/simple/stubMapperDataModify.class');
fileLoader::load('cases/modules/simple/stubMapperSelectDataModify.class');
fileLoader::load('cases/modules/simple/stubMapperAddFields.class');

class simpleMapperTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $map;
    private $fixture;

    public function __construct()
    {
        $this->map = array(
        'id'  => array ('name' => 'id', 'accessor' => 'getId',  'mutator' => 'setId'),
        'foo' => array ('name' => 'foo','accessor' => 'getFoo', 'mutator' => 'setFoo'),
        'bar' => array ('name' => 'bar','accessor' => 'getBar', 'mutator' => 'setBar'),
        'obj_id' => array ('name' => 'obj_id','accessor' => 'getObjId', 'mutator' => 'setObjId'),
        );

        $this->fixture = array(1 => array('foo'=>'foo1','bar'=>'bar1'),
        2 => array('foo'=>'foo2','bar'=>'bar2'),
        3 => array('foo'=>'foo3','bar'=>'bar3'));

        $this->db = DB::factory();
        $this->cleardb();
    }

    private function fixture()
    {
        $valString = '';
        foreach ($this->fixture as $id => $data) {
            $valString .= "('" . $data['foo'] . "', '" . $data['bar']. "'),";
        }
        $valString = substr($valString, 0,  -1);

        $this->db->query('INSERT INTO `simple_stubSimple` (`foo`,`bar`) VALUES ' . $valString);
    }

    public function setUp()
    {
        $this->mapper = new stubSimpleMapper('simple');
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
        $this->db->query('TRUNCATE TABLE `simple_stubSimple`');
        $this->db->query('TRUNCATE TABLE `sys_obj_id`');
        $this->db->query('TRUNCATE TABLE `user_user`');
        $this->db->query('TRUNCATE TABLE `sys_classes`');
    }

    public function testSearchByKeys()
    {
        $this->fixture();
        $idsFixture = array(1,3);

        $result = $this->mapper->searchByKeys($idsFixture);
        $this->assertEqual(count($result),count($idsFixture));

        foreach ($idsFixture as $id) {
            $simple = $result[$id];

            $this->assertEqual($id, $simple->getId());
            $this->assertEqual($this->fixture[$id]['foo'], $simple->getFoo());
        }
    }

    public function testDelete()
    {
        $this->fixture();

        $this->assertEqual(3, $this->countRecord());

        $this->mapper->delete(1);

        $this->assertEqual(2, $this->countRecord());
    }

    public function testInsertSave()
    {
        $simple = new stubSimple($this->mapper, $this->map);
        $simple->setFoo($this->fixture[1]['foo']);
        $simple->setBar($this->fixture[1]['bar']);

        $this->assertEqual(0, $this->countRecord());

        $this->mapper->save($simple);

        $this->assertEqual(1, $this->countRecord());
        $this->assertEqual(1, $simple->getId());
        $this->assertEqual($this->fixture[1]['foo'], $simple->getFoo());
        $this->assertEqual($this->fixture[1]['bar'], $simple->getBar());
    }

    public function testInsertAndUpdateWithDataModify()
    {
        $this->mapper = new stubMapperDataModify('simple');
        $this->mapper->setMap($this->map);

        $simple = new stubSimple($this->mapper, $this->map);
        $simple->setBar($bar = 'bAr VaLUe');
        $simple->setFoo($foo = 'foO vAlUe');
        $this->mapper->save($simple);

        $this->assertEqual(1, $simple->getId());
        $this->assertEqual(strtolower($bar), $simple->getBar());
        $this->assertEqual(strtolower($foo), $simple->getFoo());

        $simple->setBar($bar = 'bAr VaLUe');
        $this->mapper->save($simple);
        $this->assertEqual(strtoupper($bar), $simple->getBar());
        $this->assertEqual(strtolower($foo), $simple->getFoo());
    }

    public function testInsertAndUpdateWithDataModifyOperator()
    {
        $this->mapper = new stubMapperDataModifyWithOperator('simple');
        $this->mapper->setMap($this->map);

        $simple = new stubSimple($this->mapper, $this->map);
        $simple->setBar($bar = 666);
        $this->mapper->save($simple);

        $this->assertEqual(1, $simple->getId());
        $this->assertEqual($bar * 10, $simple->getBar());

        $simple->setBar($bar = 666);
        $this->mapper->save($simple);
        $this->assertEqual($bar * 5, $simple->getBar());
    }

    public function testUpdateSave()
    {
        $this->fixture();

        $simple = new stubSimple($this->mapper, $this->map);
        $simple->import(array('id'=>1));

        $simple->setFoo('newfoo1');

        $this->mapper->save($simple);

        $this->assertEqual('newfoo1', $simple->getFoo());
    }

    public function testCreateUniqueObjectId()
    {
        $simple = new stubSimple($this->mapper, $this->map);

        $simple->setFoo('value');

        $this->assertEqual(0, $this->countRecord());

        $this->mapper->save($simple);

        $this->assertEqual(1, $this->countRecord());
        $this->assertEqual(1, $simple->getObjId());
    }

    public function testSelectWithDataModify()
    {
        $this->mapper = new stubMapperSelectDataModify('simple');
        $this->mapper->setMap($this->map);

        $simple = new stubSimple($this->mapper, $this->map);
        $simple->setFoo('12345');
        $this->mapper->save($simple);

        $this->assertEqual(1, $simple->getId());
        $this->assertEqual('12345', $simple->getFoo());
    }

    public function testSortingViaMap()
    {
        $map = $this->map;
        $map['id']['orderBy'] = '1';
        $map['id']['orderByDirection'] = 'DESC';

        $this->fixture();
        $this->mapper->setMap($map);
        $res = $this->mapper->searchAll();

        $i = count($res);
        foreach ($res as $key => $val) {
            $this->assertEqual($val->getId(), $i);
            $i--;
        }
    }

    public function testSortingViaCriteria()
    {
        $map = $this->map;
        $map['id']['orderBy'] = '1';
        $map['id']['orderByDirection'] = 'ASC';
        $criteria = new criteria();
        $criteria->setOrderByFieldDesc('bar');

        $this->fixture();
        $this->mapper->setMap($map);
        $res = $this->mapper->searchAll($criteria);

        $i = count($res);
        foreach ($res as $key => $val) {
            $this->assertEqual($val->getBar(), 'bar' . $i);
            $i--;
        }
    }

    public function testAddFields()
    {
        $this->fixture();

        $this->mapper = new stubMapperAddFields('simple');
        $this->mapper->setMap($this->map);

        $simple = $this->mapper->searchByKey(3);

        $this->assertEqual('3oof', $simple->getFoo());
    }

    public function testSetObjId()
    {
        $simple = new stubSimple($this->mapper, $this->map);
        $this->assertEqual(0, $simple->getObjId());
        $this->mapper->setObjId($simple, $obj_id = 10);
        $this->assertEqual($obj_id, $simple->getObjId());
    }

    private function countRecord()
    {
        $stmt = $this->db->query("SELECT count(*) FROM `simple_stubSimple`");
        $count = $stmt->fetch(PDO::FETCH_NUM);
        return (int)$count[0];
    }
}

?>