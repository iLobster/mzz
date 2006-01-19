<?php
fileLoader::load('toolkit/systemToolkit');
fileLoader::load('toolkit');
class systemToolkitStub extends toolkit {
    function stub($param, $param_two) {
        return true;
    }
}

class systemToolkitTest extends unitTestCase
{
    private $toolkit;
    private $stubtoolkit;

    public function setUp()
    {
        $this->stubtoolkit = new SystemToolkitStub;
        $this->toolkit = systemToolkit::getInstance();
        $this->toolkit->getToolkit()->addToolkit($this->stubtoolkit);

    }

    public function tearDown()
    {

    }

    public function testSystemToolkit()
    {
        $this->assertEqual($this->toolkit->stub(null, null), true);
        //$this->assertIsA($toolkit->getToolkit("getBar"), "secondToolkitStub");
        //$this->assertFalse($toolkit->getToolkit("getNonExists"));
    }


}

?>