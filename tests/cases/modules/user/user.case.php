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
        'userGroup' => array ('name' => 'userGroup', 'accessor' => 'getUserGroup', 'mutator' => 'setUserGroup', 'hasMany' => 'id->userGroupRel.user_id' ),
        );

        $this->mapper = new userMapper('user');
        $this->user = new user($this->mapper, $this->map);

        $this->db = DB::factory();
        $this->cleardb();
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `user_user`');
        $this->db->query('TRUNCATE TABLE `user_userGroupRel`');
    }

    public function testRetrieve()
    {
        $this->db->query("INSERT INTO `user_user` (`id`, `login`, `password`, `obj_id`) VALUES (5, 'somelogin', 'somepass', 666)");

        $user = $this->mapper->searchById(5);

        $this->assertEqual($user->getId(), 5);
        $this->assertEqual($user->getLogin(), 'somelogin');
        $this->assertEqual($user->getPassword(), 'somepass');
        $this->assertEqual($user->getObjId(), 666);
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
/*
    public function testGetGroupsList()
    {
        $mapper = new mockuserMapper('news');

        $mapper->expectOnce('getGroupsList', array('2'));
        $mapper->setReturnValue('getGroupsList', $val = 'ok');

        $user = new user($mapper, $this->map);
        $user->setId(2);
        $this->mapper->save($user);
        $this->assertEqual($val, $user->getGroupsList());
    }*/
}


?>