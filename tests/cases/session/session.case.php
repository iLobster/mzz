<?php

fileLoader::load('session');


class sessionTest extends unitTestCase
{
    private $session;
    private $_old_session_data;

    public function setUp()
    {
        $this->session = new session();

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





}

?>