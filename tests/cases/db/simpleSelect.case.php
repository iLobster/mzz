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

    public function testSelectConditionOrderLimit()
    {
        $this->criteria->setTable('table')->add('field', 'value')->setLimit(10)->setOffset(15)->setOrderByFieldDesc('field');
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` WHERE `field` = 'value' ORDER BY `field` DESC LIMIT 15, 10");
    }

    public function testSelectWithCount()
    {
        $this->criteria->setTable('table')->enableCount();
        $this->assertEqual($this->select->toString(), "SELECT SQL_CALC_FOUND_ROWS * FROM `table`");
    }

    public function testSelectWithCountFoundRows()
    {
        $this->criteria->setTable('table')->clearSelectFields()->addSelectField('FOUND_ROWS()');
        $this->assertEqual($this->select->toString(), "SELECT FOUND_ROWS() FROM `table`");
    }
}

?>