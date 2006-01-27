<?php

fileLoader::load('frontcontroller/frontController');

fileLoader::load('request/httpRequest');
fileLoader::load('request/rewrite');

mock::generate('httpRequest');
mock::generate('rewrite');


class frontControllerTest extends unitTestCase
{
    private $frontController;
    private $oldRequest;
    private $toolkit;
    private $request;
    private $rewrite;

    public function setUp()
    {
        $this->frontController = new frontController();
        $this->toolkit = systemToolkit::getInstance();
        $this->request = new mockhttpRequest();
        $this->rewrite = new mockrewrite();
        $this->oldRequest = $this->toolkit->setRequest($this->request);
        $this->oldRewrite = $this->toolkit->setRewrite($this->rewrite);
    }

    public function tearDown()
    {
        $this->toolkit->setRequest($this->oldRequest);
        $this->toolkit->setRewrite($this->oldRewrite);
    }

    public function testFrontController()
    {
        $this->request->expectOnce('getSection', array());
        $this->request->setReturnValue('getSection', 'test');
        $this->request->expectOnce('getAction', array());
        $this->request->setReturnValue('getAction', 'bar');

        $this->assertEqual($this->frontController->getTemplate(), "act.test.bar.tpl");
    }

    public function testFrontControllerFalseRewriteTrue()
    {
        $this->request->expectCallCount('getSection', 2);
        $this->request->setReturnValue('getSection', 'test');
        $this->request->expectCallCount('getAction', 2);
        $this->request->setReturnValueAt(0, 'getAction', 'abc');
        $this->request->setReturnValueAt(1, 'getAction', 'foo');
        $this->request->expectOnce('get', array('path'));
        $this->request->setReturnValue('get', 'test.abc');
        $this->request->expectOnce('parse', array('test.foo'));

        $this->rewrite->expectOnce('loadRules', array('test'));
        $this->rewrite->expectOnce('process', array('test.abc'));
        $this->rewrite->setReturnValue('process', 'test.foo');

        $this->assertEqual($this->frontController->getTemplate(), "act.test.foo.tpl");

        $this->request->tally();
    }

    public function testFrontControllerFalseRewriteFalse()
    {
        $this->request->expectCallCount('getSection', 2);
        $this->request->setReturnValueAt(0, 'getSection', 'test');
        $this->request->setReturnValueAt(1, 'getSection', false);
        $this->request->expectCallCount('getAction', 2);
        $this->request->setReturnValueAt(0, 'getAction', 'abc');
        $this->request->setReturnValueAt(1, 'getAction', false);
        $this->request->expectOnce('get', array('path'));
        $this->request->setReturnValue('get', 'test.abc');
        $this->request->expectOnce('parse', array(false));

        $this->rewrite->expectOnce('process', array('test.abc'));
        $this->rewrite->setReturnValue('process', false);

        $this->assertFalse($this->frontController->getTemplate());

        $this->request->tally();
    }
}

?>