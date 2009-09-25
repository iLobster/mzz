<?php
fileLoader::load('service/arrayDataspace');

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

    public function testCount()
    {
        $item_one = "foo";
        $item_two = "bar";

        $this->assertEqual(count($this->dataspace), 0);
        $this->dataspace->set('foo', $item_one);
        $this->dataspace->set('bar', $item_two);
        $this->assertEqual(count($this->dataspace), 2);
    }

    public function testArrayDataspaceIterator()
    {
        $item_one = "fooval";
        $item_two = "barval";
        $item_three = false;

        $this->dataspace->set($key_one = 'foo', $item_one);
        $this->dataspace->set($key_two = 'bar', $item_two);
        $this->dataspace->set($key_three = 'bool', $item_three);

        $result = '';
        foreach ($this->dataspace as $key => $value) {
            $result .= $key . $value;
        }

        $this->assertEqual($result, $key_one . $item_one . $key_two . $item_two . $key_three);
    }

    public function testArrayDataspaceExists()
    {
        $this->assertFalse($this->dataspace->exists('_not_exists_'));
    }

    public function testArrayDataspaceImport()
    {
        $items = array(
            'foo' => 'foo',
            'bar' => 'bar',
            'test' => 'test');
        $this->dataspace->import($items);
        $this->assertEqual($this->dataspace->get('foo'), 'foo');
        $this->assertEqual($this->dataspace->get('bar'), 'bar');
        $this->assertEqual($this->dataspace->get('test'), 'test');
    }

    public function testArrayDataspaceExport()
    {
        $items = array(
            'foo' => 'foo',
            'bar' => 'bar',
            'test' => 'test');
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
        $methods = array(
            "set",
            "get",
            "exists");
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

    public function testIteration()
    {
        $items = array(
            'foo' => 'foo',
            'bar' => 'bar',
            'test' => 'test');
        $this->dataspace->import($items);

        foreach ($this->dataspace as $key => $val) {
            $this->assertEqual($val, $items[$key]);
        }

        $this->assertEqual($this->dataspace->first(), 'foo');
        $this->assertEqual($this->dataspace->last(), 'test');
    }
}

?>