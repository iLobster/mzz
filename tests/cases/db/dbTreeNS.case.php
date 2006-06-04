<?php
fileLoader::load('db/dbTreeNS');

class dbTreeNsTest extends unitTestCase
{
    private $db;
    private $tree;

    public function __construct()
    {
        $this->db = db::factory();
        $this->tree = new dbTreeNS;
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
        $this->db->query('TRUNCATE TABLE `tree`');

    }

    private function setFixture($idArray)
    {
        foreach($idArray as $id){
            $fixture[$id] = $this->fixture[$id];
            }

        return $fixture;
    }

    private function fixture()
    {
        $this->fixture = array('1' => array('lkey'=>1 ,'rkey' =>16,'level'=>1),
                       '2' => array('lkey'=>2 ,'rkey' =>7 ,'level'=>2),
                       '3' => array('lkey'=>8 ,'rkey' =>13,'level'=>2),
                       '4' => array('lkey'=>14,'rkey'=>15 ,'level'=>2),
                       '5' => array('lkey'=>3 ,'rkey'=>4  ,'level'=>3),
                       '6' => array('lkey'=>5 ,'rkey'=>6  ,'level'=>3),
                       '7' => array('lkey'=>9 ,'rkey'=>10 ,'level'=>3),
                       '8' => array('lkey'=>11,'rkey'=>12 ,'level'=>3)
                       );
        foreach($this->fixture as $id => $data) {
             $this->db->query(" INSERT INTO `tree` VALUES('" . $id . "','" . $data['lkey'] . "','" . $data['rkey'] . "','" . $data['level'] . "')");
             }
    }

    public function testGetTree()
    {
        $tree = $this->tree->getTree();

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

    public function testGetBranchWithParent()
    {
        $branch = $this->tree->getBranch($id = 3);

        $fixtureBranch = $this->setFixture(array(3,7,8));
        $this->assertEqual(count($fixtureBranch),count($branch));
        foreach ($branch as $id => $node) {
            $this->assertEqual($fixtureBranch[$id], $node);
            }


    }

    public function testGetBranchWithoutParent()
    {
        $branch = $this->tree->getBranch($id = 2, false);

        $fixtureBranch = $this->setFixture(array(5, 6));
        $this->assertEqual(count($fixtureBranch),count($branch));
        foreach ($branch as $id => $node) {
            $this->assertEqual($fixtureBranch[$id], $node);
            }

    }

    public function testGetParentBranchWithChild()
    {
        $branch = $this->tree->getParentBranch($id = 8);

        $fixtureBranch = $this->setFixture(array(8, 3, 1));
        $this->assertEqual(count($fixtureBranch),count($branch));
        foreach ($branch as $id => $node){
            $this->assertEqual($fixtureBranch[$id], $node);
            }
    }

    public function testGetParentBranchWithoutChild()
    {
        $branch = $this->tree->getParentBranch($id = 8, false);

        $fixtureBranch = $this->setFixture(array(3, 1));
        $this->assertEqual(count($fixtureBranch),count($branch));
        foreach ($branch as $id => $node){
            $this->assertEqual($fixtureBranch[$id], $node);
            }
    }

    public function testGetBranchContainingNode()
    {
        $branch = $this->tree->getBranchContainingNode($id = 2);

        $fixtureBranch = $this->setFixture(array(1, 2, 5, 6));
        $this->assertEqual(count($fixtureBranch),count($branch));

        foreach ($branch as $id => $node){
            $this->assertEqual($fixtureBranch[$id], $node);
            }
    }

    public function testGetParentNode()
    {
        $parentNode = $this->tree->getParentNode($id = 6);
        $this->assertEqual('2', $parentNode['id']);
        unset($parentNode['id']);
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