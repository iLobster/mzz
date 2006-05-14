<?php

fileLoader::load('user');
fileLoader::load('user/mappers/userMapper');

Mock::generate('userMapper');

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
        $this->user = new user($this->mapper, $map);
        
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

    public function testAccessorsAndMutators()
    {
        $this->user->setId($id = 1);
        $this->mapper->save($this->user);
        
        $this->assertEqual($id, $this->user->getId());
        
        $props = array('Login', 'Password');
        foreach ($props as $prop) {
            $getprop = 'get' . $prop;
            $setprop = 'set' . $prop;

            $this->assertNull($this->user->$getprop());

            $val = 'foo';
            $this->user->$setprop($val);
            
            if ($prop == 'Password') {
                $val = md5($val);
            }

            $this->assertNull($this->user->$getprop());
            
            $this->mapper->save($this->user);
            
            $this->assertEqual($val, $this->user->$getprop());

            $val2 = 'bar';
            $this->user->$setprop($val2);
            
            if ($prop == 'Password') {
                $val2 = md5($val2);
            }

            $this->assertEqual($val, $this->user->$getprop());
            
            $this->mapper->save($this->user);
            
            $this->assertEqual($val2, $this->user->$getprop());
        }
    }

    public function testException()
    {
        try {
            $this->user->getFoo();
            $this->fail('Должен быть брошен EXCEPTION!');
        } catch (Exception $e) {
            $this->assertWantedPattern('/user::getfoo/i', $e->getMessage());
        }

        try {
            $this->user->setFoo('foo');
            $this->fail('Должен быть брошен EXCEPTION!');
        } catch (Exception $e) {
            $this->assertWantedPattern('/user::setfoo/i', $e->getMessage());
        }
    }

    public function testIdNull()
    {
        $this->assertNull($this->user->getId());
    }

    public function testFieldsSetsOnce()
    {
        foreach(array('Id') as $val) {
            $setter = 'set' . $val;
            $getter = 'get' . $val;

            $first = '2';

            $this->user->$setter($first);
            
            $this->mapper->save($this->user);

            $this->assertIdentical($this->user->$getter(), $first);

            $second = '5';
            $this->assertNotEqual($second, $first);

            $this->user->$setter($second);
            
            $this->mapper->save($this->user);
            
            $this->assertIdentical($this->user->$getter(), $first);
        }

        $this->user->import(array('id' => $second));
        $this->mapper->save($this->user);

        $this->assertIdentical($this->user->$getter(), $first);
    }

    public function testFieldsSetsNotOnce()
    {
        foreach(array('Login') as $val) {
            $setter = 'set' . $val;
            $getter = 'get' . $val;

            $first = '2';

            $this->user->$setter($first);
            
            $this->mapper->save($this->user);

            $this->assertIdentical($this->user->$getter(), $first);

            $second = '5';
            $this->assertNotEqual($second, $first);

            $this->user->$setter($second);
            
            $this->mapper->save($this->user);
            
            $this->assertIdentical($this->user->$getter(), $second);
        }
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