<?php
fileLoader::load('db/simpleUpdate');

class simpleUpdateTest extends unitTestCase
{
    private $update;
    /**
     * @var criteria
     */
    private $criteria;

    public function setUp()
    {
        $this->criteria = new criteria();
        $this->criteria->table('table');
        $this->update = new simpleUpdate($this->criteria);
    }

    public function testUpdateAll()
    {
        $this->assertEqual($this->update->toString(array(
            'field1' => 'value1',
            'field2' => 'value2')), "UPDATE `table` SET `field1` = 'value1', `field2` = 'value2'");
    }

    public function testUpdateWithConditions()
    {
        $this->criteria->where('id', 100);
        $this->assertEqual($this->update->toString(array(
            'field' => 'value')), "UPDATE `table` SET `field` = 'value' WHERE `table`.`id` = 100");
    }

    public function testUpdateWithFunctions()
    {
        $this->assertEqual($this->update->toString(array(
            'field' => new sqlFunction('upper', 'value'))), "UPDATE `table` SET `field` = UPPER('value')");
    }

    public function testNoDataPassed()
    {
        try {
            $this->update->toString(array());
            $this->fail();
        } catch (mzzRuntimeException $e) {
            $this->assertPattern('/update.*empty/i', $e->getMessage());
        }
    }
}

?>