<?php

fileLoader::load('user');
fileLoader::load('user/mappers/userMapper');
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
        'user' => array ( 'name' => 'user', 'accessor' => 'getUser', 'mutator' => 'setUser', 'hasMany' => 'id->userGroup_rel.group_id', 'section' => 'user', 'module' => 'user', 'do' => 'userGroup'),
        );

        $this->db = DB::factory();
        $this->cleardb();
    }

    public function setUp()
    {
        $this->mapper = new groupMapper('user');
        $this->cleardb();
        $this->db->query("INSERT INTO `user_user` (`login`) VALUES ('GUEST')");
        $this->db->query("INSERT INTO `sys_classes` (`name`, `module_id`) VALUES ('group', 1), ('user', 1)");
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `user_user`');
        $this->db->query('TRUNCATE TABLE `user_group`');
        $this->db->query('TRUNCATE TABLE `user_userGroup_rel`');
        $this->db->query('TRUNCATE TABLE `sys_classes`');
        $this->db->query('TRUNCATE TABLE `sys_classes_sections`');
        $this->db->query('TRUNCATE TABLE `sys_access_registry`');
    }

    public function testSave()
    {
        $group = new group($this->mapper, $this->map);
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

    public function testGetUsers()
    {
        $this->fixture($this->map);

        $map = array('id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId' ),
        'login' => array ( 'name' => 'login', 'accessor' => 'getLogin', 'mutator' => 'setLogin'),
        'password' => array ('name' => 'password', 'accessor' => 'getPassword', 'mutator' => 'setPassword', 'decorateClass' => 'md5PasswordHash'),
        );
        $user_mapper = new userMapper('user');
        for($i = 2; $i <= 4; $i++) {
            $user = new user($user_mapper, $map);
            $user->setId($i);
            $user->setLogin('login' . $i);
            $user->setPassword('passwd' . $i);
            $user_mapper->save($user);
        }


        $stmt = $this->db->prepare('INSERT INTO `user_userGroup_rel` (`group_id`, `user_id`) VALUES (:group_id, :user_id)');
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':group_id', $group_id, PDO::PARAM_INT);

        $user_id = 2; $group_id = 1;
        $stmt->execute();
        $user_id = 3; $group_id = 1;
        $stmt->execute();

        $group = $this->mapper->searchById(1);

        $users = $group->getUsers();

        $this->assertEqual(sizeof($users), 2);

        foreach ($users as $key => $item) {

            $this->assertIsA($item, 'userGroup');
            $this->assertEqual($item->getUser()->getLogin(), 'login' . ($key + 1));
        }
    }

    public function testConvertArgsToId()
    {
        $this->fixture($this->map);

        $group = $this->mapper->searchById($id = 1);

        $this->assertEqual($this->mapper->convertArgsToId(array('id' => $id)), $group->getObjId());
    }


    private function countGroups()
    {
        $query = 'SELECT COUNT(*) AS `total` FROM `user_group`';
        $total = $this->db->getOne($query);
        return $total;
    }

    private function fixture($map)
    {
        for($i = 1; $i <= 4; $i++) {
            $group = new group($this->mapper, $map);
            $group->setName('name' . $i);
            $this->mapper->save($group);
        }
    }
}

?>