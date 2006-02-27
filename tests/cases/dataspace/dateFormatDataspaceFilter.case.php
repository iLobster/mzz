<?php

fileLoader::load('dataspace/dateFormatDataspaceFilter');
fileLoader::load('dataspace/arrayDataspace');

mock::generate('arrayDataspace');

class dateFormatDataspaceFilterTest extends unitTestCase
{
    private $mock;
    private $format;

    public function setUp()
    {
        $this->mock = new mockarrayDataspace();
        $this->format = 'd M Y / H:i:s';
    }

    public function testFormatSuccesfull()
    {
        $time = time();
        $this->mock->expectCallCount('get', 2);
        $this->mock->setReturnValue('get', $time);
        $dataspace = new dateFormatDataspaceFilter($this->mock, array('date'), $this->format);

        $this->assertEqual(date($this->format, $time), $dataspace->get('date'));
    }

    public function testFormatKeyNotInArray()
    {
        $value = 'somevalue';
        $this->mock->expectOnce('get', array('somefield'));
        $this->mock->setReturnValue('get', $value);
        $dataspace = new dateFormatDataspaceFilter($this->mock, array('date'), $this->format);

        $this->assertEqual($value, $dataspace->get('somefield'));
    }

    public function testMixedFields()
    {
        $time1 = time();
        $time2 = time() - 1000;
        $value = 'somevalue';
        $this->mock->expectCallCount('get', 5);
        $this->mock->setReturnValue('get', $time1, array('date'));
        $this->mock->setReturnValue('get', $time2, array('date2'));
        $this->mock->setReturnValue('get', $value, array('somefield'));
        $dataspace = new dateFormatDataspaceFilter($this->mock, array('date', 'date2'), $this->format);

        $this->assertIdentical($value, $dataspace->get('somefield'));
        $this->assertIdentical(date($this->format, $time1), $dataspace->get('date'));
        $this->assertIdentical(date($this->format, $time2), $dataspace->get('date2'));
    }
}

?>