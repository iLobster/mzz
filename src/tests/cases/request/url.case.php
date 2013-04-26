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
    private $i18n_default;

    public function __construct()
    {
        $this->toolkit = systemToolkit::getInstance();
        $this->i18n_default = systemConfig::$i18n;
        $this->toolkit->setLocale();
        systemConfig::$i18nEnable = false;

        $this->router = $this->toolkit->getRouter();

        $route = new requestRoute('');
        $this->router->addRoute('default', $route);

        $route = new requestRoute(':module/:action');
        $this->router->addRoute('urlHttpsWithoutParams', $route);

        $route = new requestRoute(':module/:param/:other/:action');
        $this->router->addRoute('urlRoute', $route);
    }

    public function setUp()
    {
        $this->SERVER = $_SERVER;
        $_SERVER['HTTPS'] = false;
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['HTTP_HOST'] = null;
        $this->request = $this->toolkit->setRequest(new HttpRequest());

        systemConfig::$i18nEnable = false;
    }

    public function tearDown()
    {
        $_SERVER = $this->SERVER;
        $this->toolkit->setRequest($this->request);

        systemConfig::$i18nEnable = $this->i18n_default;
    }

    public function testUrlRoute()
    {
        $url = new url('urlRoute');

        $url->setModule($module = 'foo');
        $url->setAction($action = 'bar');
        $url->add('param', $param = 'val1');
        $url->add('other', $other = 'val2');
        $this->assertEqual($url->get(), 'http://localhost' . SITE_PATH . '/foo/val1/val2/bar');
    }

    public function testWithoutAddress()
    {
        $url = new url('default');
        $url->disableAddress();
        $this->assertEqual($url->get(), SITE_PATH);
    }

    public function testUrlHttpsWithoutParams()
    {
        $_SERVER['HTTPS'] = 'on';
        $_SERVER['SERVER_PORT'] = 443;
        $this->toolkit->getRequest()->refresh();
        $url = new url('urlHttpsWithoutParams');

        $url->setModule($module = 'foo');
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
        $this->assertEqual($url->get(), $_url = 'http://localhost' . SITE_PATH);
        $url->add('name', 'value', true);
        $this->assertEqual($url->get(), $_url = $_url .'/?name=value');
        $url->add('name2', 'value2', true);
        $this->assertEqual($url->get(), $_url = $_url .'&name2=value2');
    }

    public function testHttpsWithoutGet()
    {
        $route = new requestRoute(':module/:action');
        $this->router->addRoute('urlHttpsWithoutGet', $route);

        $url = new url('urlHttpsWithoutGet');

        $url->setModule($module = 'foo');
        $url->add('action', $action = 'bar');
        $url->add('name', 'value', true);
        $url->add('name2', 'value2', true);
        $this->assertEqual($url->get(), 'http://localhost' . SITE_PATH . '/foo/bar?name=value&name2=value2');
    }

    public function testAnchor()
    {
        $url = new url('urlHttpsWithoutParams');
        $url->setModule($module = 'foo');
        $url->setAction($action = 'bar');
        $url->add('#', 'anchor');
        $this->assertEqual($url->get(), 'http://localhost' . SITE_PATH . '/foo/bar#anchor');

        $url = new url('default');
        $url->add('#', 'anchor');
        $this->assertEqual($url->get(), 'http://localhost' . SITE_PATH . '/#anchor');
    }
}

?>