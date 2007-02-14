<?php

fileLoader::load('db/dbTreeNS');
fileLoader::load('db/sqlFunction');
fileLoader::load('db/simpleSelect');
fileLoader::load('cases/db/dbTreeNS/stubMapper.class');
fileLoader::load('cases/db/dbTreeNS/stubSimple.class');

class dbTreeDataTest extends unitTestCase
{
    private $db;
    private $mapper;
    private $tree;
    private $table;
    private $dataFixture;
    private $treeFixture;


    public function __construct()
    {

        $this->map = array(
        'id'  => array ('name' => 'id', 'accessor' => 'getId',  'mutator' => 'setId' ),
        'foo' => array ('name' => 'foo','accessor' => 'getFoo', 'mutator' => 'setFoo'),
        'bar' => array ('name' => 'bar','accessor' => 'getBar', 'mutator' => 'setBar'),
        'path' => array ('name' => 'path','accessor' => 'getPath', 'mutator' => 'setPath'),
        'obj_id' => array ('name' => 'obj_id','accessor' => 'getObjId', 'mutator' => 'setObjId'),
        );

        $this->mapper = new stubMapperForTree('simple');
        $this->mapper->setMap($this->map);
        $this->db = db::factory();

        $this->table = 'simple_stubSimple_tree';
        $this->dataTable = $this->mapper->getTable();

        $init = array ('mapper' => $this->mapper, 'joinField' => 'id', 'treeTable' => $this->table);



        $this->tree = new dbTreeNS($init, 'foo');

        $this->clearDb();

        // @toDo не нуно это ужо
        $this->fixtureType = 'dataFixture';

    }

    public function setUp()
    {
        $this->tree->setCorrectPathMode(false);
        $this->dataFixture = array();
        $this->treeFixture = array();
        $this->fixture();
        $this->db->query("INSERT INTO `user_user` (login) VALUES('GUEST')");
        $this->db->query("INSERT IGNORE INTO `sys_classes`(id, name) VALUES(3, 'stubSimpleForTree')");
    }
    public function tearDown()
    {
        $this->clearDb();
    }

    private function clearDb()
    {
        $this->db->query('TRUNCATE TABLE `simple_stubSimple_tree`');
        $this->db->query('TRUNCATE TABLE `simple_stubSimple`');
        $this->db->query('TRUNCATE TABLE `user_user`');
        $this->db->query("DELETE FROM `sys_classes` WHERE `id` = 3");

    }

    private function setFixture($idArray = null)
    {
        switch($this->fixtureType) {
            case 'treeFixture' : $fix =  $this->treeFixture; break;
            case 'dataFixture' : $fix =  $this->dataFixture; break;

        }
        if(!is_array($idArray)) {
            $idArray = range(1,8);
        }

        foreach($idArray as $id) {
            $fixture[$id] = $fix[$id];
        }

        return $fixture;
    }

    private function fixture()
    {
        # заполнение фикстуры дерева
        $this->treeFixture = array('1' => array('id'=>1, 'lkey'=>1 ,'rkey' =>16,'level'=>1),
        '2' => array('id'=>2, 'lkey'=>2 ,'rkey' =>7 ,'level'=>2),
        '3' => array('id'=>3, 'lkey'=>8 ,'rkey' =>13,'level'=>2),
        '4' => array('id'=>4, 'lkey'=>14,'rkey'=>15 ,'level'=>2),
        '5' => array('id'=>5, 'lkey'=>3 ,'rkey'=>4  ,'level'=>3),
        '6' => array('id'=>6, 'lkey'=>5 ,'rkey'=>6  ,'level'=>3),
        '7' => array('id'=>7, 'lkey'=>9 ,'rkey'=>10 ,'level'=>3),
        '8' => array('id'=>8, 'lkey'=>11,'rkey'=>12 ,'level'=>3)
        );

        $this->treePathFixture = array(1 => 'foo1', 2 => 'foo1/foo2',
        3 => 'foo1/foo3', 4 => 'foo1/foo4',
        5 => 'foo1/foo2/foo5', 6 => 'foo1/foo2/foo6',
        7 => 'foo1/foo3/foo7', 8 => 'foo1/foo3/foo8');

        $valString = '';
        foreach($this->treeFixture as $id => $data) {
            $valString .= "('" . $id . "','" . $data['lkey'] . "','" . $data['rkey'] . "','" . $data['level'] . "'),";
        }
        $values[$this->table] = substr($valString, 0, -1);

        #заполнение фикстуры таблицы данных
        $valString = '';
        foreach($this->treeFixture as $id => $row) {

            $this->dataFixture[$id] = array('id' => $id ,
            'foo' =>'foo' . $id ,
            'bar' => 'bar' . $id ,
            'path' => $this->treePathFixture[$id]
            );
            $valString .= "('" . $id . "','" . $this->dataFixture[$id]['foo'] . "','" . $this->dataFixture[$id]['bar'] . "','" . $this->dataFixture[$id]['path'] . "'),";
        }
        $values[$this->dataTable] = substr($valString, 0, -1);

        $simple_stubSimple_tree_fields = '(id, lkey, rkey, level)';
        $simple_stubSimple_fields = '(id, foo, bar, path)';

        #запись фикстур в базу
        foreach($values as $table => $val) {
            $fields = $table . '_fields';
            $query = 'INSERT INTO `' . $table . '` ' . $$fields  . ' VALUES ' . $val;
            $this->db->exec($query);
        }
    }

