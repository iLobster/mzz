<?php

fileLoader::load('db/dbTreeNS');
fileLoader::load('db/sqlFunction');
fileLoader::load('db/simpleSelect');
fileLoader::load('cases/db/dbTreeNSNonIdJoinField/stubMapper3.class');
fileLoader::load('cases/db/dbTreeNS/stubSimple.class');

class dbTreeDataNonIdJoinTest extends unitTestCase
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
		'joinfield' => array ('name' => 'joinfield','accessor' => 'getJoinField', 'mutator' => 'setJoinField'),
		'obj_id' => array ('name' => 'obj_id','accessor' => 'getObjId', 'mutator' => 'setObjId'),
		);

		$this->mapper = new stubMapperForTreeNonIdTest('simple');
		$this->mapper->setMap($this->map);
		$this->db = db::factory();

		$this->table = 'simple_stubSimple_tree';
		$this->dataTable = $this->mapper->getTable();
		//echo "<pre>";var_dump($this->dataTable);echo "</pre>";

		$init = array ('mapper' => $this->mapper, 'joinField' => 'joinfield', 'treeTable' => $this->table);



		$this->tree = new dbTreeNS($init, 'foo');

		$this->clearDb();

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
		$this->db->query('TRUNCATE TABLE `simple_stubSimple3`');
		$this->db->query('TRUNCATE TABLE `user_user`');
		$this->db->query("DELETE FROM `sys_classes` WHERE `id` = 3");

	}

	private function assertEqualFixtureAndBranch($fixture, $branch)
	{
		foreach($branch as $id => $node) {
			$this->assertEqual($fixture[$id]['id'], $node->getId());
			$this->assertEqual($fixture[$id]['foo'], $node->getFoo());
			$this->assertEqual($fixture[$id]['bar'], $node->getBar());
			$this->assertEqual($fixture[$id]['path'], $node->getPath());
			$this->assertEqual($this->treeFixture[$id + 1]['level'], $node->getLevel());
			$this->assertEqual($this->treeFixture[$id + 1]['lkey'], $node->getLeftKey());
			$this->assertEqual($this->treeFixture[$id + 1]['rkey'], $node->getRightKey());
		}
	}

	private function setFixture($idArray = null)
	{

		if(!is_array($idArray)) {
			$idArray = range(1, 8);
		}

		foreach($idArray as $id) {
			$fixture[$id] =  $this->dataFixture[$id];
		}

		// убираем имя корневого элемента из path
		foreach ($fixture as $key => $val) {
			if ($key != 1) {
				$fixture[$key]['path'] = substr($val['path'], strpos($val['path'], '/') + 1);
			}
		}

		return $fixture;
	}

	private function fixture()
	{
		# заполнение фикстуры дерева
		$this->treeFixture = array(
		'2' => array('id'=>1, 'lkey'=>1 ,'rkey' =>16,'level'=>1),
		'3' => array('id'=>2, 'lkey'=>2 ,'rkey' =>7 ,'level'=>2),
		'4' => array('id'=>3, 'lkey'=>8 ,'rkey' =>13,'level'=>2),
		'5' => array('id'=>4, 'lkey'=>14,'rkey'=>15 ,'level'=>2),
		'6' => array('id'=>5, 'lkey'=>3 ,'rkey'=>4  ,'level'=>3),
		'7' => array('id'=>6, 'lkey'=>5 ,'rkey'=>6  ,'level'=>3),
		'8' => array('id'=>7, 'lkey'=>9 ,'rkey'=>10 ,'level'=>3),
		'9' => array('id'=>8, 'lkey'=>11,'rkey'=>12 ,'level'=>3)
		);

		$this->treePathFixture = array(
		1 => 'foo1',
		2 => 'foo1/foo2',
		3 => 'foo1/foo3',
		4 => 'foo1/foo4',
		5 => 'foo1/foo2/foo5',
		6 => 'foo1/foo2/foo6',
		7 => 'foo1/foo3/foo7',
		8 => 'foo1/foo3/foo8');

		$valString = '';
		foreach($this->treeFixture as $id => $data) {
			$valString .= "('" . $id . "','" . $data['lkey'] . "','" . $data['rkey'] . "','" . $data['level'] . "'),";
		}
		$values[$this->table] = substr($valString, 0, -1);

		#заполнение фикстуры таблицы данных
		$valString = '';
		foreach($this->treeFixture as $id => $row) {
			
			$this->dataFixture[$row['id']] = array(
			'id' => $row['id'] ,
			'foo' =>'foo' . $row['id'] ,
			'bar' => 'bar' . $row['id'] ,
			'path' => $this->treePathFixture[$row['id']],
			'joinfield' => $id,
			);

			$valString .= "('" . $row['id'] . "','" .
			$this->dataFixture[$row['id']]['foo'] . "','" .
			$this->dataFixture[$row['id']]['bar'] . "','" .
			$this->dataFixture[$row['id']]['path'] .  "','" .
			$this->dataFixture[$row['id']]['joinfield'] . "'),";
		}
		$values[$this->dataTable] = substr($valString, 0, -1);

		$simple_stubSimple_tree_fields = '(id, lkey, rkey, level)';
		$simple_stubSimple3_fields = '(id, foo, bar, path, joinfield)';

		#запись фикстур в базу
		foreach($values as $table => $val) {
			$fields = $table . '_fields';
			$query = 'INSERT INTO `' . $table . '` ' . $$fields  . ' VALUES ' . $val;
			$this->db->exec($query);
		}
	}



	public function testGetTree()
	{
		# выбираем два уровня
		$tree = $this->tree->getTree($level = 2);

		$fixtureDataTree = $this->setFixture(array(1, 2, 3, 4));
		$this->assertEqual(count($fixtureDataTree),count($tree));
		$this->assertEqualFixtureAndBranch($fixtureDataTree, $tree);
	}

	public function testGetBranch()
	{
		// Выборка ветки берется по ID(tree.id = data.joinfield) узла в дереве, а не в таблице данных
		// так как сдвиг по id у дерева 1, то делаем +1
		$branch = $this->tree->getBranch(1+1, $level = 1);

		$fixtureBranch = $this->setFixture(array(1, 2, 3, 4));		
		$this->assertEqual(count($fixtureBranch), count($branch));
		$this->assertEqualFixtureAndBranch($fixtureBranch, $branch);
	}
	
    public function testMoveNode()
    {
        $this->tree->moveNode(3+1, 4+1);
        $fixtureNewTree = array(
        '2' => array('id'=>1, 'lkey'=>1 ,'rkey' =>16,'level'=>1),
        '3' => array('id'=>2, 'lkey'=>2 ,'rkey' =>7 ,'level'=>2),
        '6' => array('id'=>5, 'lkey'=>3 ,'rkey'=>4  ,'level'=>3),
        '7' => array('id'=>6, 'lkey'=>5 ,'rkey'=>6  ,'level'=>3),
        '5' => array('id'=>4, 'lkey'=>8 ,'rkey'=>15 ,'level'=>2),
        '4' => array('id'=>3, 'lkey'=>9 ,'rkey' =>14,'level'=>3),
        '8' => array('id'=>7, 'lkey'=>10,'rkey'=>11 ,'level'=>4),
        '9' => array('id'=>8, 'lkey'=>12,'rkey'=>13 ,'level'=>4)
        );
        
        $treePathFixture = array(
		1 => 'foo1',		
		2 => 'foo2',		
		3 => 'foo4/foo3',
		4 => 'foo4',		
		5 => 'foo2/foo5',
		6 => 'foo2/foo6',		
		7 => 'foo4/foo3/foo7',
		8 => 'foo4/foo3/foo8');

        $newTree = $this->tree->getTree();
        $this->assertEqual(count($fixtureNewTree), count($newTree));

        foreach ($newTree as $id => $node) {
        	$tree_id = $id + 1;

            $this->assertEqual('foo' . $id, $node->getFoo());
            $this->assertEqual('bar' . $id, $node->getBar());
            
            $this->assertEqual($treePathFixture[$id], $node->getPath());
            
            $this->assertEqual($fixtureNewTree[$tree_id]['id'], $node->getId());           
            $this->assertEqual($fixtureNewTree[$tree_id]['rkey'], $node->getRightKey());
            $this->assertEqual($fixtureNewTree[$tree_id]['lkey'], $node->getLeftKey());
            $this->assertEqual($fixtureNewTree[$tree_id]['level'], $node->getLevel());
            
        }
    }	

}


#        Вот на таком деревом и будем тестировать
#
#
#                                   2
#                                 1[1]16
#                                   |
#                            ----------------
#                            |      |       |
#                            3      4       5
#                          2[2]7  8[3]13 14[4]15
#                            |      |
#                      -------      ---------
#                      |     |      |       |
#                      6     7      8       9
#                    3[5]4 5[6]6  9[7]10 11[8]12
#
#
#
#  P.S.             id
#            lkey[level]rkey
#


?>