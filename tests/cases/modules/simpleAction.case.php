<?php
class simpleActionTest extends unitTestCase
{

    public function testGetMainParams()
    {
        $controller = 'controller';
        $moduleName = 'foo';
        $className = 'bar';
        $actionName = 'action';
        $action = new simpleAction($actionName, $moduleName, $className, $controller);

        $this->assertEqual($action->getName(), $actionName);
        $this->assertEqual($action->getModuleName(), $moduleName);
        $this->assertEqual($action->getClassName(), $className);
        $this->assertEqual($action->getControllerName(), $controller);
    }

    public function testGetActiveTemplate()
    {
        $controller = 'test';
        $data = array(
            'controller' => 'test'
        );
        $action = new simpleAction('action', 'foo', 'bar', $controller, $data);
        $this->assertEqual($action->getActiveTemplate(), simpleAction::DEFAULT_ACTIVE_TPL);

        $controller = 'test';
        $data = array(
            'main' => 'foobar'
        );
        $action = new simpleAction('action', 'foo', 'bar', $controller, $data);
        $this->assertEqual($action->getActiveTemplate(), $data['main']);
    }
}
?>