    private function assertEqualFixtureAndBranch($fixture, $branch)
    {
        foreach($branch as $id => $node) {
            $this->assertEqual($fixture[$id]['id'], $node->getId());
            $this->assertEqual($fixture[$id]['foo'], $node->getFoo());
            $this->assertEqual($fixture[$id]['bar'], $node->getBar());
            $this->assertEqual($fixture[$id]['path'], $node->getPath());
            $this->assertEqual($this->treeFixture[$id]['level'], $node->getLevel());
            $this->assertEqual($this->treeFixture[$id]['lkey'], $node->getLeftKey());
            $this->assertEqual($this->treeFixture[$id]['rkey'], $node->getRightKey());
        }
    }

    public function testSearchByCriteria()
    {
        $criteria = new criteria($this->dataTable);
        $criterion = new criterion('bar', 'bar5');
        $criterion->addOr(new criterion('bar', 'bar3'));
        $criteria->add($criterion);

        # ищем узлы по критерию
        $criteriaTreeNodes= $this->tree->SearchByCriteria($criteria);

        $fixtureDataTree = $this->setFixture(array(5, 3));

        $this->assertEqual(count($fixtureDataTree), count($criteriaTreeNodes));
        $this->assertEqualFixtureAndBranch($fixtureDataTree, $criteriaTreeNodes);
    }

    public function testGetTree()
    {
        # выбираем два уровня
        $tree = $this->tree->getTree($level = 2);

        $fixtureDataTree = $this->setFixture(array(1,2,3,4));
        $this->assertEqual(count($fixtureDataTree),count($tree));
        $this->assertEqualFixtureAndBranch($fixtureDataTree, $tree);
    }


    public function testGetBranch()
    {
        $branch = $this->tree->getBranch($id = 1, $level = 1);

        $fixtureBranch = $this->setFixture(array(1,2,3,4));
        $this->assertEqual(count($fixtureBranch),count($branch));
        $this->assertEqualFixtureAndBranch($fixtureBranch, $branch);
    }

    public function testGetParentBranch()
    {
        $branch = $this->tree->getParentBranch($id = 8, $level = 2);
        $fixtureBranch = $this->setFixture(array(8, 3, 1));
        $this->assertEqual(count($fixtureBranch),count($branch));
        $this->assertEqualFixtureAndBranch($fixtureBranch, $branch);
    }

    public function testGetBranchContainingNode()
    {
        $branch = $this->tree->getBranchContainingNode($id = 2);

        $fixtureBranch = $this->setFixture(array(1, 2, 5, 6));
        $this->assertEqual(count($fixtureBranch),count($branch));
        $this->assertEqualFixtureAndBranch($fixtureBranch, $branch);
    }

    public function testGetBranchContainingNodeLimited()
    {
        $branch = $this->tree->getBranchContainingNode($id = 2, 0);

        $fixtureBranch = $this->setFixture(array(1, 2));
        $this->assertEqual(count($fixtureBranch),count($branch));
        $this->assertEqualFixtureAndBranch($fixtureBranch, $branch);
    }

    public function testGetParentNode()
    {
        $parentNode = $this->tree->getParentNode($id = 6);
        $this->assertEqual($id = '2', $parentNode->getId());

        $this->assertEqual($this->dataFixture[$id]['id'], $parentNode->getId());
        $this->assertEqual($this->dataFixture[$id]['foo'], $parentNode->getFoo());
        $this->assertEqual($this->dataFixture[$id]['bar'], $parentNode->getBar());
        $this->assertEqual($this->treeFixture[$id]['level'], $parentNode->getLevel());
        $this->assertEqual($this->treeFixture[$id]['rkey'], $parentNode->getRightKey());
        $this->assertEqual($this->treeFixture[$id]['lkey'], $parentNode->getLeftKey());
    }

