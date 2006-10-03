<?php

fileLoader::load('frontcontroller/frontController');

fileLoader::load('request/httpRequest');
fileLoader::load('core/sectionMapper');

mock::generate('httpRequest');
mock::generate('sectionMapper');

class frontControllerTest extends unitTestCase
{
    private $frontController;
    private $oldRequest;
    private $toolkit;
    private $request;
    private $sectionMapper;
    private $oldsectionMapper;

    public function setUp()
    {

        $this->toolkit = systemToolkit::getInstance();
        $this->request = new mockhttpRequest();

        // Create Request, SectionMapper and set in toolkit
        $this->sectionMapper = new mocksectionMapper();
        $this->oldsectionMapper = $this->toolkit->setSectionMapper($this->sectionMapper);

        $this->frontController = new frontController($this->request);
    }

    public function tearDown()
    {
        // Restore SectionMapper in toolkit
        $this->toolkit->setSectionMapper($this->oldsectionMapper);
    }

    public function testFrontController()
    {
        $this->request->expectOnce('getSection', array());
        $this->request->setReturnValue('getSection', 'test');

        $this->request->expectOnce('get', array('action', '*', '*'));
        $this->request->setReturnValue('get', 'bar', array('action', '*', '*'));

        $this->sectionMapper->expectOnce('getTemplateName', array('test', 'bar'));
        $this->sectionMapper->setReturnValue('getTemplateName', 'act.test.bar.tpl');

        $this->assertEqual($this->frontController->getTemplate(), "act.test.bar.tpl");
    }

}

?>