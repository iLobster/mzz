<?php

fileLoader::load('request/httpRequest');
fileLoader::load('request/requestParser');
fileLoader::load('dataspace/arrayDataspace');

Mock::generate('requestParser');

class httpRequestTest extends unitTestCase
{
    protected $requestparser;
    protected $httprequest;
    protected $rewrite;
    protected $oldServer = array();

    function setUp()
    {
        // Тестируется также очистка от лишних "/"
        $_GET['path'] = "/news/archive/18/10//2005/list";
        $_POST['_TEST_FOO'] = "post_foo";
        $_COOKIE['_TEST_BAR'] = "cookie_bar";
        $requestparser = new mockrequestParser();
        $requestparser->expectOnce('parse', array($this->httprequest = new httpRequest($requestparser), $_GET['path']));
        $this->oldServer = $_SERVER;
    }

    public function tearDown()
    {
        $_SERVER = $this->oldServer;
        unset($_GET['path']);
        unset($_POST['_TEST_FOO']);
        unset($_COOKIE['_TEST_BAR']);
    }


    public function testIsSecure()
    {
        unset($_SERVER['HTTPS']);
        $this->assertFalse($this->httprequest->isSecure());

        $_SERVER['HTTPS'] = "off";
        $this->assertFalse($this->httprequest->isSecure());

        $_SERVER['HTTPS'] = "on";
        $this->assertTrue($this->httprequest->isSecure());
    }

    public function testGetMethod()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertEqual($this->httprequest->getMethod(), 'GET');
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertEqual($this->httprequest->getMethod(), 'POST');
    }

    public function testSectionAction()
    {
        $this->assertNull($this->httprequest->getSection());
        $this->assertNull($this->httprequest->getAction());

        $this->httprequest->setSection('foo');
        $this->httprequest->setAction('bar');

        $this->assertEqual($this->httprequest->getSection(), 'foo');
        $this->assertEqual($this->httprequest->getAction(), 'bar');

    }

    public function testGet()
    {
        $this->httprequest->setParam('param_foo', 'foo');
        $this->assertNull($this->httprequest->get('__NOT_EXISTS__'));
        $this->assertNull($this->httprequest->get('__NOT_EXISTS__', SC_PATH));

        $this->assertNull($this->httprequest->get('param_foo'));
        $this->assertEqual($this->httprequest->get('param_foo', SC_PATH), 'foo');

        $this->assertEqual($this->httprequest->get('_TEST_FOO'), 'post_foo');
        $this->assertEqual($this->httprequest->get('_TEST_BAR', SC_COOKIE), 'cookie_bar');

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertEqual($this->httprequest->get('REQUEST_METHOD', SC_SERVER), 'GET');

    }
}

?>