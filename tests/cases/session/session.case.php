<?php

fileLoader::load('session');


class sessionTest extends unitTestCase
{
    private $session;
    private $_old_session_data;

    public function setUp()
    {
        $this->session = new Session();

	if(isset($_SESSION)) {
            $this->_old_session_data = $_SESSION;
        } else {
            $this->_old_session_data = array();
        }

    }

    public function tearDown()
    {
        $_SESSION  = $this->_old_session_data;
    }

    public function fixture()
    {
        $_SESSION['key_first'] = 'value_first';
        $_SESSION['key_second'] = 'value_second';
        $_SESSION['key_main'] = 'value_main';
    }

    public function testGet()
    {
        $this->fixture();
        $this->assertEqual($this->session->get('key_first'), "value_first");
        $this->assertEqual($this->session->get('key_main'), "value_main");
    }

  

}

?>