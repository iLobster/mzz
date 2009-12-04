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

    public function testRequirementsAsPartsOfAnotherToken()
    {
        $route = new requestRoute('somepath/:cat/:action/:foo', array('action' => 'list', 'foo' => 'bar'), array('cat' => '.+?', 'action' => '(?:list|view)', 'foo' => '(?:bar)'));
        $this->assertEqual(
            $route->match('somepath/world/europelist'),
            array('action' => 'list', 'cat' => 'world/europelist', 'foo' => 'bar')
        );

        $this->assertEqual(
            $route->match('somepath/world/europelist/list'),
            array('action' => 'list', 'cat' => 'world/europelist', 'foo' => 'bar')
        );

        $this->assertEqual(
            $route->match('somepath/world/europelistbar'),
            array('action' => 'list', 'cat' => 'world/europelistbar', 'foo' => 'bar')
        );

        $this->assertEqual(
            $route->match('somepath/world/europelist/view'),
            array('action' => 'view', 'cat' => 'world/europelist', 'foo' => 'bar')
        );

        $this->assertEqual(
            $route->match('somepath/world/europelistbarlistlistbar'),
            array('action' => 'list', 'cat' => 'world/europelistbarlistlistbar', 'foo' => 'bar')
        );

        $route = new requestRoute('somepath/:cat/:action/:foo', array('action' => 'list'), array('cat' => '.+?', 'action' => '(?:list)', 'foo' => '(?:bar)'));

        $this->assertFalse(
            $route->match('somepath/world/europelistbarlistlistbar')
        );
        $this->assertEqual(
            $route->match('somepath/world/europelistbarlistlist/bar'),
            array('action' => 'list', 'cat' => 'world/europelistbarlistlist', 'foo' => 'bar')
        );
        $this->assertEqual(
            $route->match('somepath/world/europelistbarlist/list/bar'),
            array('action' => 'list', 'cat' => 'world/europelistbarlist', 'foo' => 'bar')
        );

        $route = new requestRoute('somepath/:cat:action', array('action' => 'list'), array('cat' => '.+?', 'action' => '(?:list)'));


        $this->assertEqual(
            $route->match('somepath/world/europelist'),
            array('action' => 'list', 'cat' => 'world/europe')
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

    public function testAssembleWithLang()
    {
        $route = new requestRoute('somepath/:controller/{:id}-:action/:default', array('default' => 'default', 'action' => 'view'));
        $route->setHasLang(true);
        $this->assertEqual(
            $route->assemble(array('controller' => 'news', 'id' => 1, 'action' => 'list', 'default' => 'default')),
            'en/somepath/news/1-list'
        );
        $this->assertEqual(
            $route->assemble(array('controller' => 'news', 'id' => 1, 'action' => 'view', 'lang' => 'ru')),
            'ru/somepath/news/1-'
        );
        $this->assertEqual(
            $route->assemble(array('controller' => 'news', 'id' => 1, 'action' => 'view', 'lang' => '')),
            'somepath/news/1-'
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


    public function testRouteWithLang()
    {
        systemConfig::$i18n = 'en';
        $route = new requestRoute(':controller/:action', array('controller' => 'page', 'action' => 'list'));
        $route->setHasLang(true);
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
        $route->setHasLang(true);
        $this->assertEqual(
            $route->match(''),
            array('lang' => '')
        );

        $route = new requestRoute('somepath/:action', array('action' => 'list'));
        $route->setHasLang(true);
        $this->assertEqual(
            $route->match('somepath'),
            array('action' => 'list', 'lang' => '')
        );
        $this->assertEqual(
            $route->match('ru/somepath/list'),
            array('action' => 'list', 'lang' => 'ru')
        );
    }

    public function testRoutePrepend()
    {
        systemConfig::$i18n = 'en';
        $route_first = new requestRoute('somepath/:id', array('action' => 'list'), array('id' => '\d+'));
        $route_second = new requestRoute('test/:action', array('action' => 'view'));

        $route_second->prepend($route_first);

        $this->assertEqual(
            $route_second->match('somepath/5/test/view'),
            array('action' => 'view', 'action' => 'view', 'id' => '5')
        );

        $this->assertEqual(
            $route_second->match('somepath/5/test'),
            array('action' => 'view', 'action' => 'view', 'id' => '5')
        );

        $route_first->setHasLang(true);
        $route_second->setHasLang(true); // shouldn't add lang to that route

        $this->assertEqual(
            $route_second->match('zz/somepath/5/test/view'),
            array('action' => 'view', 'action' => 'view', 'id' => '5', 'lang' => 'zz')
        );

        $this->assertFalse(
            $route_second->match('zz/somepath/5/zz/test/view')
        );

        $this->assertEqual(
            $route_second->match('somepath/5/test/view'),
            array('action' => 'view', 'action' => 'view', 'id' => '5', 'lang' => '')
        );
    }

    public function testPartialAssemble()
    {
        systemConfig::$i18n = 'en';
        $route_first = new requestRoute('somepath/:id', array('action' => 'list'), array('id' => '\d+'));
        $route_second = new requestRoute('test/:action', array('action' => 'view'));


        $this->assertEqual(
            $route_first->assemble(array('id' => '5')),
            'somepath/5'
        );

        $this->assertEqual(
            $route_second->assemble(array('action' => 'view')),
            'test'
        );

        $route_second->prepend($route_first);


        $this->assertEqual(
            $route_second->assemble(array('action' => 'test', 'id' => '5')),
            'somepath/5/test/test'
        );

        $this->assertEqual(
            $route_second->assemble(array('action' => 'view',  'id' => '5')),
            'somepath/5/test'
        );

        $route_first->setHasLang(true);
        $route_second->setHasLang(true); // shouldn't add lang to that route
        $this->assertEqual(
            $route_second->assemble(array('action' => 'view',  'id' => '5')),
            'en/somepath/5/test'
        );
        $this->assertEqual(
            $route_second->assemble(array('action' => 'view',  'id' => '5', 'lang' => 'ru')),
            'ru/somepath/5/test'
        );
    }

    public function testSetPartial()
    {
        $route = new requestRoute('somepath/:name/:action', array());
        $this->assertFalse($route->isPartial());
        $route->setPartial(true);
        $this->assertTrue($route->isPartial());


        $route_first = new requestRoute('somepath/:id', array('action' => 'list'));
        $route_second = new requestRoute('test/:action', array('action' => 'view'));

        $this->assertFalse($route_first->isPartial());
        $this->assertFalse($route_second->isPartial());
        $route_second->prepend($route_first);

        $this->assertTrue($route_first->isPartial());
        $this->assertTrue($route_second->isPartial());
    }
}

?>