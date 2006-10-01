<?php

fileLoader::load('request/requestRoute');


class requestRouteTest extends unitTestCase
{
    function setUp()
    {
    }

    public function tearDown()
    {
    }

    public function testSampleRoute()
    {
        $route = new requestRoute(':controller/:id/:action');
        $this->assertEqual(
            $route->match('news/1/view'),
            array('action' => 'view', 'controller' => 'news', 'id' => '1')
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
        $route = new requestRoute('somepath/:controller/test/:id:action', array(), array('id' => '\d+', 'action' => '\w+'));
        $this->assertFalse(
            $route->match('somepath/news/test/string/'),
            array('action' => 'view', 'controller' => 'news', 'id' => '1')
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

}

?>