<?php

fileLoader::load('user');
fileLoader::load('user/mappers/userMapper');

Mock::generate('userMapper');

class userTest extends unitTestCase
{
    private $user;

    public function setUp()
    {
        $map = array(
        'id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId', 'once' => 'true' ),
        'login' => array ( 'name' => 'login', 'accessor' => 'getLogin', 'mutator' => 'setLogin'),
        'password' => array ('name' => 'password', 'accessor' => 'getPassword', 'mutator' => 'setPassword'),
        );

        $this->user = new user($map);
    }

    public function testAccessorsAndMutators()
    {
        $props = array('Login', 'Password');
        foreach ($props as $prop) {
            $getprop = 'get' . $prop;
            $setprop = 'set' . $prop;

            $this->assertNull($this->user->$getprop());

            $val = 'foo';
            $this->user->$setprop($val);

            $this->assertEqual($val, $this->user->$getprop());

            $val2 = 'bar';
            $this->user->$setprop($val2);

            $this->assertEqual($val2, $this->user->$getprop());
            $this->assertNotEqual($val, $this->user->$getprop());
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

            $this->assertIdentical($this->user->$getter(), $first);

            $second = '5';
            $this->assertNotEqual($second, $first);

            $this->user->$setter($second);
            $this->assertIdentical($this->user->$getter(), $first);
        }
    }
}


?>