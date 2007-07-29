<?php

fileLoader::load('request/url');
fileLoader::load('request/requestRouter');
fileLoader::load('request/requestRoute');

class urlTest extends unitTestCase
{
    private $SERVER;
    private $request;
    private $router;
    private $toolkit;

    public function __construct()
    {
        $toolkit = systemToolkit::getInstance();
        $this->router = $toolkit->getRouter();

        $route = new requestRoute('');
        $this->router->addRoute('default', $route);

        $route = new requestRoute(':section/:action');
        $this->router->addRoute('urlHttpsWithoutParams', $route);

        $route = new requestRoute(':section/:param/:other/:action');
        $this->router->addRoute('urlRoute', $route);

        $this->toolkit = systemToolkit::getInstance();
    }

    public function setUp()
    {
        $this->SERVER = $_SERVER;
        $_SERVER['HTTPS'] = false;
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $this->request = $this->toolkit->setRequest(new HttpRequest());
    }

    public function tearDown()
    {
        $_SERVER = $this->SERVER;
        $this->toolkit->setRequest($this->request);
    }

    public function testUrlRoute()
    {
        $url = new url('urlRoute');

        $url->setSection($section = 'foo');
        $url->setAction($action = 'bar');
        $url->add('param', $param = 'val1');
        $url->add('other', $other = 'val2');
        $this->assertEqual($url->get(), 'http://localhost' . SITE_PATH . '/foo/val1/val2/bar');
    }

    public function testUrlHttpsWithoutParams()
    {
        $_SERVER['HTTPS'] = 'on';
        $_SERVER['SERVER_PORT'] = 443;
        $this->toolkit->getRequest()->refresh();
        $url = new url('urlHttpsWithoutParams');

        $url->setSection($section = 'foo');
        $url->add('action', $action = 'bar');

        $this->assertEqual($url->get(), 'https://localhost'. SITE_PATH . '/foo/bar');
    }

    public function testOnlyUrlWithPort()
    {
        $_SERVER['SERVER_PORT'] = '8080'; // != 80
        $this->toolkit->getRequest()->refresh();

        $url = new url('default');

        $this->assertNotEqual($_SERVER['SERVER_PORT'], '80');
        $this->assertEqual($url->get(), 'http://localhost:8080' . SITE_PATH);
    }

    public function testAddGetVariables()
    {
        $url = new url('default');
        $url->add('name', 'value', true);
        $url->add('name2', 'value2', true);
        $this->assertEqual($url->get(), 'http://localhost' . SITE_PATH .'/?name=value&name2=value2');
    }

    public function testHttpsWithoutGet()
    {
        $route = new requestRoute(':section/:action');
        $this->router->addRoute('urlHttpsWithoutGet', $route);

        $url = new url('urlHttpsWithoutGet');

        $url->setSection($section = 'foo');
        $url->add('action', $action = 'bar');
        $url->add('name', 'value', true);
        $url->add('name2', 'value2', true);
        $this->assertEqual($url->get(), 'http://localhost' . SITE_PATH . '/foo/bar?name=value&name2=value2');
    }
}

?>