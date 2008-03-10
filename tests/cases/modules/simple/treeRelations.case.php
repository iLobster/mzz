<?php

fileLoader::load('simple/simpleMapperForTree');
fileLoader::load('cases/modules/simple/stubMapper.class');
fileLoader::load('cases/modules/simple/stubSimple.class');

class testTreeRelations extends unitTestCase
{
    private $simple;
    private $map;
    private $mapper;
    private $mapper_tree;
    private $db;

    static public $map_tree = array(
    'id'  => array ('name' => 'id', 'accessor' => 'getId',  'mutator' => 'setId' ),
    'foo' => array ('name' => 'foo','accessor' => 'getFoo', 'mutator' => 'setFoo'),
    'bar' => array ('name' => 'bar','accessor' => 'getBar', 'mutator' => 'setBar'),
    'path' => array ('name' => 'path','accessor' => 'getPath', 'mutator' => 'setPath'),
    'obj_id' => array ('name' => 'obj_id','accessor' => 'getObjId', 'mutator' => 'setObjId'),
    'some_id' => array ('name' => 'some_id','accessor' => 'getSomeId', 'mutator' => 'setSomeId'), // поле, связывающее структуру и данные в дереве
    );

    public function __construct()
    {
        $this->map = array(
        'id'  => array ('name' => 'id', 'accessor' => 'getId',  'mutator' => 'setId', 'once' => 'true'),
        'foo' => array ('name' => 'foo','accessor' => 'getFoo', 'mutator' => 'setFoo'),
        'bar' => array ('name' => 'bar','accessor' => 'getBar', 'mutator' => 'setBar'),
        'tree_id' => array ('name' => 'tree_id','accessor' => 'getTree', 'mutator' => 'setTree', 'owns' => 'stubSimpleForTree2.id'),
        'obj_id' => array ('name' => 'obj_id','accessor' => 'getObjId', 'mutator' => 'setObjId'),
        );

        $this->db = DB::factory();
        $this->mapper = new stubMapper('simple');
        $this->mapper->setMap($this->map);

        $this->cleardb();

        $this->map_tree = self::$map_tree;

        $this->mapper_tree = new stubSimpleForTree2Mapper('simple');
        $this->mapper_tree->setMap($this->map_tree);

        $this->db->query("INSERT INTO `user_user` (login) VALUES('GUEST')");
        $this->db->query("INSERT IGNORE INTO `sys_classes`(id, name) VALUES(3, 'stubSimpleForTree')");
    }

    public function setUp()
    {
        $this->simple = new stubSimple($this->mapper, $this->map);
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
        $this->db->query('TRUNCATE TABLE `user_user`');
        $this->db->query('TRUNCATE TABLE `sys_classes`');

        $this->db->query('TRUNCATE TABLE `simple_stubSimple2_tree`');
        $this->db->query('TRUNCATE TABLE `simple_stubSimple2`');
    }

    private function fillDb()
    {
        $this->structure = array(
        1 => array(1, 16, 1),
        2 => array(2, 7, 2),
        3 => array(8, 13, 2),
        4 => array(14, 15, 2),
        5 => array(3, 4, 3),
        6 => array(5, 6, 3),
        7 => array(9, 10, 3),
        8 => array(11, 12, 3),
        );

        $qry = '';
        foreach ($this->structure as $id => $node) {
            $qry .= '(' . $id .', ' . $node[0] .', ' . $node[1] .', ' . $node[2] .', 1), ';
        }
        $qry = substr($qry, 0, -2);

        $this->db->query('INSERT INTO `simple_stubSimple2_tree` (`id`, `lkey`, `rkey`, `level`, `some_id`) VALUES ' . $qry);

        $this->data = array(
        1 => array('foo1', 'bar1', 'foo1'),
        2 => array('foo2', 'bar2', 'foo1/foo2'),
        3 => array('foo3', 'bar3', 'foo1/foo3'),
        4 => array('foo4', 'bar4', 'foo1/foo4'),
        5 => array('foo5', 'bar5', 'foo1/foo2/foo5'),
        6 => array('foo6', 'bar6', 'foo1/foo2/foo6'),
        7 => array('foo7', 'bar7', 'foo1/foo3/foo7'),
        8 => array('foo8', 'bar8', 'foo1/foo3/foo8'),
        );

        $data = '';
        foreach ($this->data as $key => $val) {
            $data .= "('" . $val[0] . "', '" . $val[1] . "', '" . $val[2] . "', " . $key . '), ';
        }
        $data = substr($data, 0, -2);

        $this->db->query('INSERT INTO `simple_stubSimple2` (`foo`, `bar`, `path`, `some_id`) VALUES ' . $data);

        $this->db->query('INSERT INTO `simple_stubSimple` (`foo`, `bar`, `path`, `tree_id`) VALUES ("f", "b", "p", 7)');
    }

