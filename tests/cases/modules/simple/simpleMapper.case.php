<?php

fileLoader::load('simple/simple.mapper');
fileLoader::load('simple');
fileLoader::load('cases/modules/simple/stubMapper.class');
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
        );

        $this->fixture = array(array('foo'=>'foo1','bar'=>'bar1'),
                               array('foo'=>'foo2','bar'=>'bar2'),
                               array('foo'=>'foo3','bar'=>'bar3'));

        $this->db = DB::factory();
        $this->cleardb();
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
        $this->db->query('TRUNCATE TABLE `simple_simple`');
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

        $this->assertEqual($row['bar'], $this->fixture[1]['bar']);
           
    }


    private function countRecord()
    {
        $stmt = $this->db->query("SELECT count(*) FROM `simple_simple`");
        $count = $stmt->fetch(PDO::FETCH_NUM);
        return (int)$count[0];

    }

    private function fixture()
    {
        for($i = 0; $i < count($this->fixture); $i++) {
            $this->db->exec(' INSERT INTO `simple_simple` (`foo`,`bar`)'.
                            " VALUES('" . $this->fixture[$i]['foo'] . "',".
                                    "'" . $this->fixture[$i]['bar'] . "')");
        }
    }
}


?>