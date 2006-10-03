<?php

fileLoader::load('db/sqlFunction');
fileLoader::load('simple/simpleMapper');
fileLoader::load('simple');
fileLoader::load('cases/modules/simple/stubMapper.class');
fileLoader::load('cases/modules/simple/stubMapperDataModify.class');
fileLoader::load('cases/modules/simple/stubSimple.class');


class simpleMapperTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $map;
    private $fixture;

    public function __construct()
    {
        $this->map = array(
        'id'  => array ('name' => 'id', 'accessor' => 'getId',  'mutator' => 'setId' ),
        'foo' => array ('name' => 'foo','accessor' => 'getFoo', 'mutator' => 'setFoo'),
        'bar' => array ('name' => 'bar','accessor' => 'getBar', 'mutator' => 'setBar'),
        'obj_id' => array ('name' => 'obj_id','accessor' => 'getObjId', 'mutator' => 'setObjId'),
        );

        $this->fixture = array(array('foo'=>'foo1','bar'=>'bar1'),
        array('foo'=>'foo2','bar'=>'bar2'),
        array('foo'=>'foo3','bar'=>'bar3'));

        $this->db = DB::factory();
        $this->cleardb();
    }

    private function fixture()
    {
        $valString = '';
        foreach($this->fixture as $id => $data) {
            $valString .= "('" . $this->fixture[$id]['foo'] . "','" . $this->fixture[$id]['bar']. "'),";
        }
        $valString = substr($valString, 0,  strlen($valString)-1);

        $stmt = $this->db->prepare(' INSERT INTO `simple_simple` (`foo`,`bar`) VALUES ' . $valString);
        $stmt->execute();
    }

    public function setUp()
    {
        $this->mapper = new stubMapper('simple');
        $this->mapper->setMap($this->map);
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `simple_simple`');
        $this->db->query('TRUNCATE TABLE `sys_obj_id`');
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
        $simple = new stubSimple($this->map);
        $simple->setFoo($this->fixture[0]['foo']);
        $simple->setBar($this->fixture[0]['bar']);

        $this->assertEqual(0, $this->countRecord());

        $this->mapper->save($simple);

        $this->assertEqual(1, $this->countRecord());
        $this->assertEqual(1, $simple->getId());
        $this->assertEqual($this->fixture[0]['foo'], $simple->getFoo());
        $this->assertEqual($this->fixture[0]['bar'], $simple->getBar());
    }

    public function testInsertSaveWithDataModify()
    {
        $this->mapper = new stubMapperDataModify('simple');
        $this->mapper->setMap($this->map);

        $simple = new stubSimple($this->map);
        $simple->setFoo($this->fixture[0]['foo']);
        $this->mapper->save($simple);

        $this->assertEqual(1, $simple->getId());
        $this->assertEqual($this->fixture[0]['foo'], $simple->getFoo());
        $this->assertPattern('/^\d+$/', $simple->getBar());

    }

    public function testUpdateSaveWithDataModify()
    {
        $this->fixture();

        $this->mapper = new stubMapperDataModify('simple');
        $this->mapper->setMap($this->map);

        $simple = new stubSimple($this->map);
        $simple->import(array('id'=>1));
        $simple->setFoo($this->fixture[0]['foo']);
        $this->mapper->save($simple);

        $this->assertPattern('/^\d+$/', $simple->getBar());

    }

    public function testUpdateSave()
    {
        $this->fixture();

        $simple = new stubSimple($this->map);
        $simple->import(array('id'=>1));

        $simple->setFoo('newfoo1');

        $this->mapper->save($simple);

        $this->assertEqual('newfoo1', $simple->getFoo());
    }

    public function testSearchByField()
    {
        $this->fixture();
        $stmt = $this->mapper->searchByField('foo', $this->fixture[1]['foo']);
        $row = $stmt->fetch();

        $this->assertEqual($row['simple_bar'], $this->fixture[1]['bar']);

    }
/* да да , закоментировал тест
    public function testSearchAll()
    {
        $this->fixture();
        $stmt = $this->mapper->searchAll();
        $row = $stmt->fetchAll();

        $this->assertEqual(count($row), count($this->fixture));

    }
*/
    public function testCreateUniqueObjectId()
    {
        $simple = new stubSimple($this->map);

        $simple->setFoo('value');

        $this->assertEqual(0, $this->countRecord());

        $this->mapper->save($simple);

        $this->assertEqual(1, $this->countRecord());
        $this->assertEqual(1, $simple->getObjId());
    }


    private function countRecord()
    {
        $stmt = $this->db->query("SELECT count(*) FROM `simple_simple`");
        $count = $stmt->fetch(PDO::FETCH_NUM);
        return (int)$count[0];
    }
}


?>