    public function testGetNoHaveParentNode()
    {
        $parentNode = $this->tree->getParentNode($id = 1);
        $this->assertNull($parentNode);
    }

    public function testGetOneLevelBranchByPath_WithPathCorrect()
    {
        $paths[] = '/foo1///foo3/';
        $paths[] = 'foo1//foo3/not_exist';
        $paths[] = '/foo1/foo3';
        $paths[] = 'foo1/not_exist/not_exist_too/foo3';

        $fixtureNodes = $this->setFixture(array(7,8));
        $this->tree->setCorrectPathMode(true);


        foreach($paths as $path) {
            $nodes = $this->tree->getBranchByPath($path);
            foreach($nodes as $id => $node) {
                $this->assertEqual($node->getId(), $fixtureNodes[$id]['id']);
                $this->assertEqual($node->getPath(), $fixtureNodes[$id]['path']);
            }
        }
    }

    public function testGetOneLevelBranchByPath()
    {
        $paths[] = '/foo1/foo3/';
        $paths[] = 'foo1/foo3';
        $paths[] = '//foo1////foo3////';

        $fixtureNodes = $this->setFixture(array(7,8));

        foreach($paths as $path) {
            $nodes = $this->tree->getBranchByPath($path);
            foreach($nodes as $id => $node) {
                $this->assertEqual($node->getId(), $fixtureNodes[$id]['id']);
                $this->assertEqual($node->getPath(), $fixtureNodes[$id]['path']);
            }
        }
    }


    public function testCreateNewPaths_AfterInsertNewNode()
    {
        //@toDo а почему регистрация автоматическая не работает при $this->mapper->save($newNode)?
        // __CLASS__ ?

        $fixture = array('bar' => 'newBar', 'foo' => 'newFoo');


        // вставляем новую запись в таблицу с данными
        $newNode = $this->mapper->create();
        $newNode->setBar($fixture['bar']);
        $newNode->setFoo($fixture['foo']);
        $this->mapper->save($newNode);

        // добавляем в структуру дерева новый узел
        $newNode = $this->tree->insertNode(3, $newNode);

        $pathFixture = 'foo1/foo3/newFoo';

        $this->assertEqual($pathFixture, $newNode->getPath());
        $this->assertEqual($fixture['bar'], $newNode->getBar());
        $this->assertEqual($fixture['foo'], $newNode->getFoo());
    }


    public function testCreateNewPaths_AfterInsertRootNode()
    {
        $fixture = array('foo' => 'rootFoo', 'bar' => 'rootBar');

        // вставляем новую запись в таблицу с данными
        $newRootNode = $this->mapper->create();
        $newRootNode->setBar($fixture['bar']);
        $newRootNode->setFoo($fixture['foo']);
        $this->mapper->save($newRootNode);



        // добавляем в структуру дерева корневой узел
        $newRootNode = $this->tree->insertRootNode($newRootNode);

        $newTree = $this->tree->getTree();
        $fixtureTree = $this->setFixture();

        $this->assertEqual(count($fixtureTree) + 1, ($newRootNode->getRightKey())/2);


        foreach($fixtureTree as $i => $node) {
            $fixtureTree[$i]['path'] = $fixture['foo'] . '/' . $fixtureTree[$i]['path'];
            $this->assertEqual($newTree[$i]->getPath(), $fixtureTree[$i]['path']);
            $this->assertEqual($newTree[$i]->getFoo(), $fixtureTree[$i]['foo']);
            $this->assertEqual($newTree[$i]->getBar(), $fixtureTree[$i]['bar']);
        }
    }


    public function testCreateNewPaths_AfterMoveNode()
    {
        $newTreePathFixture = array(1 => 'foo1', 2 => 'foo1/foo4/foo2',
        3 => 'foo1/foo3', 4 => 'foo1/foo4',
        5 => 'foo1/foo4/foo2/foo5', 6 => 'foo1/foo4/foo2/foo6',
        7 => 'foo1/foo3/foo7', 8 => 'foo1/foo3/foo8');

        $this->tree->moveNode(2,4);
        $newTree = $this->tree->getTree();

        foreach($newTreePathFixture as $i => $node) {
            $this->assertEqual($newTree[$i]->getPath(), $newTreePathFixture[$i]);
        }
    }


