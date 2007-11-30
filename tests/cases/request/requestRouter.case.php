<?php

fileLoader::load('request/requestRouter');
fileLoader::load('request/iRoute');
fileLoader::load('request/httpRequest');

class stubRoute implements iRoute {
    public function match($path) {
    }
    public function setName($name) {
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
            $this->assertPattern('/route with name \'' . $name . '\'/i', $e->getMessage());
        }
    }

    public function testRouteSecond()
    {
        $routeFirst = new mockstubRoute;
        $routeSecond = new mockstubRoute;


        $routeFirst->expectCallCount('match', 0);
        $routeSecond->expectCallCount('match', 1);

        $routeFirst->setReturnValue('match', false);

        $result = array('section' => 'news', 'action' => 'view', 'someparam' => '1');
        $routeSecond->setReturnValue('match', $result);

        $this->router->addRoute('first', $routeFirst);
        $this->router->addRoute('second', $routeSecond);

        $this->request->expectOnce('setSection', array($result['section']));
        unset($result['section']);
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

        $result = array('section' => 'news', 'action' => 'view', 'someparam' => '1');
        $routeFirst->setReturnValue('match', $result);

        $routeSecond->setReturnValue('match', false);

        $this->router->addRoute('first', $routeFirst);
        $this->router->addRoute('second', $routeSecond);

        $this->request->expectOnce('setSection', array($result['section']));
        unset($result['section']);
        $this->request->expectOnce('setAction', array($result['action']));
        unset($result['action']);
        $this->request->expectOnce('setParams', array($result));
        $this->router->route('path');
    }

    public function testGetCurrentRoute()
    {
        $routeFirst = new mockstubRoute;
        $routeSecond = new mockstubRoute;

        $result = array('controller' => 'news', 'action' => 'list');
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
            $this->assertPattern("/somename.*уже добавлен/", $e->getMessage());
        } catch (Exception $e) {
            $this->fail('Не ожидаемый тип исключения');
        }
    }

}

?>