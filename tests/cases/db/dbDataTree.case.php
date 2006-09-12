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
        $this->dataTable = 'simple_stubsimple';

        $init = array ('data' => array('table' => $this->dataTable, 'id' =>'id'),
                       'tree' => array('table' => $this->table , 'id' =>'id'));

        $this->tree = new dbTreeNS($init, 'foo');
        $this->fixtureType = 'dataFixture';
        $this->clearDb();

    }

    public function setUp()
    {
        $this->fixture();
    }
    public function tearDown()
    {
         $this->clearDb();
    }

    private function clearDb()
    {
        $this->db->query('TRUNCATE TABLE `simple_simple_tree`');
        $this->db->query('TRUNCATE TABLE `simple_stubsimple`');

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

        $simple_simple_tree_fields = '(id, lkey, rkey, level)';
        $simple_stubsimple_fields = '(id, foo, bar, path)';

        #запись фикстур в базу
        foreach($values as $table => $val) {
            $fields = $table . '_fields';
            $stmt = $this->db->prepare('INSERT INTO `' . $table . '` ' . $$fields  . ' VALUES ' . $val);
            $stmt->execute();
            }
    }

    private function assertEqualFixtureAndBranch($fixture, $branch)
    {
        foreach($branch as $id => $node) {
            $this->assertEqual($fixture[$id]['id'], $node['id']);
            $this->assertEqual($fixture[$id]['foo'], $node['foo']);
            $this->assertEqual($fixture[$id]['bar'], $node['bar']);
            $this->assertEqual($fixture[$id]['path'], $node['path']);
        }
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

    public function testGetParentNode()
    {
        $parentNode = $this->tree->getParentNode($id = 6);
        $this->assertEqual('2', $parentNode['id']);
        $this->assertEqual($this->dataFixture['2']['id'], $parentNode['id']);
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


        $badPaths[] = 'not_exist/foo3/foo1';
        $badPaths[] = '/foo3/foo1/';
        $badPaths[] = '/foo1/foo3/foo7';
        $badPaths[] = '/foo1/foo2/foo3/';


        $fixtureNodes = $this->setFixture(array(7,8));
        $this->tree->setCorrectPathMode(true);

        foreach($paths as $path) {
            $nodes = $this->tree->getBranchByPath($path);
            foreach($nodes as $id => $node) {
                $this->assertEqual($node['id'], $fixtureNodes[$id]['id']);
                $this->assertEqual($node['path'], $fixtureNodes[$id]['path']);
                }
        }

        foreach($badPaths as $path) {
            $nodes = $this->tree->getBranchByPath($path);
            if(!empty($nodes)) {
                foreach($nodes as $id => $node) {
                    unset($nodes['obj_id']);
                    if(isset($fixtureNodes[$id])) {
                        $this->assertNotEqual($node, $fixtureNodes[$id]);
                    }
                }
            }
        }
    }

    public function testGetOneLevelBranchByPath()
    {
        $paths[] = '/foo1/foo3/';
        $paths[] = 'foo1/foo3';
        $paths[] = '//foo1////foo3////';

        $badPaths[] = 'not_exist/foo3/foo1';
        $badPaths[] = '/foo1/foo3/not_exist';
        $badPaths[] = '/foo3/foo1/';
        $badPaths[] = '/foo1/foo3/foo2';
        $badPaths[] = '/foo1/foo2/foo3/';


        $fixtureNodes = $this->setFixture(array(7,8));
        $this->tree->setCorrectPathMode(false);

        foreach($paths as $path) {
            $nodes = $this->tree->getBranchByPath($path);
            foreach($nodes as $id => $node) {
                $this->assertEqual($node['id'], $fixtureNodes[$id]['id']);
                $this->assertEqual($node['path'], $fixtureNodes[$id]['path']);
                }
        }

        foreach($badPaths as $path) {
            $nodes = $this->tree->getBranchByPath($path);
            if(!empty($nodes)) {
                foreach($nodes as $id => $node) {
                    unset($nodes['obj_id']);
                    if(isset($fixtureNodes[$id])) {
                        $this->assertNotEqual($node, $fixtureNodes[$id]);
                    }
                }
            }
        }
    }

    public function testCreateNewPaths_AfterInsertNewNode()
    {
        // вставляем новую запись в таблицу с данными
        $newDataRecord = array('foo' => 'newFoo', 'bar' => 'newBar');
        $this->db->query(" INSERT INTO " . $this->dataTable . '(foo, bar)' .
        " VALUES ('" . $newDataRecord['foo'] . "','" . $newDataRecord['bar'] . "')");
        $newDataID = $this->db->lastInsertId();

        // добавляем в структуру дерева новый узел
        $newNode = $this->tree->insertNode(3);

        $pathFixture = 'foo1/foo3/newFoo';

        $this->assertEqual($newDataID, $newNode['id']);
        $this->assertEqual($pathFixture, $this->tree->getPath($newNode['id']));
    }

    public function testCreateNewPaths_AfterInsertRootNode()
    {
        $newRootDataRecord = array('foo' => 'rootFoo', 'bar' => 'rootBar');
        $this->db->query(" INSERT INTO " . $this->dataTable . '(foo, bar)' .
        " VALUES ('" . $newRootDataRecord['foo'] . "','" . $newRootDataRecord['bar'] . "')");
        $newRootID = $this->db->lastInsertId();

        // добавляем в структуру дерева корневой узел
        $newNode = $this->tree->insertRootNode();
        $newTree = $this->tree->getTree();

        $fixtureTree = $this->setFixture();

        $this->assertEqual($newRootID, $newNode['id']);

        foreach($fixtureTree as $i => $node) {
            $fixtureTree[$i]['path'] = $newRootDataRecord['foo'] . '/' . $fixtureTree[$i]['path'];
            $this->assertEqual($newTree[$i]['path'], $fixtureTree[$i]['path']);
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
            $this->assertEqual($newTree[$i]['path'], $newTreePathFixture[$i]);
        }

    }

    public function testRemoveNodeAndRemoveRecordsInDataTable()
    {
        $fixtureTree = $this->setFixture(array(1, 3, 4, 7, 8));

        $this->tree->removeNode(2);
        $newTree = $this->tree->getTree();

        foreach($newTree as $i => $node) {
            unset($node['obj_id'], $node['rel']);
            $this->assertEqual($node, $fixtureTree[$i]);
        }
    }
}



?>