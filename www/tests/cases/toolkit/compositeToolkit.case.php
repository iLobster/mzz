<?php
fileLoader::load('toolkit/compositeToolkit');
fileLoader::load('toolkit');
fileLoader::load('cases/toolkit/firstToolkitStub.class');
fileLoader::load('cases/toolkit/secondToolkitStub.class');

class compositeToolkitTest extends unitTestCase
{
    private $registry;
    public function setUp()
    {
    }

    public function tearDown()
    {

    }

    public function testCompositeToolkit()
    {
        $toolkit = new compositeToolkit(new firstToolkitStub(), new secondToolkitStub());
        $this->assertIsA($toolkit->getToolkit("getFoo"), "firstToolkitStub");
        $this->assertIsA($toolkit->getToolkit("getBar"), "secondToolkitStub");
        $this->assertFalse($toolkit->getToolkit("getNonExists"));
    }


}

?>