<?php

fileLoader::load('request/url');
fileLoader::load('request/requestRouter');
fileLoader::load('request/requestRoute');

class urlTest extends unitTestCase
{
    private $SERVER;
    private $url;

    function setUp()
    {
        $this->SERVER = $_SERVER;
        $_SERVER['HTTPS'] = false;
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $this->url = new url;
    }

    public function tearDown()
    {
        $_SERVER = $this->SERVER;
    }

    public function testUrlFull()
    {
        $section = 'foo';
        $action = 'bar';
        $param1 = 'val1';
        $param2 = 'val2';
        $this->url->setSection($section);
        $this->url->setAction($action);
        $this->url->addParam('param1', $param1);
        $this->url->addParam('param2', $param2);
        $this->assertEqual($this->url->get(), 'http://localhost/foo/val1/val2/bar');
    }

    public function testAddEmptyParam()
    {
        $section = 'foo';
        $action = 'bar';
        $this->url->setSection($section);
        $this->url->setAction($action);
        $this->url->addParam('param1', null);
        $this->url->addParam('param2', '');
        $this->url->addParam('param3', null);
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
        $this->url->addParam('param1', $param1);
        $this->url->addParam('param2', $param2);
        $this->assertEqual($this->url->get(), 'http://localhost/foo/val1/val2');
    }

    public function testUrlWithNoSection()
    {
        $this->url->setSection('');
        $this->url->addParam('param', 'foo');
        $this->assertEqual($this->url->get(), 'http://localhost/foo');
    }

    public function testUrlWithRoute()
    {
        $route = new requestRoute('path/:section/:page-:place/:action');
        $router = new requestRouter(new stdClass());
        $router->addRoute('urlRoute', $route);

        $this->url->setSection('demo');
        $this->url->setAction('view');
        $this->url->addParam('page', '3');
        $this->url->addParam('place', 'current');
        $this->assertEqual($this->url->get(), 'http://localhost/demo/3/current/view');

        $this->url->setRoute($router->getRoute('urlRoute'));
        $this->assertEqual($this->url->get(), 'http://localhost/path/demo/3-current/view');

        // Test auto-delete route after call get()
        $this->assertEqual($this->url->get(), 'http://localhost/demo/3/current/view');

        $this->url->setRoute($router->getRoute('urlRoute'));
        $this->url->addParam('section', 'news');
        $this->url->addParam('action', 'list');
        $this->assertEqual($this->url->get(), 'http://localhost/path/news/3-current/list');
    }
    
    public function testAddGetVariables()
    {
        $this->url->setGetParam('name', 'value');
        $this->url->setGetParam('name2', 'value2');
        $this->assertEqual($this->url->get(), 'http://localhost/?name=value&amp;name2=value2');
    }

    public function testUrlEncode()
    {
        $this->url->setGetParam('<b>', '�������');
        $this->assertEqual($this->url->get(), 'http://localhost/?%3Cb%3E=%F0%F3%F1%F1%EA%E8%E9');

        $this->url->setSection('<������>');
        $this->url->setAction('<��������>');
        $this->url->addParam('test', '<��������>');

        $this->assertEqual($this->url->get(), 'http://localhost/%3C%F1%E5%EA%F6%E8%FF%3E/%3C%EF%E0%F0%E0%EC%E5%F2%F0%3E/%3C%E4%E5%E9%F1%F2%E2%E8%E5%3E?%3Cb%3E=%F0%F3%F1%F1%EA%E8%E9');
    }

    public function testUrlEncodeWithRoute()
    {
        $route = new requestRoute(':section/:page/:action');
        $router = new requestRouter(new stdClass());
        $router->addRoute('urlRoute', $route);

        $this->url->setSection('<������>');
        $this->url->setAction('<��������>');
        $this->url->addParam('page', '<��������>');
        $this->url->setRoute($router->getRoute('urlRoute'));

        $this->assertEqual($this->url->get(), 'http://localhost/%3C%F1%E5%EA%F6%E8%FF%3E/%3C%EF%E0%F0%E0%EC%E5%F2%F0%3E/%3C%E4%E5%E9%F1%F2%E2%E8%E5%3E');
    }
}

?>