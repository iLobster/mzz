<?php
fileLoader::load('controller/action');

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
        $this->assertEqual($this->action->getAction(), array("controller" => "firstController", "alias" => "jipAction"));

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

    public function testGetJipActions()
    {
        $jipActions = array(
        'jipAction' => array ('controller' => 'foo'),
        'editACL' => array('controller' => 'editACL', 'title' => 'Права доступа', 'icon' => '/templates/images/acl.gif'),
        );
        $this->assertEqual($this->action->getJipActions('firstActions'), $jipActions);

        $jipActions = array(
        'jipActionFull' => array ('controller' => 'bar', 'title' => 'someTitle', 'confirm' => 'confirm message'),
        'editACL' => array('controller' => 'editACL', 'title' => 'Права доступа',  'icon' => '/templates/images/acl.gif'),
        );

        $this->assertEqual($this->action->getJipActions('secondActions'), $jipActions);
    }

    public function testIsJip()
    {
        $this->action->setAction('firstAction');
        $this->assertFalse($this->action->isJip($this->action->getAction()));

        $this->action->setAction('jipAction');
        $this->assertTrue($this->action->isJip($this->action->getAction()));
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

    public function testGetActionName()
    {
        $this->action->setAction('firstAction');
        $this->assertEqual($this->action->getActionName(), 'firstAction');
        $this->assertEqual($this->action->getActionName(true), 'jipAction');
    }
}
?>