    public function testRemoveNodeAndRemoveRecordsInDataTable()
    {
        $fixtureTree = $this->setFixture(array(1, 3, 4, 7, 8));

        $deletedNodeId = 2;

        $this->tree->removeNode($deletedNodeId);
        $newTree = $this->tree->getTree();

        foreach($newTree as $i => $node) {
            $this->assertEqual($node->getFoo(), $fixtureTree[$i]['foo']);
        }

        $this->assertNull($this->tree->getBranch($deletedNodeId));
    }

    //-----------Обновленные тесты которые были в dbTreeNS.case.php-------------

    public function testGetMaxRightKey()
    {
        $this->assertEqual( $this->tree->getMaxRightKey(), 16);
    }

    public function testGetExistNodeInfoWithId()
    {
        $nodeInfo = $this->tree->getNodeInfo($id = 5);

        $this->assertEqual($nodeInfo['id'], $this->treeFixture[$id]['id']);
        $this->assertEqual($nodeInfo['rkey'], $this->treeFixture[$id]['rkey']);
        $this->assertEqual($nodeInfo['lkey'], $this->treeFixture[$id]['lkey']);
        $this->assertEqual($nodeInfo['level'], $this->treeFixture[$id]['level']);
    }

    public function testGetNotExistNodeInfo()
    {
        $node = $this->tree->getNodeInfo($id = 25);

        $this->assertNull($node);
    }

    public function testRemoveNode()
    {
        $this->tree->removeNode(2);

        $fixtureNewTree = array('1' => array('id'=>1, 'lkey'=>1 ,'rkey' =>10,'level'=>1),
        '3' => array('id'=>3, 'lkey'=>2 ,'rkey' =>7,'level'=>2),
        '4' => array('id'=>4, 'lkey'=>8,'rkey'=>9 ,'level'=>2),
        '7' => array('id'=>7, 'lkey'=>3 ,'rkey'=>4 ,'level'=>3),
        '8' => array('id'=>8, 'lkey'=>5,'rkey'=>6 ,'level'=>3)
        );
        $newTree = $this->tree->getTree();
        $this->assertEqual(count($fixtureNewTree), count($newTree));

        foreach ($newTree as $id => $node) {

            $this->assertEqual($node->getId(), $id);
            $this->assertEqual($node->getFoo(), 'foo' . $id);
            $this->assertEqual($node->getBar(), 'bar' . $id);

            $this->assertEqual($node->getLevel(), $fixtureNewTree[$id]['level']);
            $this->assertEqual($node->getRightKey(), $fixtureNewTree[$id]['rkey']);
            $this->assertEqual($node->getLeftKey(), $fixtureNewTree[$id]['lkey']);
        }
    }

    public function testInsertNode()
    {
        $fixture = array('id' => 9, 'bar' => 'newBar', 'foo' => 'newFoo', 'lkey' => 13, 'rkey' => 14 ,'level' => 3);


        $newNode = $this->mapper->create();
        $newNode->setFoo($fixture['foo']);
        $newNode->setBar($fixture['bar']);

        $newInsertedNode = $this->tree->insertNode(3, $newNode);


        $this->assertEqual($newInsertedNode->getId(), $fixture['id']);
        $this->assertEqual($newInsertedNode->getFoo(), $fixture['foo']);
        $this->assertEqual($newInsertedNode->getBar(), $fixture['bar']);
        $this->assertEqual($newInsertedNode->getLevel(), $fixture['level']);
        $this->assertEqual($newInsertedNode->getRightKey(), $fixture['rkey']);
        $this->assertEqual($newInsertedNode->getLeftKey(), $fixture['lkey']);


    }

    public function testInsertRootNode()
    {
        $fixture = array('id' => 9, 'bar' => 'newBar', 'foo' => 'newFoo', 'lkey' => 13, 'lkey'=>1,'rkey'=>18 ,'level'=>1);


        $newRootNode = $this->mapper->create();
        $newRootNode->setFoo($fixture['foo']);
        $newRootNode->setBar($fixture['bar']);
        $newInsertedRootNode = $this->tree->insertRootNode($newRootNode);

        $this->assertEqual($newInsertedRootNode->getId(), $fixture['id']);
        $this->assertEqual($newInsertedRootNode->getFoo(), $fixture['foo']);
        $this->assertEqual($newInsertedRootNode->getBar(), $fixture['bar']);
        $this->assertEqual($newInsertedRootNode->getLevel(), $fixture['level']);
        $this->assertEqual($newInsertedRootNode->getRightKey(), $fixture['rkey']);
        $this->assertEqual($newInsertedRootNode->getLeftKey(), $fixture['lkey']);
    }

