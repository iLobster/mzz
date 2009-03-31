<?php
fileLoader::load('core/action');

class actionTest extends unitTestCase
{
    private $action;

    public function __construct()
    {
    }

    public function setUp()
    {
        $this->action = new action("firstActions");
        $this->action->addPath(dirname(__FILE__) . '/fixture');
    }

    public function tearDown()
    {
    }

    public function testActionSetAndGet()
    {
        $this->assertEqual($this->action->getOptions('firstAction'), array("controller" => "firstController", 'jip' => '1', "alias" => "jipAction"));

        $this->assertEqual($this->action->getOptions('secondAction'), array("controller" => "secondController", "403handle" => 'none', 'admin' => '1'));
    }

    public function testGetClass()
    {
        $this->assertEqual($this->action->getClass('firstAction'), 'firstActions');
        $this->assertEqual($this->action->getClass('secondAction'), 'secondActions');
    }

    public function testGetAlias()
    {
        $this->assertEqual($this->action->getAlias('firstAction'), 'jipAction');
        $this->assertEqual($this->action->getAlias('secondAction'), 'secondAction');
    }

    public function testGetActions()
    {
        $this->assertEqual($this->action->getActions(), array (
            'firstActions' => array (
                'firstAction' => array ('controller' => 'firstController', 'jip' => '1', 'alias' => 'jipAction'),
                'jipAction' => array ('controller' => 'foo', 'jip' => '1'),
                'editACL' => array ('controller' => 'editACL', 'jip' => 1, 'icon' => '/templates/images/acl.gif', 'title' => '_ editACL')),
            'secondActions' => array (
                'secondAction' => array ('controller' => 'secondController', '403handle' => 'none', 'admin' => '1'),
                'jipActionFull' => array ( 'controller' => 'bar', 'jip' => '2', 'title' => 'someTitle', 'confirm' => 'confirm message'),
                'editACL' => array ( 'controller' => 'editACL', 'jip' => 1, 'icon' => '/templates/images/acl.gif', 'title' => '_ editACL')))
        );
    }

    public function testGetActionsClassFilter()
    {
        $this->assertEqual($this->action->getActions(array('class' => 'firstActions')), array (
            'firstAction' => array ('controller' => 'firstController', 'jip' => '1', 'alias' => 'jipAction'),
            'jipAction' => array ('controller' => 'foo', 'jip' => '1'),
            'editACL' => array ('controller' => 'editACL', 'jip' => 1, 'icon' => '/templates/images/acl.gif', 'title' => '_ editACL'))
        );
    }

    public function testGetActionsClassAndJipOrAclFilter()
    {
        $this->assertEqual($this->action->getActions(array('class' => 'secondActions', 'jip' => 1)), array (
            'editACL' => array ( 'controller' => 'editACL', 'jip' => 1, 'icon' => '/templates/images/acl.gif', 'title' => '_ editACL'))
        );

        $this->assertEqual($this->action->getActions(array('class' => 'secondActions', 'acl' => true)), array (
            'jipActionFull' => array ( 'controller' => 'bar', 'jip' => '2', 'title' => 'someTitle', 'confirm' => 'confirm message'),
            'editACL' => array ( 'controller' => 'editACL', 'jip' => 1, 'icon' => '/templates/images/acl.gif', 'title' => '_ editACL'))
        );
    }

    public function testGetActionsAclFilter()
    {
        $this->assertEqual($this->action->getActions(array('acl' => true)), array (
            'firstActions' => array (
                'jipAction' => array ('controller' => 'foo', 'jip' => '1'),
                'editACL' => array ('controller' => 'editACL', 'jip' => 1, 'icon' => '/templates/images/acl.gif', 'title' => '_ editACL')),
            'secondActions' => array (
                'jipActionFull' => array ( 'controller' => 'bar', 'jip' => '2', 'title' => 'someTitle', 'confirm' => 'confirm message'),
                'editACL' => array ( 'controller' => 'editACL', 'jip' => 1, 'icon' => '/templates/images/acl.gif', 'title' => '_ editACL')))
        );
    }

    public function testGetActionsJipFilter()
    {
        $this->assertEqual($this->action->getActions(array('jip' => 1)), array (
            'firstActions' => array (
                'firstAction' => array ('controller' => 'firstController', 'jip' => '1', 'alias' => 'jipAction'),
                'jipAction' => array ('controller' => 'foo', 'jip' => '1'),
                'editACL' => array ('controller' => 'editACL', 'jip' => 1, 'icon' => '/templates/images/acl.gif', 'title' => '_ editACL')),
            'secondActions' => array (
                'editACL' => array ( 'controller' => 'editACL', 'jip' => 1, 'icon' => '/templates/images/acl.gif', 'title' => '_ editACL')))
        );

        $this->assertEqual($this->action->getActions(array('jip' => 2)), array (
            'secondActions' => array (
                'jipActionFull' => array ( 'controller' => 'bar', 'jip' => '2', 'title' => 'someTitle', 'confirm' => 'confirm message')
                ))
        );
    }

    public function testGetActionsAdminFilter()
    {
        $this->assertEqual($this->action->getActions(array('admin' => true)), array (
            'secondActions' => array (
                'secondAction' => array ('controller' => 'secondController', '403handle' => 'none', 'admin' => '1')))
        );
    }

    public function testGetActionsNone()
    {
        $this->assertEqual($this->action->getActions(array('class' => 'unknownClass')), array());
        $this->assertEqual($this->action->getActions(array('class' => 'secondActions', 'jip' => 3)), array());
    }

    public function testIsJip()
    {
        $this->assertTrue($this->action->isJip('firstAction'));
        $this->assertFalse($this->action->isJip('secondAction'));
    }

}
?>