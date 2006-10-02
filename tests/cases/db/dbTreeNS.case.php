<?php
fileLoader::load('db/dbTreeNS');


class dbTreeNsTest extends unitTestCase
{
    private $db;
    private $tree;
    private $table;

    public function __construct()
    {
        $this->db = db::factory();
        $this->table = 'simple_simple_tree';
        $init = array ('tree' => array('table' => $this->table, 'id' => 'id'));
        $this->tree = new dbTreeNS($init);
        $this->clearDb();
    }

    public function setUp()
    {
        //$this->clearDb();
        $this->fixture();
    }
    public function tearDown()
    {
         $this->clearDb();
        //$this->fixture();
    }

    private function clearDb()
    {
        $this->db->query('TRUNCATE TABLE `' . $this->table .'`');

    }

    private function setFixture($idArray)
    {
        foreach($idArray as $id) {
            $fixture[$id] = $this->fixture[$id];
        }

        return $fixture;
    }

    private function fixture()
    {
        $this->fixture = array('1' => array('id'=>1, 'lkey'=>1 ,'rkey' =>16,'level'=>1),
                       '2' => array('id'=>2, 'lkey'=>2 ,'rkey' =>7 ,'level'=>2),
                       '3' => array('id'=>3, 'lkey'=>8 ,'rkey' =>13,'level'=>2),
                       '4' => array('id'=>4, 'lkey'=>14,'rkey'=>15 ,'level'=>2),
                       '5' => array('id'=>5, 'lkey'=>3 ,'rkey'=>4  ,'level'=>3),
                       '6' => array('id'=>6, 'lkey'=>5 ,'rkey'=>6  ,'level'=>3),
                       '7' => array('id'=>7, 'lkey'=>9 ,'rkey'=>10 ,'level'=>3),
                       '8' => array('id'=>8, 'lkey'=>11,'rkey'=>12 ,'level'=>3)
                       );
        $valString = '';
        foreach($this->fixture as $id => $data) {
            $valString .= "('" . $id . "','" . $data['lkey'] . "','" . $data['rkey'] . "','" . $data['level'] . "'),";
        }
        $valString = substr($valString, 0,  strlen($valString)-1);
        $stmt = $this->db->prepare(' INSERT INTO `' . $this->table .'` VALUES ' . $valString);
        $stmt->execute();
    }

    public function testGetTree()
    {
        $tree = $this->tree->getTree();

        $this->assertEqual(count($tree),count($this->fixture));
        foreach($tree as $id => $row) {
            $this->assertEqual($this->fixture[$id], $row);
        }

    }

    public function testGetExistNodeInfo()
    {
        $node = $this->tree->getNodeInfo($id = 5);

        $this->assertEqual($node, $this->fixture[$id]);
    }

    public function testGetExistNodeInfoWithId()
    {
        $node = $this->tree->getNodeInfo($id = 5, true);
        $this->fixture[$id]['id'] = $id;
        $this->assertEqual($node, $this->fixture[$id]);
    }

    public function testGetNotExistNodeInfo()
    {
        $node = $this->tree->getNodeInfo($id = 25);

        $this->assertNull($node);

    }

    public function testGetBranch()
    {
        $branch = $this->tree->getBranch($id = 1, $level = 1);

        $fixtureBranch = $this->setFixture(array(1,2,3,4));
        $this->assertEqual(count($fixtureBranch),count($branch));
        foreach ($branch as $id => $node) {
            $this->assertEqual($fixtureBranch[$id], $node);
        }
    }

/*    public function testGetBranchWithoutParent()
    {
        $branch = $this->tree->getBranch($id = 3, false);

        $fixtureBranch = $this->setFixture(array(7, 8));
        $this->assertEqual(count($fixtureBranch),count($branch));
        foreach ($branch as $id => $node) {
            $this->assertEqual($fixtureBranch[$id], $node);
        }

    }*/
/*
    public function testGetParentBranchWithChild()
    {
        $branch = $this->tree->getParentBranch($id = 8);

        $fixtureBranch = $this->setFixture(array(8, 3, 1));
        $this->assertEqual(count($fixtureBranch),count($branch));
        foreach ($branch as $id => $node) {
            $this->assertEqual($fixtureBranch[$id], $node);
        }
    }*/

    public function testGetParentBranch()
    {
        $branch = $this->tree->getParentBranch($id = 8, $level = 2);
        $fixtureBranch = $this->setFixture(array(8, 3, 1));
        $this->assertEqual(count($fixtureBranch),count($branch));
        foreach ($branch as $id => $node) {
            $this->assertEqual($fixtureBranch[$id], $node);
        }
    }

    public function testGetBranchContainingNode()
    {
        $branch = $this->tree->getBranchContainingNode($id = 2);

        $fixtureBranch = $this->setFixture(array(1, 2, 5, 6));
        $this->assertEqual(count($fixtureBranch),count($branch));

        foreach ($branch as $id => $node) {
            $this->assertEqual($fixtureBranch[$id], $node);
        }
    }

    public function testGetParentNode()
    {
        $parentNode = $this->tree->getParentNode($id = 6);
        $this->assertEqual('2', $parentNode['id']);
        $this->assertEqual($this->fixture['2'], $parentNode);
    }

    public function testGetNoHaveParentNode()
    {
        $parentNode = $this->tree->getParentNode($id = 1);
        $this->assertNull($parentNode);
    }

    public function testGetMaxRightKey()
    {
        $maxRKey = $this->tree->getMaxRightKey();
        $this->assertEqual($maxRKey, 16);
    }

    public function testInsertNode()
    {
        $newNode = $this->tree->insertNode(3);
        $fixtureNewNode = array('id'=>9,'lkey'=>13,'rkey'=>14 ,'level'=>3);
        $this->assertEqual($newNode, $fixtureNewNode);

    }

    public function testInsertRootNode()
    {
        $newRootNode = $this->tree->insertRootNode();
        $fixtureNewNode = array('id'=>9,'lkey'=>1,'rkey'=>18 ,'level'=>1);
        $this->assertEqual($newRootNode, $fixtureNewNode);

        $node = $this->tree->getNodeInfo($id = 5, true);
        $fixtureNewNode = array('id'=>5,'lkey'=>4,'rkey'=>5 ,'level'=>4);
        $this->assertEqual($node, $fixtureNewNode);
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
            $this->assertEqual($fixtureNewTree[$id], $node);
        }
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
            $this->assertEqual($fixtureNewTree[$id], $node);
        }

    }

    public function test2MoveNode()
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
            $this->assertEqual($fixtureNewTree[$id], $node);
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


    #        Вот с таким деревом и будем экспериментировать
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


}
?>