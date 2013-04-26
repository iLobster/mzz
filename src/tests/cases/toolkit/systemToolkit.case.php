<?php
fileLoader::load('toolkit/systemToolkit');
fileLoader::load('toolkit/compositeToolkit');
fileLoader::load('toolkit');
fileLoader::load('cases/toolkit/testToolkit.class');

Mock::generate('compositeToolkit');
Mock::generate('testToolkit');

class systemToolkitTest extends unitTestCase
{
    private $oldToolkit;
    private $toolkit;
    private $mockToolkit;

    public function setUp()
    {
        $this->mockToolkit = new mockcompositeToolkit();
        $this->toolkit = systemToolkit::getInstance();
        $this->oldToolkit = $this->toolkit->setToolkit($this->mockToolkit);
    }

    public function tearDown()
    {
        $this->toolkit->setToolkit($this->oldToolkit);

    }

    public function testToolkit()
    {
        $toolkit_mock = new mocktestToolkit();

        $this->mockToolkit->setReturnValue('getToolkit', $toolkit_mock);
        $this->mockToolkit->expectOnce('getToolkit', array('getFoo'));

        $toolkit_mock->expectOnce('getFoo', array('request')); // ->
        $toolkit_mock->setReturnValue('getFoo', 'response'); // <-

        $this->assertEqual($this->toolkit->getFoo('request'), 'response');
    }

    public function testAddToolkit()
    {
        $toolkit_mock = new mockCompositeToolkit();
        $this->mockToolkit->expectOnce('addToolkit', array($toolkit_mock));
        $this->toolkit->addToolkit($toolkit_mock);
    }

}

?>