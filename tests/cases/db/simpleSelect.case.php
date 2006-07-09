<?php
fileLoader::load('db/simpleSelect');

class simpleSelectTest extends unitTestCase
{
    private $select;

    public function setUp()
    {
        $this->criteria = new criteria();
        $this->select = new simpleSelect($this->criteria);
    }

    public function testSelectAllNoConditions()
    {
        $this->criteria->setTable('table');
        $this->assertEqual($this->select->toString(), 'SELECT * FROM `table`');
    }

    public function testSelectAllEqualsCondition()
    {
        $this->criteria->setTable('table');
        $this->criteria->add('field', 'value');
        $this->criteria->add('field2', 'value2');
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` WHERE `field` = 'value' AND `field2` = 'value2'");
    }
}

?>