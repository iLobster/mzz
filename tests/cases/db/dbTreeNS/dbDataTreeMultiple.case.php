<?php

fileLoader::load('modules/simple/simpleMapper');
fileLoader::load('db/dbTreeNS');
fileLoader::load('db/sqlFunction');
fileLoader::load('db/simpleSelect');
fileLoader::load('cases/db/dbTreeNS/stubMapper2.class');
fileLoader::load('cases/db/dbTreeNS/stubSimple.class');

class dbTreeDataMultipleTest extends unitTestCase
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
        'some_id' => array ('name' => 'some_id','accessor' => 'getSomeId', 'mutator' => 'setSomeId'),
        'obj_id' => array ('name' => 'obj_id','accessor' => 'getObjId', 'mutator' => 'setObjId'),
        );

        $this->mapper = new stubMapperForMultipleTree('simple');
        $this->mapper->setMap($this->map);
        $this->db = db::factory();

        $this->table = 'simple_stubsimple2_tree';
        $this->dataTable = $this->mapper->getTable();

        $init = array ('mapper' => $this->mapper,
        'joinField' => 'id', // поле в таблице данных по которому идет связка с деревом
        'treeTable' => $this->table,  // таблица со структурой дерева
        'treeField' => 'some_id' // поле в таблице данных и структуры, по которому выделяются деревья
        );


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
        $this->db->query('TRUNCATE TABLE `simple_stubsimple2_tree`');
        $this->db->query('TRUNCATE TABLE `simple_stubsimple2`');
        $this->db->query('TRUNCATE TABLE `user_user`');
        $this->db->query("DELETE FROM `sys_classes` WHERE `id` = 3");

    }

    private function setFixture($some_id, $idArray)
    {
        foreach($idArray as $id) {
            $fixture[$id] = $this->dataFixture[$some_id][$id];
        }
        return $fixture;
    }

    private function assertEqualFixtureAndBranch($some_id, $fixture, $branch)
    {
        //echo "<pre>some_id = $some_id;fixtureKeys= "; var_dump(array_keys($fixture)); echo "</pre>";
        //echo "<pre>branchKeys "; var_dump(array_keys($branch)); echo "</pre>";

        $this->assertEqual(count($fixture), count($branch));

        foreach($branch as $id => $node) {

            //echo "<pre>idNode-"; var_dump($id); echo "</pre>";
            //echo "<pre>some_id-"; var_dump($some_id); echo "</pre>";
            //echo "<pre>fixture[id] = "; var_dump($fixture[$id]); echo "</pre>";

            $this->assertEqual($fixture[$id]['id'], $node->getId());
            $this->assertEqual($fixture[$id]['foo'], $node->getFoo());
            $this->assertEqual($fixture[$id]['bar'], $node->getBar());
            $this->assertEqual($fixture[$id]['path'], $node->getPath());
            $this->assertEqual($this->treeFixture[$some_id][$id]['level'], $node->getLevel());
            $this->assertEqual($this->treeFixture[$some_id][$id]['lkey'], $node->getLeftKey());
            $this->assertEqual($this->treeFixture[$some_id][$id]['rkey'], $node->getRightKey());
        }
    }

    private function assertEqualFixtureAndNode($some_id, $fixtureNodeID, $node)
    {

        $this->assertEqual($this->dataFixture[$some_id][$fixtureNodeID]['foo'], $node->getFoo());
        $this->assertEqual($this->dataFixture[$some_id][$fixtureNodeID]['bar'], $node->getBar());
        $this->assertEqual($this->dataFixture[$some_id][$fixtureNodeID]['path'], $node->getPath());
        $this->assertEqual($this->treeFixture[$some_id][$fixtureNodeID]['id'], $node->getId());
        $this->assertEqual($this->treeFixture[$some_id][$fixtureNodeID]['level'], $node->getLevel());
        $this->assertEqual($this->treeFixture[$some_id][$fixtureNodeID]['lkey'], $node->getLeftKey());
        $this->assertEqual($this->treeFixture[$some_id][$fixtureNodeID]['rkey'], $node->getRightKey());

    }

    public function testGetTree()
    {
        foreach($this->dataFixture as $some_id => $fixture) {
            $this->tree->setTree($some_id);
            $tree = $this->tree->getTree();
            $this->assertEqual(count($fixture),count($tree));
            $this->assertEqualFixtureAndBranch($some_id, $fixture, $tree);
        }
    }

    public function testGetBranch()
    {
        $fixtureNodes[1] = array(1, 2, 3, 4);
        $fixtureNodes[2] = array(9, 10, 11, 12);

        foreach($this->dataFixture as $some_id => $fixture) {
            $this->tree->setTree($some_id);
            $branch = $this->tree->getBranch($fixtureNodes[$some_id][0], $level = 1);

            $fixtureBranch = $this->setFixture($some_id, $fixtureNodes[$some_id]);
            $this->assertEqual(count($fixtureBranch),count($branch));
            $this->assertEqualFixtureAndBranch($some_id, $fixtureBranch, $branch);

        }
    }

    public function testGetParentBranch()
    {
        $fixtureNodes[1] = array(4, 1);
        $fixtureNodes[2] = array(14, 11, 9);

        foreach($this->dataFixture as $some_id => $fixture) {
            $this->tree->setTree($some_id);
            $branch = $this->tree->getParentBranch($fixtureNodes[$some_id][0], $level = 2);

            $fixtureBranch = $this->setFixture($some_id, $fixtureNodes[$some_id]);
            $this->assertEqual(count($fixtureBranch),count($branch));
            $this->assertEqualFixtureAndBranch($some_id, $fixtureBranch, $branch);

        }
    }

    public function testGetBranchContainingNode()
    {
        $fixtureNodes[1] = array(7, 3, 1 );
        $fixtureNodes[2] = array(14, 11, 9);


        foreach($this->dataFixture as $some_id => $fixture) {
            $this->tree->setTree($some_id);
            $branch = $this->tree->getBranchContainingNode($fixtureNodes[$some_id][0]);

            $fixtureBranch = $this->setFixture($some_id, $fixtureNodes[$some_id]);
            $this->assertEqual(count($fixtureBranch),count($branch));
            $this->assertEqualFixtureAndBranch($some_id, $fixtureBranch, $branch);

        }
    }

    public function testGetOneLevelBranchByPath()
    {
        $paths[1] = array('/foo1/', 'foo1//');
        $paths[2] = array('/foo9/foo11/', 'foo9/foo11//', '//foo9////foo11////');

        $fixtureNodes[1] = array(2, 3, 4);
        $fixtureNodes[2] = array(13, 14);

        foreach($this->dataFixture as $some_id => $fixture) {

            $this->tree->setTree($some_id);

            foreach($paths[$some_id] as $path) {
                $branch = $this->tree->getBranchByPath($path, 1);

                $fixtureBranch = $this->setFixture($some_id, $fixtureNodes[$some_id]);

                $this->assertEqual(count($fixtureBranch), count($branch));
                $this->assertEqualFixtureAndBranch($some_id, $fixtureBranch, $branch);

            }
        }
    }

    public function testGetParentNode()
    {
        $childNodeID = array(1 => 6, 2 => 14);

        $fixtureNodesID = array(1 => 2, 2 => 11);

        foreach($this->dataFixture as $some_id => $fixture) {
            $this->tree->setTree($some_id);
            $parentNode = $this->tree->getParentNode($childNodeID[$some_id]);

            $this->assertEqual($fixtureNodesID[$some_id], $parentNode->getId());
            $this->assertEqualFixtureAndNode($some_id, $fixtureNodesID[$some_id], $parentNode);

        }
    }


    public function testSearchByCriteria()
    {
        $criteriaFixture[1] = array('bar3', 'bar8');
        $criteriaFixture[2] = array('bar14', 'bar10');

        $fixtureNodes[1] = array(8, 3);
        $fixtureNodes[2] = array(10, 14);

        foreach($this->dataFixture as $some_id => $fixture) {
            $this->tree->setTree($some_id);

            $criteria = new criteria($this->dataTable);
            $criterion = new criterion('bar', $criteriaFixture[$some_id][0]);
            $criterion->addOr(new criterion('bar', $criteriaFixture[$some_id][1]));
            $criteria->add($criterion);

            // ищем узлы по критерию
            $criteriaTreeNodes = $this->tree->SearchByCriteria($criteria);

            $fixtureTree = $this->setFixture($some_id, $fixtureNodes[$some_id]);
            $this->assertEqual(count($fixtureNodes[$some_id]), count($criteriaTreeNodes));
            $this->assertEqualFixtureAndBranch($some_id, $fixtureTree, $criteriaTreeNodes);
        }
    }

    public function testGetNoHaveParentNode()
    {
        $fixtureNodesID = array(1=>9, 2=>3);

        foreach($fixtureNodesID as $some_id => $nodeID){
            $this->tree->setTree($some_id);
            $parentNode = $this->tree->getParentNode($nodeID);
            $this->assertNull($parentNode);
        }
    }

    public function testCreateNewPaths_AfterInsertNewNode()
    {
        $fixture[1] = array('bar' => 'newBar1', 'foo' => 'newFoo1');
        $fixture[2] = array('bar' => 'newBar2', 'foo' => 'newFoo2');

        $parentNodeFixture = array(1 => 4, 2 => 14);

        $pathFixture = array(1 => 'foo1/foo4/newFoo1', 2 => 'foo9/foo11/foo14/newFoo2');


        foreach(range(1,2)  as $some_id){
            $this->tree->setTree($some_id);

            $newNode = $this->mapper->create();
            $newNode->setBar($fixture[$some_id]['bar']);
            $newNode->setFoo($fixture[$some_id]['foo']);
            $newNode->setSomeId($some_id);
            $this->mapper->save($newNode);

            //echo "<pre>parentNodeFixture[$some_id] "; var_dump($parentNodeFixture[$some_id]); echo "</pre>";

            $newNode = $this->tree->insertNode($parentNodeFixture[$some_id], $newNode);


            $this->assertEqual($pathFixture[$some_id], $newNode->getPath());
            $this->assertEqual($fixture[$some_id]['bar'], $newNode->getBar());
            $this->assertEqual($fixture[$some_id]['foo'], $newNode->getFoo());
            $this->assertEqual($some_id, $newNode->getSomeId());
        }
    }


    public function testRemoveNodeAndRemoveRecordsInDataTable()
    {

        $fixtureTree[1] = $this->setFixture(1, array(1, 2, 5, 6, 4));
        $fixtureTree[2] = $this->setFixture(2, array(9, 10, 11, 12, 14));

        $deletedNodeId = array(1 => 3, 2 => 13);

        foreach($fixtureTree as $some_id => $fixture) {
             $this->tree->setTree($some_id);
             $this->tree->removeNode($deletedNodeId[$some_id]);
             $newTree = $this->tree->getTree();

             foreach($newTree as $id => $node) {
                 $this->assertEqual($this->dataFixture[$some_id][$id]['foo'],  $node->getFoo());
                 $this->assertEqual($this->dataFixture[$some_id][$id]['bar'],  $node->getBar());

             }
        }
    }

    /*
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
    $this->mapper->save($newNode);

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
    $this->mapper->save($newRootNode);

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
    */

    private function fixture()
    {
        // заполнение фикстуры дерева
        $this->treeFixture[1] = array(
        '1' => array('id'=>1, 'lkey'=>1 ,'rkey' =>16,'level'=>1),
        '2' => array('id'=>2, 'lkey'=>2 ,'rkey' =>7 ,'level'=>2),
        '3' => array('id'=>3, 'lkey'=>8 ,'rkey' =>13,'level'=>2),
        '4' => array('id'=>4, 'lkey'=>14,'rkey'=>15 ,'level'=>2),
        '5' => array('id'=>5, 'lkey'=>3 ,'rkey'=>4  ,'level'=>3),
        '6' => array('id'=>6, 'lkey'=>5 ,'rkey'=>6  ,'level'=>3),
        '7' => array('id'=>7, 'lkey'=>9 ,'rkey'=>10 ,'level'=>3),
        '8' => array('id'=>8, 'lkey'=>11,'rkey'=>12 ,'level'=>3)
        );

        $this->treeFixture[2] = array(
        '9' => array('id'=>9, 'lkey'=>1 ,'rkey' =>18,'level'=>1),
        '10' => array('id'=>10, 'lkey'=>2 ,'rkey' =>3,'level'=>2),
        '11' => array('id'=>11, 'lkey'=>4 ,'rkey' =>15,'level'=>2),
        '12' => array('id'=>12, 'lkey'=>16 ,'rkey' =>17,'level'=>2),
        '13' => array('id'=>13, 'lkey'=>5 ,'rkey' =>12,'level'=>3),
        '14' => array('id'=>14, 'lkey'=>13 ,'rkey' =>14,'level'=>3),
        '15' => array('id'=>15, 'lkey'=>6 ,'rkey' =>7,'level'=>4),
        '16' => array('id'=>16, 'lkey'=>8 ,'rkey' =>9,'level'=>4),
        '17' => array('id'=>17, 'lkey'=>10 ,'rkey' =>11,'level'=>4),
        );

        // фикстуры путей
        $this->treePathFixture[1] = array(
        1 => 'foo1', 2 => 'foo1/foo2',
        3 => 'foo1/foo3', 4 => 'foo1/foo4',
        5 => 'foo1/foo2/foo5', 6 => 'foo1/foo2/foo6',
        7 => 'foo1/foo3/foo7', 8 => 'foo1/foo3/foo8');

        $this->treePathFixture[2] = array(
        9 => 'foo9', 10 => 'foo9/foo10',
        11 => 'foo9/foo11', 12 => 'foo9/foo12',
        13 => 'foo9/foo11/foo13', 14 => 'foo9/foo11/foo14',
        15 => 'foo9/foo11/foo13/foo15', 16 => 'foo9/foo11/foo13/foo16',
        17 => 'foo9/foo11/foo13/foo17');


        // заполнение фикстуры таблицы со структурой(деревом)
        $valString = '';
        foreach($this->treeFixture as $some_id => $treeFixture) {
            foreach($treeFixture as $id => $data) {
                $valString .= "('" . $id . "','" . $data['lkey'] . "','" . $data['rkey'] . "','" . $data['level'] . "','" . $some_id . "'),";
            }
        }


        $stmt = $this->db->prepare(' INSERT INTO `simple_stubsimple2_tree` (id, lkey, rkey, level, some_id) VALUES ' . substr($valString, 0, -1));
        $stmt->execute();

        // заполнение фикстуры таблицы с данными
        $valString = '';
        foreach($this->treeFixture as $some_id => $treeFixture) {
            $this->dataFixture[$some_id] = array();

            foreach($treeFixture as $id => $data) {
                $fixture = array(
                'id' => $id ,
                'foo' =>'foo' . $id ,
                'bar' => 'bar' . $id ,
                'path' => $this->treePathFixture[$some_id][$id]
                );
                $valString .= "('" . $id . "','" . $fixture['foo'] . "','" . $fixture['bar'] . "','" .$fixture['path'] . "','" . $some_id . "'),";
                $this->dataFixture[$some_id][$id] = $fixture;
            }
        }

        $stmt = $this->db->prepare(' INSERT INTO `simple_stubsimple2` (id, foo, bar, path, some_id) VALUES ' . substr($valString, 0, -1));
        $stmt->execute();
    }

}


#       Два дерева для тестов
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
#                                   9
#                                 1[1]18
#                                   |
#                            ----------------
#                            |      |       |
#                            10     11      12
#                          2[2]3  4[2]15  16[2]17
#                                   |
#                                   ---------
#                                   |       |
#                                   13      14
#                                 5[3]12 13[3]14
#                                   |
#                                   -----------------
#                                   |       |       |
#                                   15      16      17
#                                 6[4]7   8[4]9   10[4]11
#
#
#
#
#                        id
#    P.S.          lkey[level]rkey

?>