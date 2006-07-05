<?php
fileLoader::load('action/action');

class actionTest extends unitTestCase
{
    private $action;

    public function __construct()
    {
    }

    public function setUp()
    {
        $this->action = new action("firstActions");
        $this->action->addPath(dirname(__FILE__) . '/fixtures');
    }

    public function tearDown()
    {
    }

    public function testActionSetAndGet()
    {
        $this->action->setAction('firstAction');
        $this->assertEqual($this->action->getAction(), array("controller" => "firstController"));

        $this->action->setAction('secondAction');
        $this->assertEqual($this->action->getAction(), array("controller" => "secondController"));
    }

    public function testActionGetWithoutSet()
    {
        try {
            $this->action->getAction();
            $this->fail('no exception thrown?');
        } catch (Exception $e) {
            $this->pass();
        }
    }

    public function testActionGetJipActions()
    {
        $jipActions = array(
        array ('controller' => 'foo', 'title' => NULL, 'confirm' => NULL),
        array ('controller' => 'bar', 'title' => 'someTitle', 'confirm' => 'confirm message')
        );

        $this->assertEqual($this->action->getJipActions(), $jipActions);
    }
}
?>