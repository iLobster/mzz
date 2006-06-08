<?php
fileLoader::load('db/dbTreeNS');
fileLoader::load('modules/simple/simple.mapper');
fileLoader::load('cases/modules/simple/stubMapper.class');
fileLoader::load('cases/modules/simple/stubSimple.class');

class dbTreeDataTest extends unitTestCase
{
    private $db;
    private $tree;
    private $table;

    public function __construct()
    {
        $this->db = db::factory();
        $this->table = 'simple_simple_tree';
        $this->dataTable = 'simple_simple';

        $init = array ('data' => array('table' => $this->dataTable, 'id' =>'id'),
                       'tree' => array('table' => $this->table , 'id' =>'id'));

        $this->tree = new dbTreeNS($init);
        $this->mapper = new stubMapper($section = 'simple');
        $this->fixtureType = 'dataFixture';
        //echo'<pre>';print_r($this->mapper); echo'</pre>';
        //echo'<pre>';print_r($this); echo'</pre>';
        $this->clearDb();
        //$this->fixture();
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
        $this->db->query('TRUNCATE TABLE `' . $this->table . '`');
        $this->db->query('TRUNCATE TABLE `' . $this->dataTable . '`');

    }

    private function setFixture($idArray)
    {
        switch($this->fixtureType) {
            case 'treeFixture' : $fix =  $this->treeFixture; break;
            case 'dataFixture' : $fix =  $this->dataFixture; break;

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
        $valString = '';
        foreach($this->treeFixture as $id => $data) {
            $valString .= "('" . $id . "','" . $data['lkey'] . "','" . $data['rkey'] . "','" . $data['level'] . "'),";
        }
        $values[$this->table] = substr($valString, 0,  strlen($valString)-1);

        #заполнение фикстуры таблицы данных
        $valString = '';
        foreach($this->treeFixture as $id => $row) {
            $this->dataFixture[$id] = array('id' => $id, 'foo' =>'foo' . $id , 'bar' => 'bar' . $id);
            $valString .= "('" . $id . "','" . $this->dataFixture[$id]['foo'] . "','" . $this->dataFixture[$id]['bar'] . "'),";
        }
        $values[$this->dataTable] = substr($valString, 0,  strlen($valString)-1);

        #запись фикстур в базу
        foreach($values as $table => $val) {
            $stmt = $this->db->prepare(' INSERT INTO `' .$table. '` VALUES ' . $val);
            $stmt->execute();

            }
    }

    public function testGetTree()
    {
        # выбираем два уровня
        $tree = $this->tree->getTree($level = 2);

        $fixtureDataTree = $this->setFixture(array(1,2,3,4));
        $this->assertEqual(count($fixtureDataTree),count($tree));
        foreach($tree as $id => $row) {
            $this->assertEqual($fixtureDataTree[$id], $row);
        }
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
        $this->assertEqual($this->dataFixture['2'], $parentNode);
    }

    public function testGetNoHaveParentNode()
    {
        $parentNode = $this->tree->getParentNode($id = 1);
        $this->assertNull($parentNode);
    }


}



?>