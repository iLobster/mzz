<?php

fileLoader::load('dataspace/changeableDataspaceFilter');
fileLoader::load('dataspace/iValueFilter');

mock::generate('iValueFilter',  'mockValueFilter');

class changeableDataspaceFilterTest extends unitTestCase
{
    private $mock;
    private $dataspace;
    private $readFilter;
    private $writeFilter;

    public function setUp()
    {
        $this->readFilter = new mockValueFilter();
        $this->writeFilter = new mockValueFilter();
        $this->dataspace = new changeableDataspaceFilter(new arrayDataspace(array('key1' => 'value1', 'key2' => 'value2')));
        $this->dataspace->addReadFilter('key1', $this->readFilter);
        $this->dataspace->addWriteFilter('key2', $this->writeFilter);
    }


    public function testReadFilter()
    {
        $this->readFilter->expectOnce('filter', array('value1'));
        $this->readFilter->setReturnValue('filter', 'filtered1');
        $this->writeFilter->expectNever('filter');

        $this->assertEqual($this->dataspace->get('key1'), 'filtered1');
        $this->assertEqual($this->dataspace->get('key2'), 'value2');
    }

    public function testWriteFilter()
    {
        $this->writeFilter->expectOnce('filter', array('value2'));
        $this->writeFilter->setReturnValue('filter', 'filtered2');
        $this->readFilter->expectNever('filter');

        $this->dataspace->set('key2', 'value2');

        $this->assertEqual($this->dataspace->get('key2'), 'filtered2');
    }

}

?>