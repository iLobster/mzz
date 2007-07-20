<?php

fileLoader::load('db/new_dbTreeNS');
fileLoader::load('db/sqlFunction');
fileLoader::load('db/simpleSelect');

class new_dbTreeNSTest extends unitTestCase
{
    protected $db;
    protected $tree;
    protected $structure;

    public function __construct()
    {
        $this->db = db::factory();
        $this->clearDb();
    }

    public function setUp()
    {
        $this->tree = new new_dbTreeNS('treeNS');

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
            $qry .= '(' . $id .', ' . $node[0] .', ' . $node[1] .', ' . $node[2] .'), ';
        }
        $qry = substr($qry, 0, -2);

        $this->db->query('INSERT INTO `treeNS` (`id`, `lkey`, `rkey`, `level`) VALUES ' . $qry);
    }

    #        ¬от на таком деревом и будем тестировать
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
        $this->db->query('TRUNCATE TABLE `treeNS`');
    }

    private function assertTreeEqual($src, $tree)
    {
        $this->assertEqual(sizeof($src), sizeof($tree));

        foreach ($tree as $key => $val) {
            $this->assertEqual($src[$key], $this->tree->createItemFromRow($val));
        }
    }

    private function getSlice(Array $ids)
    {
        $array = array();
        foreach ($ids as $id) {
            $array[] = array('id'=> $id, 'lkey' => $this->structure[$id][0], 'rkey' => $this->structure[$id][1], 'level' => $this->structure[$id][2]);
        }
        return $array;
    }

    public function testGetTree()
    {
        $this->assertTreeEqual($this->getSlice(array(1, 2, 5, 6, 3, 7, 8, 4)), $this->tree->getTree());
        $this->assertTreeEqual($this->getSlice(array(1, 2, 5, 6, 3, 7, 8, 4)), $this->tree->getTree(3));
        $this->assertTreeEqual($this->getSlice(array(1, 2, 3, 4)), $this->tree->getTree(2));
        $this->assertTreeEqual($this->getSlice(array(1)), $this->tree->getTree(1));
    }

    public function testGetBranch()
    {
        $this->assertTreeEqual($this->getSlice(array(1, 2, 5, 6, 3, 7, 8, 4)), $this->tree->getBranch(1));
        $this->assertTreeEqual($this->getSlice(array(2, 5, 6)), $this->tree->getBranch(2));
        $this->assertTreeEqual($this->getSlice(array(4)), $this->tree->getBranch(4));
    }

    public function testGetParentBranch()
    {
        $this->assertTreeEqual($this->getSlice(array(1)), $this->tree->getParentBranch(1));
        $this->assertTreeEqual($this->getSlice(array(1, 2)), $this->tree->getParentBranch(2));
        $this->assertTreeEqual($this->getSlice(array(1, 2, 5)), $this->tree->getParentBranch(5));
        $this->assertTreeEqual($this->getSlice(array(1, 4)), $this->tree->getParentBranch(4));
    }

    public function testGetBranchContainingNode()
    {
        $this->assertTreeEqual($this->getSlice(array(1, 2, 5, 6, 3, 7, 8, 4)), $this->tree->getBranchContainingNode(1));
        $this->assertTreeEqual($this->getSlice(array(1, 2, 5, 6)), $this->tree->getBranchContainingNode(2));
        $this->assertTreeEqual($this->getSlice(array(1, 2, 5)), $this->tree->getBranchContainingNode(5));
    }

    public function testGetParentNode()
    {
        $parent = $this->tree->getParentNode(2);
        $this->assertEqual($parent['id'], 1);

        $parent = $this->tree->getParentNode(5);
        $this->assertEqual($parent['id'], 2);
    }

    public function testMoveNode_Up()
    {
        $this->tree->move(5, 4);
        $this->structure[2] = array(2, 5, 2);
        $this->structure[6] = array(3, 4, 3);

        $this->structure[4] = array(12, 15, 2);
        $this->structure[5] = array(13, 14, 3);

        $this->assertTreeEqual($this->getSlice(array(2, 6)), $this->tree->getBranch(2));
        $this->assertTreeEqual($this->getSlice(array(4, 5)), $this->tree->getBranch(4));
    }

    public function testMoveNode_Down()
    {
        $this->tree->move(4, 5);

        $this->structure[2] = array(2, 9, 2);
        $this->structure[6] = array(7, 8, 3);

        $this->structure[4] = array(4, 5, 4);
        $this->structure[5] = array(3, 6, 3);

        $this->assertTreeEqual($this->getSlice(array(2, 5, 4, 6)), $this->tree->getBranch(2));
    }

    public function testInsertNode()
    {
        $this->tree->insert(2);
        $this->structure[2] = array(2, 9, 2);
        $this->structure[9] = array(7, 8, 3);

        $this->assertTreeEqual($this->getSlice(array(2, 5, 6, 9)), $this->tree->getBranch(2));
    }

    public function testDeleteNode()
    {
        $this->tree->delete(2);

        $this->structure[1] = array(1, 10, 1);
        $this->structure[3] = array(2, 7, 2);
        $this->structure[7] = array(3, 4, 3);
        $this->structure[8] = array(5, 6, 3);
        $this->structure[4] = array(8, 9, 2);

        $this->assertTreeEqual($this->getSlice(array(1, 3, 7, 8, 4)), $this->tree->getTree());
    }
}

?>