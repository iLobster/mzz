<?php
fileLoader::load('db/simpleSelect');
fileLoader::load('db/sqlFunction');

class simpleSelectTest extends unitTestCase
{
    private $select;

    public function setUp()
    {
        $this->criteria = new criteria();
        $this->select = new simpleSelect($this->criteria);
    }

    public function testSelectFunctionString()
    {
        $this->criteria->addSelectField('NOW()', 'now');
        $this->assertEqual($this->select->toString(), 'SELECT NOW() AS `now`');
    }

    public function testSelectFunctionObject()
    {
        $function = new sqlFunction('INET_ATON', 'table.field', true);
        $this->criteria->addSelectField($function, 'alias');
        $this->assertEqual($this->select->toString(), 'SELECT INET_ATON(`table`.`field`) AS `alias`');
    }

    public function testSelectAllNoConditions()
    {
        $this->criteria->setTable('table');
        $this->assertEqual($this->select->toString(), 'SELECT * FROM `table`');
    }

    public function testSelectConcreteFieldsNoConditionsSelectFieldsAlias()
    {
        $this->criteria->setTable('table');
        $this->criteria->addSelectField('field1');
        $this->criteria->addSelectField('field2', 'alias');
        $this->assertEqual($this->select->toString(), 'SELECT `field1`, `field2` AS `alias` FROM `table`');
    }

    public function testSelectAllEqualsCondition()
    {
        $this->criteria->setTable('table');
        $this->criteria->add('field', 'value');
        $this->criteria->add('field2', 'value2');
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` WHERE `table`.`field` = 'value' AND `table`.`field2` = 'value2'");
    }

    public function testSelectConditionOrderLimit()
    {
        $this->criteria->setTable('table')->add('field', 'value')->setLimit(10)->setOffset(15)->setOrderByFieldDesc('field');
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` WHERE `table`.`field` = 'value' ORDER BY `table`.`field` DESC LIMIT 15, 10");
    }

    public function testSelectWithCount()
    {
        $this->criteria->setTable('table')->enableCount();
        $this->assertEqual($this->select->toString(), "SELECT SQL_CALC_FOUND_ROWS * FROM `table`");
    }

    public function testSelectWithCountFoundRows()
    {
        $this->criteria->setTable('table')->addSelectField('FOUND_ROWS()');
        $this->assertEqual($this->select->toString(), "SELECT FOUND_ROWS() FROM `table`");
    }

    public function testSelectWithSimpleJoin()
    {
        $this->criteria->setTable('table');
        $this->assertEqual($this->select->toString(), 'SELECT * FROM `table`');
        $this->criteria->addJoin('foo', new criterion('foo.id', 'table.id', criteria::EQUAL, true));
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` LEFT JOIN `foo` ON `foo`.`id` = `table`.`id`");
    }

    public function testSelectSomeFieldsWithSimpleJoin()
    {
        $this->criteria->setTable('table');
        $this->criteria->addSelectField('table.*')->addSelectField('foo.id', 'foo_id');
        $this->criteria->addJoin('foo', new criterion('foo.id', 'table.id', criteria::EQUAL, true));
        $this->assertEqual($this->select->toString(), "SELECT `table`.*, `foo`.`id` AS `foo_id` FROM `table` LEFT JOIN `foo` ON `foo`.`id` = `table`.`id`");
    }

    public function testAutoAddPrefixToCondition()
    {
        $this->criteria->setTable('table');
        $this->criteria->add('field', 'value');
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` WHERE `table`.`field` = 'value'");
    }
}

?>