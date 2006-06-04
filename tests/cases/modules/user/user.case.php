<?php

fileLoader::load('user');
fileLoader::load('user/mappers/userMapper');

//Mock::generate('userMapper');

class userTest extends unitTestCase
{
    private $mapper;
    private $user;
    private $db;

    public function setUp()
    {
        $map = array(
        'id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId', 'once' => 'true' ),
        'login' => array ( 'name' => 'login', 'accessor' => 'getLogin', 'mutator' => 'setLogin'),
        'password' => array ('name' => 'password', 'accessor' => 'getPassword', 'mutator' => 'setPassword', 'decorateClass' => 'md5PasswordHash'),
        );

        //$this->mapper = new mockuserMapper('news');
        $this->mapper = new userMapper('user');
        $this->user = new user($map);

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
    }

    public function testIsLoggedIn()
    {
        $this->user->setId(2);

        $this->mapper->save($this->user);

        $this->assertTrue($this->user->isLoggedIn());
    }

    public function testIsNotLoggedIn()
    {
        $this->user->setId(1);

        $this->mapper->save($this->user);

        $this->assertFalse($this->user->isLoggedIn());
    }
}


?>