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
        $function2 = new sqlFunction('MAX', 'table.field', true);
        $this->criteria->addSelectField($function, 'alias')->addSelectField($function2, 'alias2');
        $this->assertEqual($this->select->toString(), 'SELECT INET_ATON(`table`.`field`) AS `alias`, MAX(`table`.`field`) AS `alias2`');
    }

    public function testSelectOperator()
    {
        $operator = new sqlOperator('+', array('table.field2', 100));
        $this->criteria->setTable('table');
        $this->criteria->add('field', $operator);
        $this->assertEqual($this->select->toString(), 'SELECT * FROM `table` WHERE `table`.`field` = `table`.`field2` + 100');
    }

    public function testSelectAllNoConditions()
    {
        $this->criteria->setTable('table');
        $this->assertEqual($this->select->toString(), 'SELECT * FROM `table`');
    }

    public function testSelectAllWithTableAliasNoConditions()
    {
        $this->criteria->setTable('table', 'tbl');
        $this->assertEqual($this->select->toString(), 'SELECT * FROM `table` `tbl`');
    }

    public function testSelectConcreteFieldsNoConditionsSelectFieldsAlias()
    {
        $this->criteria->setTable('table');
        $this->criteria->addSelectField('field1');
        $this->criteria->addSelectField('field2', 'alias');
        $this->criteria->addSelectField('field3');
        $this->assertEqual($this->select->toString(), 'SELECT `field1`, `field2` AS `alias`, `field3` FROM `table`');
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

    public function testSelectOrderWithAlias()
    {
        $this->criteria->setTable('table')->setOrderByFieldDesc('table2.field')->setOrderByFieldAsc('table3.field2');
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` ORDER BY `table2`.`field` DESC, `table3`.`field2` ASC");
    }

    public function testSelectOrderWithoutAlias()
    {
        $this->criteria->setTable('table')->setOrderByFieldDesc('field', false)->setOrderByFieldAsc('field2', false);
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` ORDER BY `field` DESC, `field2` ASC");
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

    public function testSelectInnerJoin()
    {
        $this->criteria->setTable('table');
        $this->assertEqual($this->select->toString(), 'SELECT * FROM `table`');
        $this->criteria->addJoin('foo', new criterion('alias.id', 'table.id', criteria::EQUAL, true), 'alias', criteria::JOIN_INNER);
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` INNER JOIN `foo` `alias` ON `alias`.`id` = `table`.`id`");
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

    public function testGroupBy()
    {
        $this->criteria->setTable('table');
        $this->criteria->addGroupBy('table.field');
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` GROUP BY `table`.`field`");
    }

    public function testDistinct()
    {
        $this->criteria->setTable('table');
        $this->criteria->setDistinct();
        $this->assertEqual($this->select->toString(), "SELECT DISTINCT * FROM `table`");

        $this->criteria->addSelectField('foo');
        $this->assertEqual($this->select->toString(), "SELECT DISTINCT `foo` FROM `table`");

        $this->criteria->setDistinct(false);
        $this->assertEqual($this->select->toString(), "SELECT `foo` FROM `table`");
    }

    public function testSubselect()
    {
        $this->criteria->setTable('table');
        $this->criteria->addGroupBy('table.field');

        $criteria = new criteria($this->criteria, 'x');
        $select = new simpleSelect($criteria);

        $this->assertEqual($select->toString(), "SELECT * FROM (SELECT * FROM `table` GROUP BY `table`.`field`) `x`");
    }

    public function testSubselectInJoin()
    {
        $this->criteria->setTable('table');
        $this->criteria->addSelectField('table.*')->addSelectField('foo.id', 'foo_id');

        $criteria = new criteria('zzz');
        $criteria->add('asd', 666);

        $this->criteria->addJoin($criteria, new criterion('x.id', 'table.id', criteria::EQUAL, true), 'x');

        $this->assertEqual($this->select->toString(), "SELECT `table`.*, `foo`.`id` AS `foo_id` FROM `table` LEFT JOIN (SELECT * FROM `zzz` WHERE `zzz`.`asd` = 666) `x` ON `x`.`id` = `table`.`id`");
    }
}

?>