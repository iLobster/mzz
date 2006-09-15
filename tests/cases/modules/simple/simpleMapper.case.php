<?php

fileLoader::load('db/sqlFunction');
fileLoader::load('simple/simple.mapper');
fileLoader::load('simple');
fileLoader::load('cases/modules/simple/stubMapper.class');
fileLoader::load('cases/modules/simple/stubMapperDataModify.class');
fileLoader::load('cases/modules/simple/stubSimple.class');


class simpleMapperTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $map;

    private $map_rel;

    private $fixture;

    public function __construct()
    {
        $this->map = array(
        'id'  => array ('name' => 'id', 'accessor' => 'getId',  'mutator' => 'setId'),
        'foo' => array ('name' => 'foo','accessor' => 'getFoo', 'mutator' => 'setFoo'),
        'bar' => array ('name' => 'bar','accessor' => 'getBar', 'mutator' => 'setBar'),
        'rel' => array ('name' => 'rel','accessor' => 'getRel', 'mutator' => 'setRel', 'owns' => 'stub2Simple.somefield'),
        );

        $this->map_rel = array(
        'somefield' => array ('name' => 'somefield', 'accessor' => 'getSomefield',  'mutator' => 'setSomefield'),
        );

        $this->fixture = array(
        array('foo'=>'foo1', 'bar'=>'bar1', 'rel' => 2),
        array('foo'=>'foo2', 'bar'=>'bar2', 'rel' => 4),
        array('foo'=>'foo3', 'bar'=>'bar3', 'rel' => 6)
        );

        $this->db = DB::factory();
        $this->cleardb();
    }

    private function fixture()
    {
        $valString = '';
        foreach($this->fixture as $id => $data) {
            $valString .= "('" . $this->fixture[$id]['foo'] . "','" . $this->fixture[$id]['bar']. "', " . $this->fixture[$id]['rel'] . "),";
        }
        $valString = substr($valString, 0,  strlen($valString)-1);

        $stmt = $this->db->prepare('INSERT INTO `simple_stubsimple` (`foo`, `bar`, `rel`) VALUES ' . $valString);
        $stmt->execute();
    }

    public function setUp()
    {
        $this->mapper = new stubMapper('simple');
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `simple_stubsimple`');
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

        $this->mapper->setMap($this->map);
        $row = $this->mapper->searchByField('foo', $this->fixture[1]['foo']);

        $this->assertEqual($row[0]['stubSimple']['bar'], $this->fixture[1]['bar']);
    }

    public function testCreateUniqueObjectId()
    {
        $simple = new stubSimple($this->map);

        $this->assertEqual(0, $this->countRecord());

        $this->mapper->save($simple);

        $this->assertEqual(1, $this->countRecord());
        $this->assertEqual(1, $simple->getObjId());
    }

    public function testSearchByCriteria()
    {
        $this->db->query("INSERT INTO `simple_stubsimple` (`foo`, `bar`, `rel`) VALUES ('value', 'value_bar', 1)");

        $this->mapper->setMap($this->map);

        $criteria = new criteria();
        $criteria->add('foo', 'value');

        $expected = array(0 => array('stubSimple' => array('id' => '1', 'foo' => 'value', 'bar' => 'value_bar', 'rel' => '1'), 'stub2Simple' => array('somefield' => null, 'otherfield' => null)));

        $this->assertEqual($this->mapper->searchByCriteria($criteria), $expected);
    }

    public function testOneToOneRelation()
    {
        /*
        $this->fixture();
        $this->mapper->setMap($this->map);
        $row = $this->mapper->searchOneByField('foo', $this->fixture[1]['foo']);*/
        /*$row = $stmt->fetch();*/

/*        $this->assertEqual($row['simple_rel'], $this->fixture[1]['rel']);
        $this->assertEqual($row['stub2_somefield'], $this->fixture[1]['rel']);
        $this->assertEqual($row['stub2_otherfield'], $this->fixture[1]['rel'] + 1);*/
    }

    private function countRecord()
    {
        $stmt = $this->db->query("SELECT count(*) FROM `simple_stubsimple`");
        $count = $stmt->fetch(PDO::FETCH_NUM);
        return (int)$count[0];
    }

}


?>