<?php
fileLoader::load('db/simpleInsert');

class simpleInsertTest extends unitTestCase
{
    private $insert;
    /**
     * @var criteria
     */
    private $criteria;

    public function setUp()
    {
        $this->criteria = new criteria();
        $this->criteria->table('table');
        $this->insert = new simpleInsert($this->criteria);
    }

    public function testInsert()
    {
        $this->assertEqual($this->insert->toString(array('field1' => 'value1', 'field2' => 'value2')), "INSERT INTO `table` (`field1`, `field2`) VALUES ('value1', 'value2')");
    }

    public function testInsertMany()
    {
        $this->assertEqual($this->insert->toString(array('f1', 'f2'), array(array('v11', 'v12'), array('v21', 'v22'))), "INSERT INTO `table` (`f1`, `f2`) VALUES ('v11', 'v12'), ('v21', 'v22')");
    }

    public function testInsertBlank()
    {
        try {
            $this->insert->toString(array());
            $this->fail();
        } catch (mzzRuntimeException $e) {
            $this->assertPattern('/at least one/i', $e->getMessage());
        }
    }

    public function testInsertWithWrongArgs()
    {
        try {
            $this->insert->toString(array('f1', 'f2'), array(array('v11', 'v12'), array('here should be second element')));
            $this->fail();
        } catch (mzzRuntimeException $e) {
            $this->assertPattern('/expects.*2.*1 given/i', $e->getMessage());
        }
    }
}

?>