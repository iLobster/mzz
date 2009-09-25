<?php

fileLoader::load('request/requestRoute');
fileLoader::load('request/requestHostnameRoute');


class requestRouteTest extends unitTestCase
{
    public function __construct()
    {
    }

    public function setUp()
    {
    }

    public function tearDown()
    {
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
        $this->assertEqual(
            $route->assemble(array('controller' => 'news', 'id' => 1, 'action' => 'view', 'default' => 'default')),
            'somepath/news/1-view'
        );
        $this->assertEqual(
            $route->assemble(array('controller' => 'news', 'id' => 1, 'action' => 'view', 'default' => 'not_default')),
            'somepath/news/1-view/not_default'
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

    public function testGetDefaults()
    {
        $defaults = array(
            'action' => 'list',
            'name' => 'root',
        );

        $route = new requestRoute('somepath/:name/:action', $defaults);
        $this->assertEqual($route->getDefaults(), $defaults);
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
    }

}

?>