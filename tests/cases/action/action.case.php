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

    public function testActionSetUnknownAction()
    {
        try {
            $this->action->setAction('_unknown_action_');
            $this->fail('no exception thrown?');
        } catch (Exception $e) {
            $this->assertPattern("/Действие \"_unknown_action_\" не найдено/i", $e->getMessage());
            $this->pass();
        }

    }

    public function testActionGetWithoutSet()
    {
        try {
            $this->action->getAction();
            $this->fail('no exception thrown?');
        } catch (Exception $e) {
            $this->assertPattern("/Action не установлен/i", $e->getMessage());
            $this->pass();
        }
    }

    public function testActionGetJipActions()
    {
        $jipActions = array(
        'jipAction' => array ('controller' => 'foo', 'title' => NULL, 'confirm' => NULL)
        );
        $this->assertEqual($this->action->getJipActions('firstActions'), $jipActions);

        $jipActions = array(
        'jipActionFull' => array ('controller' => 'bar', 'title' => 'someTitle', 'confirm' => 'confirm message')
        );
        $this->assertEqual($this->action->getJipActions('secondActions'), $jipActions);
    }

    public function testActionGetJipActionsException()
    {
        try {
            $this->action->getJipActions('_unknown_type_');
            $this->fail('no exception thrown?');
        } catch (Exception $e) {
            $this->assertPattern("/Тип \"_unknown_type_\" у модуля/i", $e->getMessage());
            $this->pass();
        }
    }
}
?>