<?php

fileLoader::load('request/requestRouter');
fileLoader::load('request/iRoute');
fileLoader::load('request/httpRequest');

class stubRoute implements iRoute {
    public function match($path) {
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
            $this->fail('�� ���� ������� ����������');
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

        $result = array('controller' => 'news', 'action' => 'view');
        $routeSecond->setReturnValue('match', $result);

        $this->router->addRoute('first', $routeFirst);
        $this->router->addRoute('second', $routeSecond);

        $this->request->expectOnce('setParams', array($result));
        $this->router->route('path');
    }

    public function testRouteFirst()
    {
        $routeFirst = new mockstubRoute;
        $routeSecond = new mockstubRoute;


        $routeFirst->expectCallCount('match', 1);
        $routeSecond->expectCallCount('match', 1);

        $result = array('controller' => 'news', 'action' => 'list');
        $routeFirst->setReturnValue('match', $result);

        $routeSecond->setReturnValue('match', false);

        $this->router->addRoute('first', $routeFirst);
        $this->router->addRoute('second', $routeSecond);

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

        $this->request->expectOnce('setParams', array(array('section' => 'page', 'action' => 'view')));

        $this->router->route('path');
    }

}

?>