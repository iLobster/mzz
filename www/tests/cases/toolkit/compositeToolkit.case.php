<?php
fileLoader::load('toolkit/iToolkit');
fileLoader::load('toolkit/compositeToolkit');
fileLoader::load('toolkit');

class firstToolkitStub extends toolkit {
    private $param = "foo";
    function getFoo() {
        return $this->param;
    }
    function setFoo($param) {
        $this->param = $param;
    }
}
class secondToolkitStub extends toolkit {
    private $param = "bar";
    function getBar() {
        return $this->param;
    }
    function setBar($param) {
        $this->param = $param;
    }
}

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
        $this->assertEqual($toolkit->getFoo(), "foo");
        $this->assertEqual($toolkit->getBar(), "bar");
        $foo = "foo2";
        $bar = "bar2";
        $toolkit->setFoo($foo);
        $toolkit->setBar($bar);
        $this->assertEqual($toolkit->getFoo(), $foo);
        $this->assertEqual($toolkit->getBar(), $bar);
    }


}

?>