<?php

fileLoader::load('user/mappers/groupMapper');
fileLoader::load('user/group');

class groupMapperTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $map;

    public function __construct()
    {
        $this->map = array(
        'id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId', 'once' => 'true' ),
        'name' => array ( 'name' => 'name', 'accessor' => 'getName', 'mutator' => 'setName'),
        );

        $this->db = DB::factory();
        $this->cleardb();
    }

    public function setUp()
    {
        $this->mapper = new groupMapper('user');
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `user_user_group`');
        //$this->db->query('ALTER TABLE `news_news`, auto_increment = 1');
    }

    public function testSave()
    {
        $group = new group($this->map);
        $group->setName($name = 'someName');

        $this->assertNull($group->getId());

        $this->mapper->save($group);

        $this->assertIdentical($group->getId(), '1');
        $this->assertEqual($group->getName(), $name);
    }

    public function testSearchById()
    {
        $this->fixture($this->map);
        $this->assertIsA($group = $this->mapper->searchById(1), 'group');
        $this->assertIdentical($group->getId(), '1');
    }

    public function testSearchByName()
    {
        $this->fixture($this->map);
        $this->assertIsA($group = $this->mapper->searchByName('name2'), 'group');
        $this->assertIdentical($group->getId(), '2');
    }

    public function testUpdate()
    {
        $this->fixture($this->map);
        $group = $this->mapper->searchById(1);

        $this->assertEqual($group->getName(), 'name1');

        $group->setName($name = 'newName');

        $this->mapper->save($group);

        $group2 = $this->mapper->searchById(1);

        $this->assertEqual($group2->getName(), $name);
    }

    public function testDelete()
    {
        $this->fixture($this->map);

        $this->assertEqual(4, $this->countGroups());

        $this->mapper->delete(1);

        $this->assertEqual(3, $this->countGroups());
    }



    private function countGroups()
    {
        $query = 'SELECT COUNT(*) AS `total` FROM `user_user_group`';
        $total = $this->db->getOne($query);
        return $total;
    }

    private function fixture($map)
    {
        for($i = 1; $i <= 4; $i++) {
            $group = new group($map);
            $group->setName('name' . $i);
            $this->mapper->save($group);
        }
    }
}

?>