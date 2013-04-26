<?php
fileLoader::load('session');
fileLoader::load('session/sessionDbStorage');


class sessionTest extends unitTestCase
{
    private $session;
    private $_old_session_data;

    public function setUp()
    {
        $this->session = new session('db');
        if(isset($_SESSION)) {
            $this->_old_session_data = $_SESSION;
        } else {
            $this->_old_session_data = array();
        }

    }

    public function tearDown()
    {
        $_SESSION = $this->_old_session_data;

    }

    public function fixture()
    {
        $_SESSION['key_first'] = 'value_first';
        $_SESSION['key_second'] = 'value_second';
        $_SESSION['key_third'] = 'value_third';
    }

    public function testGet()
    {
        $this->fixture();
        $this->assertEqual($this->session->get('key_first'), 'value_first');
        $this->assertEqual($this->session->get('key_third'), 'value_third');
    }

    public function testGetNull()
    {
        $this->assertNull($this->session->get('foo'));
    }

    public function testGetDefaultValue()
    {
        $this->assertEqual($this->session->get('foo', 'unknown'), 'unknown');
    }

    public function testSet()
    {
        $this->session->set($name = 'foo', $val = 'bar');
        $this->assertEqual($_SESSION[$name], $val);
    }

    public function testExists()
    {
        $this->fixture();
        $this->assertEqual($this->session->exists('key_first'), true);
    }

    public function testNotExists()
    {
        $this->assertEqual($this->session->exists('key_not_exists'), false);
    }

    public function testReset()
    {
        $this->fixture();
        $this->assertEqual(isset($_SESSION['key_first']), true);
        $this->assertEqual(isset($_SESSION['key_third']), true);
        $this->session->reset();
        $this->assertEqual(isset($_SESSION['key_first']), false);
        $this->assertEqual(isset($_SESSION['key_third']), false);
    }

    public function testDestroy()
    {
        $this->fixture();
        $this->assertEqual(isset($_SESSION['key_first']), true);
        $this->assertEqual(isset($_SESSION['key_third']), true);

        $this->session->destroy("key_first");

        $this->assertEqual(isset($_SESSION['key_first']), false); // destroyed
        $this->assertEqual(isset($_SESSION['key_third']), true); // exists
    }

    public function testArray()
    {
        $this->session->set('var[2][1][3][4]', 'foo');
        $this->session->set('var[2][lol]', 'bar');

        $this->assertEqual($this->session->get('var[2]'), array(1 => array(3 => array(4 => 'foo')), 'lol' => 'bar'));
        $this->assertEqual($this->session->get('var[3]', 'default'), 'default');
        $this->assertTrue($this->session->exists('var[2][1][3]'));
        $this->assertFalse($this->session->exists('var[2][1][4]'));
    }

    public function testArrayWithUnset()
    {
        $this->session->set('var[2][1][3][4]', 'foo');
        $this->session->set('var[2][lol]', 'bar');
        $this->session->set('var[2][3]', 'test');
        $this->session->set('var[3][1]', 'foo');

        $this->session->destroy('var[2][1]');
        $this->assertFalse($this->session->exists('var[2][1]'));
        $this->assertTrue($this->session->exists('var[2]'));
        $this->assertTrue($this->session->exists('var[2][3]'));

        $this->session->destroy('var[3]');
        $this->assertFalse($this->session->exists('var[3]'));
        $this->assertFalse($this->session->exists('var[3][1]'));
    }
}

?>