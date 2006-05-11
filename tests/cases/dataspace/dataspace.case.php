<?php
fileLoader::load('dataspace/arrayDataspace');

class arrayDataspaceTest extends unitTestCase
{
    private $dataspace;
    public function setUp()
    {
        $this->dataspace = new arrayDataspace(array());
    }


    public function testArrayDataspace()
    {
        $item_one = "foo";
        $item_two = "bar";

        $this->dataspace->set('foo', $item_one);
        $this->dataspace->set('bar', $item_two);

        $this->assertEqual($this->dataspace->get('foo'), $item_one);
        $this->assertEqual($this->dataspace->get('bar'), $item_two);
    }

    public function testArrayDataspaceExists()
    {
        $this->assertFalse($this->dataspace->exists('_not_exists_'));
    }

    public function testArrayDataspaceImport()
    {
        $items = array('foo' => 'foo', 'bar' => 'bar', 'test' => 'test');
        $this->dataspace->import($items);
        $this->assertEqual($this->dataspace->get('foo'), 'foo');
        $this->assertEqual($this->dataspace->get('bar'), 'bar');
        $this->assertEqual($this->dataspace->get('test'), 'test');
    }

    public function testArrayDataspaceExport()
    {
        $items = array('foo' => 'foo', 'bar' => 'bar', 'test' => 'test');
        $this->dataspace->import($items);
        $this->assertEqual($this->dataspace->export(), $items);
    }

    public function testArrayDataspaceDelete()
    {
        $item = "foo";
        $item_two = "bar";

        $this->dataspace->set('foo', $item);

        $this->assertTrue($this->dataspace->exists('foo'));
        $this->dataspace->delete('foo');

        $this->assertFalse($this->dataspace->exists('foo'));
    }

    public function testArrayDataspaceExceptions()
    {
        $methods = array("set", "get", "exists");
        foreach ($methods as $method) {
            try {
                $this->dataspace->$method(array(), false);
                $this->fail('no exception thrown?');
            } catch (Exception $e) {
                $this->pass();
            }
        }
    }
    
    public function testClear()
    {
        $item_one = "foo";
        $this->dataspace->set('foo', $item_one);
        $this->assertEqual($this->dataspace->get('foo'), $item_one);
        
        $this->dataspace->clear();
        
        $this->assertFalse($this->dataspace->exists('foo'));
        $this->assertNull($this->dataspace->get('foo'));
    }

}

?>