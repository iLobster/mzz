<?php

fileLoader::load('request/url');
fileLoader::load('request/requestRouter');
fileLoader::load('request/requestRoute');

class urlTest extends unitTestCase
{
    private $SERVER;
    private $router;
    
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
    }
    
    public function setUp()
    {
        $this->SERVER = $_SERVER;
        $_SERVER['HTTPS'] = false;
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['HTTP_HOST'] = 'localhost';
    }

    public function tearDown()
    {
        $_SERVER = $this->SERVER;
    }
    
    public function testUrlRoute()
    {
        $url = new url('urlRoute');
        
        $url->setSection($section = 'foo');
        $url->setAction($action = 'bar');
        $url->addParam('param', $param = 'val1');
        $url->addParam('other', $other = 'val2');
        $this->assertEqual($url->get(), 'http://localhost/foo/val1/val2/bar');
    }
    
    public function testUrlHttpsWithoutParams()
    {
        $_SERVER['HTTPS'] = 'on';
        
        $url = new url('urlHttpsWithoutParams');
        
        $url->setSection($section = 'foo');
        $url->setAction($action = 'bar');
        
        $this->assertEqual($url->get(), 'https://localhost/foo/bar');
    }
   
    public function testOnlyUrlWithPort()
    {
        $_SERVER['SERVER_PORT'] = '8080'; // != 80

        $url = new url('default');
        
        $this->assertNotEqual($_SERVER['SERVER_PORT'], '80');
        $this->assertEqual($url->get(), 'http://localhost:8080');
    }
    
    public function testAddGetVariables()
    {
        $url = new url('default');
        $url->setGetParam('name', 'value');
        $url->setGetParam('name2', 'value2');
        $this->assertEqual($url->get(), 'http://localhost/?name=value&name2=value2');
    }
    
    public function testHttpsWithoutGet()
    {
        $route = new requestRoute(':section/:action');
        $this->router->addRoute('urlHttpsWithoutGet', $route);
        
        $url = new url('urlHttpsWithoutGet');
        
        $url->setSection($section = 'foo');
        $url->setAction($action = 'bar');
        $url->setGetParam('name', 'value');
        $url->setGetParam('name2', 'value2');
        $this->assertEqual($url->get(), 'http://localhost/foo/bar?name=value&name2=value2');
    }
}

?>