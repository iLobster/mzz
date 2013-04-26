<?php
class simpleModuleTest extends unitTestCase
{
    protected $module;

    public function __construct()
    {
        $this->module = systemToolkit::getInstance()->getModule('news');
    }

    public function testGetMapper()
    {
        $mapper = $this->module->getMapper('news');
        $this->assertIsA($mapper, 'newsMapper');
    }

    public function testGetNotExistMapper()
    {
        try {
            $mapper = $this->module->getMapper('not-exist');
            $this->fail('mzzUndefinedModuleClassException exception expected');
        } catch (mzzUndefinedModuleClassException $e) {
        }
    }

    public function testGetActions()
    {
        $actions = $this->module->getActions();

        $newsActions = array();
        $newsActionsData = include fileLoader::resolve('modules/news/actions/news');
        foreach ($newsActionsData as $actionName => $actionData) {
            $controllerName = $actionData['controller'];
            unset($actionData['controller']);
            $newsActions[$actionName] = new simpleAction($actionName, 'news', 'news', $controllerName, $actionData);
        }


        $newsFolderActions = array();
        $newsFolderActionsData = include fileLoader::resolve('modules/news/actions/newsFolder');
        foreach ($newsFolderActionsData as $actionName => $actionData) {
            $controllerName = $actionData['controller'];
            unset($actionData['controller']);
            $newsFolderActions[$actionName] = new simpleAction($actionName, 'news', 'newsFolder', $controllerName, $actionData);
        }

        $newsModuleActions = array_merge($newsActions, $newsFolderActions);
        $this->assertEqual($actions, $newsModuleActions);

        $onlyNewsActions = $this->module->getClassActions('news');
        $this->assertEqual($onlyNewsActions, $newsActions);
    }
}
?>