    public function testRemoveRootNode()
    {
        $this->tree->removeNode(1);
        $newTree = $this->tree->getTree();

        $this->assertNull($newTree);
    }

    public function testMoveNode()
    {
        $this->tree->moveNode(3, 4);
        $fixtureNewTree = array('1' => array('id'=>1, 'lkey'=>1 ,'rkey' =>16,'level'=>1),
        '2' => array('id'=>2, 'lkey'=>2 ,'rkey' =>7 ,'level'=>2),
        '5' => array('id'=>5, 'lkey'=>3 ,'rkey'=>4  ,'level'=>3),
        '6' => array('id'=>6, 'lkey'=>5 ,'rkey'=>6  ,'level'=>3),
        '4' => array('id'=>4, 'lkey'=>8 ,'rkey'=>15 ,'level'=>2),
        '3' => array('id'=>3, 'lkey'=>9 ,'rkey' =>14,'level'=>3),
        '7' => array('id'=>7, 'lkey'=>10,'rkey'=>11 ,'level'=>4),
        '8' => array('id'=>8, 'lkey'=>12,'rkey'=>13 ,'level'=>4)
        );

        $newTree = $this->tree->getTree();
        $this->assertEqual(count($fixtureNewTree), count($newTree));

        foreach ($newTree as $id => $node) {

            $this->assertEqual('foo' . $id, $node->getFoo());
            $this->assertEqual('bar' . $id, $node->getBar());
            $this->assertEqual($fixtureNewTree[$id]['id'], $node->getId());
            $this->assertEqual($fixtureNewTree[$id]['rkey'], $node->getRightKey());
            $this->assertEqual($fixtureNewTree[$id]['lkey'], $node->getLeftKey());
            $this->assertEqual($fixtureNewTree[$id]['level'], $node->getLevel());
        }

    }

    public function testMoveNode2()
    {
        $this->tree->moveNode(4, 6);

        $fixtureNewTree = array('1' => array('id'=>1, 'lkey'=>1 ,'rkey' =>16,'level'=>1),
        '2' => array('id'=>2, 'lkey'=>2 ,'rkey' =>9 ,'level'=>2),
        '5' => array('id'=>5, 'lkey'=>3 ,'rkey'=>4  ,'level'=>3),
        '6' => array('id'=>6, 'lkey'=>5 ,'rkey'=>8  ,'level'=>3),
        '4' => array('id'=>4, 'lkey'=>6,'rkey'=>7 ,'level'=>4),

        '3' => array('id'=>3, 'lkey'=>10 ,'rkey' =>15,'level'=>2),
        '7' => array('id'=>7, 'lkey'=>11 ,'rkey'=>12 ,'level'=>3),
        '8' => array('id'=>8, 'lkey'=>13,'rkey'=>14 ,'level'=>3)
        );

        $newTree = $this->tree->getTree();

        $this->assertEqual(count($fixtureNewTree), count($newTree));

        foreach ($newTree as $id => $node) {

            $this->assertEqual('foo' . $id, $node->getFoo());
            $this->assertEqual('bar' . $id, $node->getBar());
            $this->assertEqual($fixtureNewTree[$id]['id'], $node->getId());
            $this->assertEqual($fixtureNewTree[$id]['rkey'], $node->getRightKey());
            $this->assertEqual($fixtureNewTree[$id]['lkey'], $node->getLeftKey());
            $this->assertEqual($fixtureNewTree[$id]['level'], $node->getLevel());
        }
    }

    public function testSwapNotExistNode()
    {
        $this->assertFalse($this->tree->swapNode(2, 20));
        $this->assertFalse($this->tree->swapNode(20, 2));
        $this->assertFalse($this->tree->swapNode(20, 21));
    }

    public function testSwapNode()
    {
        $this->assertFalse($this->tree->swapNode(8, 8));

        $this->tree->swapNode(2, 8);
        $fixtureNewTreeSlice = array('8' => array('id'=>8, 'lkey'=>2  ,'rkey' =>7 ,'level'=>2),
        '2' => array('id'=>2, 'lkey'=>11 ,'rkey' =>12,'level'=>3));


        foreach ($fixtureNewTreeSlice as $id => $node) {
            $this->assertEqual($this->tree->getNodeInfo($id), $node);
        }
    }

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
#
#  P.S.             id
#            lkey[level]rkey
#


?>