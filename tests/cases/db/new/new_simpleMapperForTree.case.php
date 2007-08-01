<?php

fileLoader::load('simple/new_simpleMapperForTree');

class new_simpleMapperForTreeTest extends unitTestCase
{
    private $db;
    private $mapper;
    private $structure;

    public function __construct()
    {
        $this->db = db::factory();
    }

    public function setUp()
    {
        $this->map = array(
        'id'  => array ('name' => 'id', 'accessor' => 'getId',  'mutator' => 'setId' ),
        'foo' => array ('name' => 'foo','accessor' => 'getFoo', 'mutator' => 'setFoo'),
        'bar' => array ('name' => 'bar','accessor' => 'getBar', 'mutator' => 'setBar'),
        'path' => array ('name' => 'path','accessor' => 'getPath', 'mutator' => 'setPath'),
        'obj_id' => array ('name' => 'obj_id','accessor' => 'getObjId', 'mutator' => 'setObjId'),
        'some_id' => array ('name' => 'some_id','accessor' => 'getSomeId', 'mutator' => 'setSomeId'), // поле, связывающее структуру и данные в дереве
        );

        $this->mapper = new new_StubSimpleMapperForTree('simple');
        $this->mapper->setMap($this->map);

        $this->clearDb();
        $this->fillDb();

        $this->db->query("INSERT INTO `user_user` (login) VALUES('GUEST')");
        $this->db->query("INSERT IGNORE INTO `sys_classes`(id, name) VALUES(3, 'new_stubSimpleForTree')");
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


    public function tearDown()
    {
        $this->clearDb();
    }

    private function clearDb()
    {
        $this->db->query('TRUNCATE TABLE `simple_stubSimple2_tree`');
        $this->db->query('TRUNCATE TABLE `simple_stubSimple2`');
        $this->db->query('TRUNCATE TABLE `user_user`');
        $this->db->query("DELETE FROM `sys_classes` WHERE `id` = 3");
    }

    private function assertEqualBranch($branch)
    {
        foreach ($branch as $key => $do) {
            $this->assertEqual($do->getFoo(), $this->data[$key][0]);
            $this->assertEqual($do->getBar(), $this->data[$key][1]);
            $this->assertEqual($do->getPath(false), $this->data[$key][2]);
            $this->assertEqual($do->getTreeLevel(), $this->structure[$key][2]);
        }
    }

    public function testGetTree()
    {
        $res = $this->mapper->searchAll();

        $this->assertEqual(array(1, 2, 5, 6, 3, 7, 8, 4), array_keys($res));
        $this->assertEqualBranch($res);
    }

    public function testSearchByCriteria()
    {
        $criteria = new criteria();
        $criteria->add('path', 'foo1/foo2%', criteria::LIKE);
        $res = $this->mapper->searchAllByCriteria($criteria);

        $this->assertEqual(3, sizeof($res));
        $this->assertEqual(array(2, 5, 6), array_keys($res));
        $this->assertEqualBranch($res);
    }

    public function testSearchByCriterions()
    {
        $criterion = new criterion('foo', 'foo1');
        $criterion->addOr(new criterion('foo', 'foo2'));
        $criterion->addOr(new criterion('foo', 'foo5'));

        $criteria = new criteria();
        $criteria->add($criterion);
        $res = $this->mapper->searchAllByCriteria($criteria);

        $this->assertEqual(3, sizeof($res));
        $this->assertEqual(array(1, 2, 5), array_keys($res));

        $this->assertEqualBranch($res);
    }

    public function testGetBranch()
    {
        $target = $this->mapper->searchByKey(2);
        $branch = $this->mapper->getBranch($target);

        $this->assertEqual(3, sizeof($branch));
        $this->assertEqual(array(2, 5, 6), array_keys($branch));

        $this->assertEqualBranch($branch);
    }

    public function testGetBranchWithLevel()
    {
        $target = $this->mapper->searchByKey(1);
        $branch = $this->mapper->getBranch($target, 1);

        $this->assertEqual(4, sizeof($branch));
        $this->assertEqual(array(1, 2, 3, 4), array_keys($branch));

        $this->assertEqualBranch($branch);
    }

    public function testGetParentBranch()
    {
        $target = $this->mapper->searchByKey(6);
        $branch = $this->mapper->getParentBranch($target);

        $this->assertEqual(3, sizeof($branch));
        $this->assertEqual(array(1, 2, 6), array_keys($branch));

        $this->assertEqualBranch($branch);
    }

    public function testGetParent()
    {
        $node = $this->mapper->searchByKey(5);
        $parent = $node->getTreeParent();

        $this->assertEqual($parent->getTreeKey(), 2);
    }

    public function testCreate()
    {
        $target = $this->mapper->searchByKey(4);

        $do = $this->mapper->create();
        $do->setFoo('newFoo');

        $this->mapper->save($do, $target);

        $this->assertEqual($do->getTreeKey(), 9);

        $branch = $this->mapper->getBranch($target);

        $this->assertTrue(isset($branch[9]));
        $this->assertEqual($do->getPath(false), 'foo1/foo4/newFoo');
    }

    public function testUpdate()
    {
        $node = $this->mapper->searchByKey(2);

        $node->setFoo('q');
        $this->mapper->save($node);

        $newNode = $this->mapper->searchByKey(5);
        $this->assertEqual($newNode->getPath(false), 'foo1/q/foo5');
    }

    public function testMove_Up()
    {
        $node = $this->mapper->searchByKey(2);
        $target = $this->mapper->searchByKey(4);
        $this->mapper->move($node, $target);

        $node = $this->mapper->searchByKey(2);
        $this->assertEqual($node->getTreeLevel(), 3);
        $this->assertEqual($node->getPath(false), 'foo1/foo4/foo2');

        $node = $this->mapper->searchByKey(5);
        $this->assertEqual($node->getTreeLevel(), 4);
        $this->assertEqual($node->getPath(false), 'foo1/foo4/foo2/foo5');
    }

    public function testMove_Down()
    {
        $node = $this->mapper->searchByKey(4);
        $target = $this->mapper->searchByKey(2);
        $this->mapper->move($node, $target);

        $node = $this->mapper->searchByKey(4);
        $this->assertEqual($node->getTreeLevel(), 3);
        $this->assertEqual($node->getPath(false), 'foo1/foo2/foo4');
    }

    public function testMoveNested()
    {
        $this->expectException(new mzzRuntimeException('Невозможно перенести узел во вложенную ветку'));

        $node = $this->mapper->searchByKey(2);
        $target = $this->mapper->searchByKey(5);
        $this->mapper->move($node, $target);
    }

    public function testDelete()
    {
        $node = $this->mapper->searchByKey(2);
        $this->mapper->delete($node);

        $res = $this->mapper->searchAll();

        $this->assertEqual(array(1, 3, 7, 8, 4), array_keys($res));
        $this->assertEqualBranch($res);
        $res = $this->db->getAll('SELECT COUNT(*) AS `cnt` FROM simple_stubSimple2');
        $this->assertEqual($res[0]['cnt'], 5);
    }

    public function appendMultiTree()
    {
        $this->structure2 = array(
        9 => array(1, 8, 1),
        10 => array(2, 3, 2),
        11 => array(4, 7, 2),
        12 => array(5, 6, 3),
        );

        $qry = '';
        foreach ($this->structure2 as $id => $node) {
            $qry .= '(' . $id .', ' . $node[0] .', ' . $node[1] .', ' . $node[2] .', 2), ';
        }
        $qry = substr($qry, 0, -2);

        $this->structure += $this->structure2;

        $this->db->query('INSERT INTO `simple_stubSimple2_tree` (`id`, `lkey`, `rkey`, `level`, `some_id`) VALUES ' . $qry);

        $this->data2 = array(
        9 => array('new_foo1', 'new_bar1', 'new_foo1'),
        10 => array('new_foo2', 'new_bar2', 'new_foo1/new_foo2'),
        11 => array('new_foo3', 'new_bar3', 'new_foo1/new_foo3'),
        12 => array('new_foo4', 'new_bar4', 'new_foo1/new_foo3/new_foo4'),
        );

        $data = '';
        foreach ($this->data2 as $key => $val) {
            $data .= "('" . $val[0] . "', '" . $val[1] . "', '" . $val[2] . "', " . $key . '), ';
        }
        $data = substr($data, 0, -2);

        $this->data += $this->data2;

        $this->db->query('INSERT INTO `simple_stubSimple2` (`foo`, `bar`, `path`, `some_id`) VALUES ' . $data);
    }

    public function testMultiGetTree()
    {
        $this->appendMultiTree();

        $this->mapper->setTree(1);
        $res = $this->mapper->searchAll();

        $this->assertEqual(array(1, 2, 5, 6, 3, 7, 8, 4), array_keys($res));
        $this->assertEqualBranch($res);

        $this->assertEqual($res[1]->getTreeId(), 1);

        $this->mapper->setTree(2);
        $res = $this->mapper->searchAll();

        $this->assertEqual(array(9, 10, 11, 12), array_keys($res));
        $this->assertEqualBranch($res);

        $this->assertEqual($res[9]->getTreeId(), 2);
    }

    public function testMultiSearchByCriteria()
    {
        $this->appendMultiTree();

        $this->mapper->setTree(2);

        $criteria = new criteria();
        $criteria->add('path', 'new_foo1/new_foo3%', criteria::LIKE);
        $res = $this->mapper->searchAllByCriteria($criteria);

        $this->assertEqual(2, sizeof($res));
        $this->assertEqual(array(11, 12), array_keys($res));
        $this->assertEqualBranch($res);

        $this->assertEqual($res[11]->getTreeId(), 2);
    }

    public function testMultiCreate()
    {
        $this->appendMultiTree();
        $this->mapper->setTree(2);

        $target = $this->mapper->searchByKey(12);

        $do = $this->mapper->create();
        $do->setFoo('newFoo');

        $this->mapper->save($do, $target);

        $this->assertEqual($do->getTreeKey(), 13);

        $branch = $this->mapper->getBranch($target);

        $this->assertTrue(isset($branch[13]));
        $this->assertEqual($do->getPath(false), 'new_foo1/new_foo3/new_foo4/newFoo');
    }

    public function testMultiUpdate()
    {
        $this->appendMultiTree();
        $this->mapper->setTree(2);

        $node = $this->mapper->searchByKey(11);

        $node->setFoo('q');
        $this->mapper->save($node);

        $newNode = $this->mapper->searchByKey(11);
        $this->assertEqual($newNode->getPath(false), 'new_foo1/q');

        $newNode = $this->mapper->searchByKey(12);
        $this->assertEqual($newNode->getPath(false), 'new_foo1/q/new_foo4');
    }
}

class new_StubSimpleMapperForTree extends new_simpleMapperForTree
{
    protected $name = 'simple';
    protected $className = 'new_stubSimpleForTree';
    protected $itemName = 'new_stubSimpleForTree';

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
}

class new_stubSimpleForTree extends new_simpleForTree
{
    public function getItems()
    {
        return array();
    }
}

class new_stubSimpleForTreeMapper extends simpleMapper
{
    public function convertArgsToObj($args)
    {
    }
}

?>