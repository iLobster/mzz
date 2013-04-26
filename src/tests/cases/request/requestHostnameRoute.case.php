<?php

fileLoader::load('request/requestRoute');
fileLoader::load('request/requestHostnameRoute');


class requestHostnameRouteTest extends unitTestCase
{
    private $i18n_default;
    private $old_hostname = null;

    public function __construct()
    {
        $this->i18n_default = systemConfig::$i18nEnable;
    }

    public function setUp()
    {
        systemConfig::$i18nEnable = false;
        $this->old_hostname = isset($_SERVER['HOST_NAME']) ? $_SERVER['HOST_NAME'] : null;
        $_SERVER['HTTP_HOST'] = 'me.domain.com';
    }

    public function tearDown()
    {
        systemConfig::$i18nEnable = $this->i18n_default;
        $_SERVER['HTTP_HOST'] = $this->old_hostname;
    }

    public function testSimpleHostRoute()
    {
        $route = new requestHostnameRoute(':user.domain.com');
        $this->assertEqual(
            $route->match(''),
            array('user' => 'me')
        );
    }

    public function testHostnameAssemble()
    {
        $route = new requestHostnameRoute(':user.domain.com');
        $scheme = systemToolkit::getInstance()->getRequest()->getScheme();
        $this->assertEqual(
            $route->assemble(array('user' => 'me')),
            $scheme . '://me.domain.com'
        );

        $this->assertEqual(
            $route->assemble(array('user' => 'user', 'scheme' => 'http')),
            'http://user.domain.com'
        );

        $this->assertEqual(
            $route->assemble(array('user' => 'user', 'scheme' => 'https')),
            'https://user.domain.com'
        );
    }

    public function testSimpleRouteWithHostname()
    {
        $hostname_route = new requestHostnameRoute(':user.domain.com');
        $route = new requestRoute(':controller/:id/:action');
        $route->prepend($hostname_route);

        $this->assertEqual(
            $route->match('news/1/view'),
            array('action' => 'view', 'user' => 'me', 'controller' => 'news', 'id' => '1')
        );
    }

    public function testSimpleRouteWithHostnameAssemble()
    {
        $hostname_route = new requestHostnameRoute(':user.domain.com');
        $route = new requestRoute(':controller/:id/:action');
        $route->prepend($hostname_route);

        $this->assertEqual(
            $route->assemble(array('user' => 'admin', 'action' => 'view', 'controller' => 'news', 'id' => '1')),
            'http://admin.domain.com/news/1/view'
        );
    }

}

?>