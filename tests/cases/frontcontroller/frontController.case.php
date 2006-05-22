<?php

fileLoader::load('frontcontroller/frontController');

fileLoader::load('request/httpRequest');
fileLoader::load('request/rewrite');
fileLoader::load('request/requestParser');
fileLoader::load('core/sectionMapper');

mock::generate('httpRequest');
mock::generate('Rewrite');
mock::generate('sectionMapper');

class frontControllerTest extends unitTestCase
{
    private $frontController;
    private $oldRequest;
    private $toolkit;
    private $request;
    private $rewrite;
    private $sectionMapper;
    private $oldsectionMapper;

    public function setUp()
    {

        $this->toolkit = systemToolkit::getInstance();

        $this->request = new mockhttpRequest();

        // Create Request, SectionMapper and set in toolkit
        $this->rewrite = new mockrewrite();
        $this->sectionMapper = new mocksectionMapper();
        $this->oldRewrite = $this->toolkit->setRewrite($this->rewrite);
        $this->oldsectionMapper = $this->toolkit->setSectionMapper($this->sectionMapper);

        $this->frontController = new frontController($this->request);
    }

    public function tearDown()
    {
        // Restore Rewrite, SectionMapper in toolkit
        $this->toolkit->setRewrite($this->oldRewrite);
        $this->toolkit->setSectionMapper($this->oldsectionMapper);
    }

    public function testFrontController()
    {
        $this->request->expectOnce('getSection', array());
        $this->request->setReturnValue('getSection', 'test');

        $this->request->expectOnce('getAction', array());
        $this->request->setReturnValue('getAction', 'bar');

        $this->sectionMapper->expectOnce('getTemplateName', array('test', 'bar'));
        $this->sectionMapper->setReturnValue('getTemplateName', 'act.test.bar.tpl');

        $this->assertEqual($this->frontController->getTemplate(), "act.test.bar.tpl");
    }

    public function testFrontControllerFalseRewriteTrue()
    {
        $this->request->expectCallCount('getSection', 3);
        $this->request->setReturnValue('getSection', 'test');
        $this->request->expectCallCount('getAction', 2);
        $this->request->setReturnValueAt(0, 'getAction', 'abc');
        $this->request->setReturnValueAt(1, 'getAction', 'foo');
        $this->request->setReturnValueAt(2, 'getAction', 'foo');
        $this->request->expectOnce('get', array('path'));
        $this->request->setReturnValue('get', 'test.abc');
        $this->request->expectOnce('import', array('test.foo'));

        $this->rewrite->expectOnce('loadRules', array('test'));
        $this->rewrite->expectOnce('process', array('test.abc'));
        $this->rewrite->setReturnValue('process', 'test.foo');

        $this->sectionMapper->expectCallCount('getTemplateName', 2);
        $this->sectionMapper->setReturnValueAt(0, 'getTemplateName', false);
        $this->sectionMapper->setReturnValueAt(1, 'getTemplateName', 'act.test.foo.tpl');

        $this->assertEqual($this->frontController->getTemplate(), "act.test.foo.tpl");

        $this->request->tally();
    }

    public function testFrontControllerFalseRewriteFalse()
    {
        $this->request->expectCallCount('getSection', 3);
        $this->request->setReturnValueAt(0, 'getSection', 'test');
        $this->request->setReturnValueAt(1, 'getSection', false);
        $this->request->setReturnValueAt(2, 'getSection', false);
        $this->request->expectCallCount('getAction', 2);
        $this->request->setReturnValueAt(0, 'getAction', 'abc');
        $this->request->setReturnValueAt(1, 'getAction', false);
        $this->request->expectOnce('get', array('path'));
        $this->request->setReturnValue('get', 'test.abc');
        $this->request->expectOnce('import', array(false));

        $this->sectionMapper->expectCallCount('getTemplateName', 2);
        $this->sectionMapper->setReturnValueAt(0, 'getTemplateName', false);
        $this->sectionMapper->setReturnValueAt(1, 'getTemplateName', 'act.notFound.view.tpl');

        $this->rewrite->expectOnce('process', array('test.abc'));
        $this->rewrite->setReturnValue('process', false);

        $this->assertEqual($this->frontController->getTemplate(), 'act.notFound.view.tpl');

        $this->request->tally();
    }
}

?>