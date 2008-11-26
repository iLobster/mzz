<?php

fileLoader::load('request/requestRoute');


class requestRouteTest extends unitTestCase
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

    public function testSimpleRoute()
    {
        $route = new requestRoute(':controller/:id/:action');
        $this->assertEqual(
            $route->match('news/1/view'),
            array('action' => 'view', 'controller' => 'news', 'id' => '1')
        );
    }

    public function testEscaped()
    {
        $route = new requestRoute('\:news/\::id/\:{:action}');
        $this->assertEqual(
            $route->match(':news/:1/:view'),
            array('action' => 'view', 'id' => '1')
        );
    }

    public function testRouteWithPath()
    {
        $route = new requestRoute('somepath/:controller/test/:id/:action');
        $this->assertEqual(
            $route->match('somepath/news/test/1/view'),
            array('action' => 'view', 'controller' => 'news', 'id' => '1')
        );
    }

    public function testRouteName()
    {
        $route = new requestRoute(':controller/:action');
        $route->setName($name = 'testRoute');
        $this->assertEqual($route->getName(), $name);
    }

    public function testRouteWithPathAndAny()
    {
        $route = new requestRoute('somepath/:controller/test/:id/:action/*');
        $this->assertEqual(
            $route->match('somepath/news/test/1/view/foo/bar/key/value'),
            array('action' => 'view', 'controller' => 'news', 'id' => '1', 'foo' => 'bar',
            'key' => 'value', '*' => 'foo/bar/key/value')
        );
    }

    public function testRouteWithPathAndDefault()
    {
        $route = new requestRoute('somepath/:controller/test/:id/:action', array('action' => 'view', 'id' => '1'));
        $this->assertEqual(
            $route->match('somepath/news/test'),
            array('action' => 'view', 'controller' => 'news', 'id' => '1')
        );

        $this->assertEqual(
            $route->match('somepath/news/test/3'),
            array('action' => 'view', 'controller' => 'news', 'id' => '3')
        );
    }

    public function testRouteWithPathAndRequirement()
    {
        $route = new requestRoute('somepath/:cat/:action', array('action' => 'list'), array('cat' => '.+?', 'action' => '(?:list)'));
        $this->assertEqual(
            $route->match('somepath/news/world/europe/moscow/list'),
            array('action' => 'list', 'cat' => 'news/world/europe/moscow')
        );
        $this->assertEqual(
            $route->match('somepath/news/world/europe/moscow'),
            array('action' => 'list', 'cat' => 'news/world/europe/moscow')
        );
    }


    public function testRouteWithoutSeparator()
    {
        $route = new requestRoute('somepath/:controller/{:id}-:action', array(), array('id' => '\d+', 'action' => '\w+'));
        $this->assertEqual(
            $route->match('somepath/news/1-view'),
            array('action' => 'view', 'controller' => 'news', 'id' => '1')
        );

    }

    public function testAssemble()
    {
        $route = new requestRoute('somepath/:controller/{:id}-:action/:default', array('default' => 'default'));
        $this->assertEqual(
            $route->assemble(array('controller' => 'news', 'id' => 1, 'action' => 'view')),
            'somepath/news/1-view'
        );
    }

    public function testAssembleWithLang()
    {
        $route = new requestRoute('somepath/:controller/{:id}-:action/:default', array('default' => 'default'));
        $route->enableLang();
        $this->assertEqual(
            $route->assemble(array('controller' => 'news', 'id' => 1, 'action' => 'view')),
            'en/somepath/news/1-view'
        );
        $this->assertEqual(
            $route->assemble(array('controller' => 'news', 'id' => 1, 'action' => 'view', 'lang' => 'ru')),
            'ru/somepath/news/1-view'
        );
    }

    public function testAssembleException()
    {
        $route = new requestRoute(':req_param');
        try {
            $route->assemble();
            $this->fail('no exception thrown?');
        } catch (Exception $e) {
            $this->assertPattern("/req_param/i", $e->getMessage());
            $this->pass();
        }
    }

    public function testRouteWithLang()
    {
        systemConfig::$i18n = 'en';
        $route = new requestRoute(':controller/:action', array('controller' => 'page', 'action' => 'list'));
        $route->enableLang();
        $this->assertEqual(
            $route->match('ru/news/view'),
            array('action' => 'view', 'controller' => 'news', 'lang' => 'ru')
        );
        $this->assertEqual(
            $route->match('news/view'),
            array('action' => 'view', 'controller' => 'news', 'lang' => '')
        );
        $this->assertEqual(
            $route->match('ru/rus/ru'),
            array('action' => 'ru', 'controller' => 'rus', 'lang' => 'ru')
        );
        $this->assertEqual(
            $route->match('ru'),
            array('action' => 'list', 'controller' => 'page', 'lang' => 'ru')
        );

        $route = new requestRoute('');
        $route->enableLang();
        $this->assertEqual(
            $route->match(''),
            array('lang' => '')
        );

        $route = new requestRoute('somepath/:action', array('action' => 'list'));
        $route->enableLang();
        $this->assertEqual(
            $route->match('somepath'),
            array('action' => 'list', 'lang' => '')
        );
        $this->assertEqual(
            $route->match('ru/somepath/list'),
            array('action' => 'list', 'lang' => 'ru')
        );
    }

    public function testGetDefaults()
    {
        $defaults = array(
            'action' => 'list',
            'name' => 'root',
        );

        $route = new requestRoute('somepath/:name/:action', $defaults);
        $this->assertEqual($route->getDefaults(), $defaults);
    }
}

?>