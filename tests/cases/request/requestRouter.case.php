<?php

fileLoader::load('request/requestRouter');
fileLoader::load('request/iRoute');
fileLoader::load('request/httpRequest');

class stubRoute implements iRoute {
    public function match($path) {
    }
    public function setName($name) {
    }
    public function prepend(iRoute $route) {
    }

    public function setPartial($partial) {

    }

    public function isPartial() {
        return false;
    }
}
Mock::generate('stubRoute');
Mock::generate('httpRequest');

class requestRouterTest extends unitTestCase
{
    private $router;
    private $request;

    function setUp()
    {
        $this->router = new requestRouter($this->request = new mockhttpRequest);
    }

    public function tearDown()
    {
    }

    public function testAddRoute()
    {
        $route = new mockstubRoute;
        $this->router->addRoute('name', $route);
        $this->assertEqual($this->router->getRoute('name'), $route);
    }

    public function testAddException()
    {
        $name = 'name';
        try {
            $this->router->getRoute($name);
            $this->fail('Не было брошено исключение');
        } catch (Exception $e) {
            $this->assertPattern('/route with the name \'' . $name . '\'/i', $e->getMessage());
        }
    }

    public function testRouteSecond()
    {
        $routeFirst = new mockstubRoute;
        $routeSecond = new mockstubRoute;


        $routeFirst->expectCallCount('match', 0);
        $routeSecond->expectCallCount('match', 1);

        $routeFirst->setReturnValue('match', false);

        $result = array('module' => 'news', 'action' => 'view', 'someparam' => '1');
        $routeSecond->setReturnValue('match', $result);

        $this->router->addRoute('first', $routeFirst);
        $this->router->addRoute('second', $routeSecond);

        $this->request->expectOnce('setModule', array($result['module']));
        unset($result['module']);
        $this->request->expectOnce('setAction', array($result['action']));
        unset($result['action']);
        $this->request->expectOnce('setParams', array($result));
        $this->router->route('path');
    }

    public function testRouteFirst()
    {
        $routeFirst = new mockstubRoute;
        $routeSecond = new mockstubRoute;


        $routeFirst->expectCallCount('match', 1);
        $routeSecond->expectCallCount('match', 1);

        $result = array('module' => 'news', 'action' => 'view', 'someparam' => '1');
        $routeFirst->setReturnValue('match', $result);

        $routeSecond->setReturnValue('match', false);

        $this->router->addRoute('first', $routeFirst);
        $this->router->addRoute('second', $routeSecond);

        $this->request->expectOnce('setModule', array($result['module']));
        unset($result['module']);
        $this->request->expectOnce('setAction', array($result['action']));
        unset($result['action']);
        $this->request->expectOnce('setParams', array($result));
        $this->router->route('path');
    }

    public function testGetCurrentRoute()
    {
        $routeFirst = new mockstubRoute;
        $routeSecond = new mockstubRoute;

        $result = array('module' => 'news', 'action' => 'list');
        $routeFirst->setReturnValue('match', $result);
        $routeSecond->setReturnValue('match', false);

        $this->router->addRoute('first', $routeFirst);
        $this->router->addRoute('second', $routeSecond);
        $this->router->route('path');

        $this->assertEqual($this->router->getCurrentRoute(), $routeFirst);
    }

    public function testRouteNotFound()
    {
        $route = new mockstubRoute;
        $route->expectCallCount('match', 1);
        $route->setReturnValue('match', false);
        $this->router->addRoute('notMatch', $route);

        try {
            $this->router->route('path');
        } catch (Exception $e) {
            $this->assertPattern("/404/", $e->getMessage());
            $this->pass();
        }
    }

    public function testAddSecondSameNameRouter()
    {
        $route = new mockstubRoute;
        $this->router->addRoute('somename', $route);

        try {
            $this->router->addRoute('somename', $route);
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/somename.*already added/", $e->getMessage());
        } catch (Exception $e) {
            $this->fail('Не ожидаемый тип исключения');
        }
    }

    public function testGetAllRoutes()
    {
        $routeFirst = new mockstubRoute;
        $routeSecond = new mockstubRoute;

        $routes = array(
            'first' => $routeFirst,
            'second' => $routeSecond,
        );

        foreach ($routes as $name => $route) {
            $this->router->addRoute($name, $route);
        }

        $this->assertEqual($routes, $this->router->getRoutes());
    }

    public function testDefaultRoute()
    {
        $routeFirst = new mockstubRoute;
        $routeDefault = new mockstubRoute;
        $this->router->addRoute($name = 'first', $routeFirst);
        $this->router->addRoute('default', $routeDefault);

        $this->assertEqual($routeDefault, $this->router->getDefaultRoute());

        $this->router->setDefaultRoute($name);
        $this->assertEqual($routeFirst, $this->router->getDefaultRoute());
    }

    public function testRoutePrepend()
    {
        $routeFirst = new mockstubRoute;
        $routeSecond = new mockstubRoute;

        $routeFirst->expectCallCount('prepend', 0);
        $routeSecond->expectCallCount('prepend', 1);

        $result_first = array('action' => 'view');
        $routeFirst->setReturnValue('match', $result_first);

        $result_second = array('module' => 'news');
        $routeSecond->setReturnValue('match', $result_second);

        $result = $result_first + $result_second;
        $this->router->addRoute('second', $routeSecond);
        $this->router->prepend($routeFirst);

        $this->router->route('path');
    }
}

?>