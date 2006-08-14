<?php

fileLoader::load('request/url');

class urlTest extends unitTestCase
{
    private $server_vars;
    private $url;

    function setUp()
    {
        $this->server_vars = $_SERVER;
        $_SERVER['HTTPS'] = false;
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $this->url = new url;
    }

    public function tearDown()
    {
        $_SERVER = $this->server_vars;
    }

    public function testUrlFull()
    {
        $section = 'foo';
        $action = 'bar';
        $param1 = 'val1';
        $param2 = 'val2';
        $this->url->setSection($section);
        $this->url->setAction($action);
        $this->url->addParam($param1);
        $this->url->addParam($param2);
        $this->assertEqual($this->url->get(), 'http://localhost/foo/val1/val2/bar');
    }

    public function testAddEmptyParam()
    {
        $section = 'foo';
        $action = 'bar';
        $this->url->setSection($section);
        $this->url->setAction($action);
        $this->url->addParam(null);
        $this->url->addParam('');
        $this->url->addParam(null);
        $this->assertEqual($this->url->get(), 'http://localhost/foo/bar');
    }

    public function testUrlHttpsWithoutParams()
    {
        $_SERVER['HTTPS'] = 'on';

        $section = 'foo';
        $action = 'bar';
        $this->url->setSection($section);
        $this->url->setAction($action);
        $this->assertEqual($this->url->get(), 'https://localhost/foo/bar');
    }

    public function testOnlyUrlWithPort()
    {
        $_SERVER['SERVER_PORT'] = '8080'; // != 80

        $this->assertNotEqual($_SERVER['SERVER_PORT'], '80');
        $this->assertEqual($this->url->get(), 'http://localhost:8080');
    }

    public function testUrlWithSection()
    {
        $section = 'foo';
        $this->url->setSection($section);
        $this->assertEqual($this->url->get(), 'http://localhost/foo');
    }

    public function testUrlWithoutAction()
    {
        $section = 'foo';
        $param1 = 'val1';
        $param2 = 'val2';
        $this->url->setSection($section);
        $this->url->addParam($param1);
        $this->url->addParam($param2);
        $this->assertEqual($this->url->get(), 'http://localhost/foo/val1/val2');
    }
}

?>