<?php

fileLoader::load('request/requestRoute');
fileLoader::load('request/requestHostnameRoute');


class requestHostnameRouteTest extends unitTestCase
{
    private $i18n_default;

    public function __construct()
    {
        $this->i18n_default = systemConfig::$i18nEnable;
    }

    public function setUp()
    {
        systemConfig::$i18nEnable = false;
    }

    public function tearDown()
    {
        systemConfig::$i18nEnable = $this->i18n_default;
    }

    public function testSimpleHostRoute()
    {
        $route = new requestHostnameRoute(':user.domain.com');
        $this->assertEqual(
            $route->match('admin.domain.com'),
            array('user' => 'admin')
        );
    }

    public function testHostnameAssemble()
    {
        $route = new requestHostnameRoute(':user.domain.com');
        $scheme = systemToolkit::getInstance()->getRequest()->getScheme();
        $this->assertEqual(
            $route->assemble(array('user' => 'admin')),
            $scheme . '://admin.domain.com'
        );

        $this->assertEqual(
            $route->assemble(array('user' => 'admin', 'scheme' => 'http')),
            'http://admin.domain.com'
        );

        $this->assertEqual(
            $route->assemble(array('user' => 'admin', 'scheme' => 'https')),
            'https://admin.domain.com'
        );
    }

    public function testSimpleRouteWithHostname()
    {
        $hostname_route = new requestHostnameRoute(':user.domain.com');
        $route = new requestRoute(':controller/:id/:action');
        $route->prepend($hostname_route);

        $this->assertEqual(
            $route->match('admin.domain.com/news/1/view', true),
            array('user' => 'admin', 'action' => 'view', 'controller' => 'news', 'id' => '1')
        );
    }

}

?>