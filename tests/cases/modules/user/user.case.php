<?php

fileLoader::load('user');
fileLoader::load('user/mappers/userMapper');

Mock::generate('userMapper');

if (!defined('MZZ_USER_GUEST_ID')) {
    define('MZZ_USER_GUEST_ID', 1);
}

class userTest extends unitTestCase
{
    private $mapper;
    private $map;
    private $user;
    private $db;

    public function setUp()
    {
        $this->map = array(
        'id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId', 'once' => 'true' ),
        'login' => array ( 'name' => 'login', 'accessor' => 'getLogin', 'mutator' => 'setLogin'),
        'password' => array ('name' => 'password', 'accessor' => 'getPassword', 'mutator' => 'setPassword', 'decorateClass' => 'md5PasswordHash'),
        );

        $this->mapper = new userMapper('user');
        $this->user = new user($this->mapper, $this->map);

        $this->db = DB::factory();
        $this->cleardb();

        $this->db->query("INSERT INTO `user_group` (`id`, `name`) VALUES (1, 'foo_group'), (2, 'foo_group2')");
        $this->db->query("INSERT INTO `user_usergroup_rel` (`group_id`, `user_id`) VALUES (1, 2), (2, 2)");
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `user_user`');
        $this->db->query('TRUNCATE TABLE `user_group`');
        $this->db->query('TRUNCATE TABLE `user_usergroup_rel`');
    }

    public function testIsLoggedIn()
    {
        $id = 2;

        $this->assertNotEqual($id, MZZ_USER_GUEST_ID);
        $this->user->setId($id);

        $this->mapper->save($this->user);

        $this->assertTrue($this->user->isLoggedIn());
    }

    public function testIsNotLoggedIn()
    {
        $this->user->setId(MZZ_USER_GUEST_ID);

        $this->mapper->save($this->user);

        $this->assertFalse($this->user->isLoggedIn());
    }

    public function testGetGroupsList()
    {
        $mapper = new mockuserMapper('news');

        $mapper->expectOnce('getGroupsList', array('2'));
        $mapper->setReturnValue('getGroupsList', $val = 'ok');

        $user = new user($mapper, $this->map);
        $user->setId(2);
        $this->mapper->save($user);
        $this->assertEqual($val, $user->getGroupsList());
    }
}


?>