<?php
fileLoader::load('toolkit/compositeToolkit');
fileLoader::load('toolkit');
fileLoader::load('cases/toolkit/testToolkit.class');

Mock::generate('testToolkit');

class compositeToolkitTest extends unitTestCase
{
    private $mock_one;
    private $mock_two;
    private $toolkit;

    public function setUp()
    {
        $this->mock_one = new mocktestToolkit();
        $this->mock_two = new mocktestToolkit();
        $this->toolkit = new compositeToolkit($this->mock_one, $this->mock_two);
    }

    public function tearDown()
    {
    }

    public function testAddToolkit()
    {
        $this->mock_one->expectOnce('getToolkit', array('foo'));
        $this->mock_one->setReturnValue('getToolkit', 'bar');

        $this->assertEqual($this->toolkit->getToolkit('foo'), 'bar');
    }

    public function testToolkitWithObject()
    {
        $obj = new stdClass(); // std
        $this->mock_two->expectOnce('getToolkit', array('getStd'));
        $this->mock_two->setReturnValue('getToolkit', $obj);

        $this->mock_one->expectNever('getToolkit');

        $this->assertReference($obj, $this->toolkit->getToolkit('getStd'));
    }

    public function testToolkitWhile()
    {
        $this->mock_one->expectOnce('getToolkit', array('foo'));
        $this->mock_one->setReturnValue('getToolkit', false);

        $this->mock_two->expectOnce('getToolkit', array('foo'));
        $this->mock_two->setReturnValue('getToolkit', false);

        $this->assertFalse($this->toolkit->getToolkit('foo'));
    }

}

?>