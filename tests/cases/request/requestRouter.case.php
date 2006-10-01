<?php

fileLoader::load('request/requestRouter');
fileLoader::load('request/iRoute');

class stubRoute implements iRoute {
    public function match($path) {
    }
}
Mock::generate('stubRoute');

class requestRouterTest extends unitTestCase
{
    private $router;

    function setUp()
    {
        $this->router = new requestRouter();
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
        $routeSecond->setReturnValue('match', array('controller' => 'news', 'action' => 'view'));

        $this->router->addRoute('first', $routeFirst);
        $this->router->addRoute('second', $routeSecond);

        $this->router->route('path');
    }

    public function testRouteFirst()
    {
        $routeFirst = new mockstubRoute;
        $routeSecond = new mockstubRoute;


        $routeFirst->expectCallCount('match', 1);
        $routeSecond->expectCallCount('match', 1);

        $routeFirst->setReturnValue('match', array('controller' => 'news', 'action' => 'view'));
        $routeSecond->setReturnValue('match', false);

        $this->router->addRoute('first', $routeFirst);
        $this->router->addRoute('second', $routeSecond);

        $this->router->route('path');
    }

}

?>