    #        Вот на таком деревом и будем тестировать
    #
    #
    #                                   1
    #                                 1[1]16
    #                                   |
    #                            ----------------
    #                            |      |       |
    #                            2      3       4
    #                          2[2]7  8[2]13 14[2]15
    #                            |      |
    #                      -------      ---------
    #                      |     |      |       |
    #                      5     6      7       8
    #                    3[3]4 5[3]6  9[3]10 11[3]12
    #
    #
    private function assertEqualBranch($branch)
    {
        foreach ($branch as $key => $do) {
            $this->assertEqual($do->getFoo(), $this->data[$key][0]);
            $this->assertEqual($do->getBar(), $this->data[$key][1]);
            $this->assertEqual($do->getPath(false), $this->data[$key][2]);
            $this->assertEqual($do->getTreeLevel(), $this->structure[$key][2]);
        }
    }

    private function countRecord()
    {
        $stmt = $this->db->query("SELECT count(*) FROM `simple_stubSimple`");
        $count = $stmt->fetch(PDO::FETCH_NUM);
        return (int)$count[0];
    }

    public function testSelect()
    {
        $simple = $this->mapper->searchOneByField('foo', 'f');

        $this->assertEqual($simple->getBar(), 'b');
        $this->assertEqual($simple->getFoo(), 'f');
        $tree = $simple->getTree();
        $this->assertEqual($tree->getTreeKey(), 7);
        $this->assertEqual($tree->getTreeLevel(), 3);
    }

    public function testCreate()
    {
        $simple = new stubSimple($this->mapper, $this->map);
        $simple->setFoo($foo = 'foo');
        $simple->setBar($bar = 'bar');

        $tree = $this->mapper_tree->searchByKey(5);
        $this->assertEqual($tree->getTreeKey(), 5);
        $this->assertEqual($tree->getTreeLevel(), 3);

        $simple->setTree($tree);

        $this->assertEqual(1, $this->countRecord());

        $this->mapper->save($simple);

        $simple2 = $this->mapper->searchOneByField('foo', $foo);

        $this->assertEqual(2, $this->countRecord());
        $this->assertEqual($foo, $simple->getFoo());
        $this->assertEqual($bar, $simple->getBar());
    }
}

class stubSimpleForTree2Mapper extends simpleMapperForTree
{
    protected $name = 'simple';
    protected $className = 'stubSimpleForTree2';
    protected $itemName = 'stubSimpleForTree2';

    public function __construct($section)
    {
        parent::__construct($section);
        $this->table = 'simple_stubSimple2';
    }

    protected function getTreeParams()
    {
        return array('nameField' => 'foo', 'pathField' => 'path', 'joinField' => 'some_id', 'tableName' => 'simple_stubSimple2_tree', 'treeIdField' => 'some_id');
    }

    public function convertArgsToObj($args)
    {
    }

    public function getMap()
    {
        return testTreeRelations::$map_tree;
    }
}

class stubSimpleForTree2 extends simpleForTree
{
    public function getItems()
    {
        return array();
    }
}

?>