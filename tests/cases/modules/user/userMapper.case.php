<?php

fileLoader::load('user/mappers/userMapper');
fileLoader::load('user');

class userMapperTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $map;

    public function __construct()
    {
        $this->map = array('id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId' ),
        'login' => array ( 'name' => 'login', 'accessor' => 'getLogin', 'mutator' => 'setLogin'),
        'password' => array ('name' => 'password', 'accessor' => 'getPassword', 'mutator' => 'setPassword', 'decorateClass' => 'md5PasswordHash'),
        );

        $this->db = DB::factory();
        $this->cleardb();
    }

    public function setUp()
    {
        $this->mapper = new userMapper('user');
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `user_user`');
        //$this->db->query('ALTER TABLE `news_news`, auto_increment = 1');
    }

    public function testSave()
    {
        $user = new user($this->map);
        $user->setLogin($login = 'somelogin');
        $user->setPassword('somepasswd');

        $this->assertNull($user->getId());

        $this->mapper->save($user);

        $this->assertIdentical($user->getId(), '1');
        $this->assertIdentical($user->getLogin(), $login);
    }

    public function testCreate()
    {
        $user = $this->mapper->create();
        $this->assertNull($user->getId());
        $this->assertNull($user->getLogin());
        $this->assertNull($user->getPassword());
    }

    public function testSearchById()
    {
        $this->fixture($this->map);
        $this->assertIsA($user = $this->mapper->searchById(1), 'user');
        $this->assertIdentical($user->getId(), '1');
    }

    public function testSearchByLogin()
    {
        $this->fixture($this->map);
        $this->assertIsA($user = $this->mapper->searchByLogin('login1'), 'user');
        $this->assertIdentical($user->getId(), '1');
    }

    public function testGetGroups()
    {
        $this->fixture($this->map);

        $map = array(
        'id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId', 'once' => 'true' ),
        'name' => array ( 'name' => 'name', 'accessor' => 'getName', 'mutator' => 'setName'),
        );

        $group_mapper = new groupMapper('user');
        for($i = 1; $i <= 2; $i++) {
            $group = new group($map);
            $group->setName('name' . $i);
            $group_mapper->save($group);
        }

        $stmt = $this->db->prepare('INSERT INTO `user_user_group_rel` (`group_id`, `user_id`) VALUES (:group_id, :user_id)');
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':group_id', $group_id, PDO::PARAM_INT);

        $user_id = 1; $group_id = 1;
        $stmt->execute();
        $user_id = 1; $group_id = 2;
        $stmt->execute();

        $groups = $this->mapper->getGroups(1);

        $this->assertEqual(sizeof($groups), 2);

        foreach ($groups as $key => $item) {
            $this->assertIsA($item, 'group');
            $this->assertEqual($item->getName(), 'name' . ($key + 1));
        }
    }

    public function testUpdate()
    {
        $this->fixture($this->map);
        $user = $this->mapper->searchById(1);

        $this->assertEqual($user->getLogin(), 'login1');
        $this->assertEqual($user->getPassword(), md5('passwd1'));

        $user->setLogin($login = 'newlogin');
        $user->setPassword($password = 'newpassword');

        $this->mapper->save($user);

        $user2 = $this->mapper->searchById(1);

        $this->assertEqual($user2->getLogin(), $login);
        $this->assertEqual($user2->getPassword(), md5($password));
    }

    public function testDelete()
    {
        $this->fixture($this->map);

        $this->assertEqual(4, $this->countUsers());

        $this->mapper->delete(1);

        $this->assertEqual(3, $this->countUsers());
    }

    public function testLogin()
    {
        $this->fixture($this->map);

        $user = $this->mapper->login('login1', 'passwd1');

        $this->assertEqual($user->getId(), 1);
        $this->assertEqual($_SESSION['user_id'], 1);
        $this->assertEqual($user->getLogin(), 'login1');
    }

    public function testLoginFalse()
    {
        $this->fixture($this->map);

        $user = $this->mapper->login('not_exists_login', 'any_password');

        $this->assertEqual($user->getId(), 1);
        $this->assertEqual($_SESSION['user_id'], 1);
    }

    public function testLoginException()
    {
        try {
            $user = $this->mapper->login('not_exists_login', 'any_password');
            $this->fail('no exception thrown?');
        } catch (mzzSystemException $e) {
            $this->assertPattern("/ID: 1/i", $e->getMessage());
            $this->pass();
        }
    }

    private function countUsers()
    {
        $query = 'SELECT COUNT(*) AS `total` FROM `user_user`';
        $total = $this->db->getOne($query);
        return $total;
    }

    private function fixture($map)
    {
        for($i = 1; $i <= 4; $i++) {
            $user = new user($map);
            $user->setLogin('login' . $i);
            $user->setPassword('passwd' . $i);
            $this->mapper->save($user);
        }
    }
}

?>