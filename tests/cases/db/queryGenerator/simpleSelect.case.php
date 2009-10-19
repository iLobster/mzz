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

    public function testSelectAllNoConditions()
    {
        $this->criteria->table('table');
        $this->assertEqual($this->select->toString(), 'SELECT * FROM `table`');
    }

    public function testSelectAllWithTableAliasNoConditions()
    {
        $this->criteria->table('table', 'tbl');
        $this->assertEqual($this->select->toString(), 'SELECT * FROM `table` `tbl`');
    }

    public function testSelectAllEqualsCondition()
    {
        $this->criteria->table('table');
        $this->criteria->where('field', 'value');
        $this->criteria->where('field2', 'value2');
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` WHERE `table`.`field` = 'value' AND `table`.`field2` = 'value2'");
    }

    public function testSelectAllWithCompexHaving()
    {
        $this->criteria->table('table');
        $this->criteria->groupBy('field');
        $this->criteria->having(new sqlFunction('count', '*', true), 666, criteria::GREATER);
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` GROUP BY `field` HAVING COUNT(*) > 666");
    }

    public function testSelectConditionOrderLimit()
    {
        $this->criteria->table('table')->where('field', 'value')->limit(10)->offset(15)->orderByDesc('field');
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` WHERE `table`.`field` = 'value' ORDER BY `table`.`field` DESC LIMIT 15, 10");
    }

    public function testSelectOrderWithAlias()
    {
        $this->criteria->table('table', 'alias')->orderByDesc('table2.field')->orderByAsc('table3.field2')->orderByAsc('field3');
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` `alias` ORDER BY `table2`.`field` DESC, `table3`.`field2` ASC, `alias`.`field3` ASC");
    }

    public function testSelectOrderWithoutAlias()
    {
        $this->criteria->table('table')->orderByDesc('field', false)->orderByAsc('field2', false);
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` ORDER BY `field` DESC, `field2` ASC");
    }

    public function testSelectOrderByFunction()
    {
        $this->criteria->table('table')->orderByAsc(new sqlFunction('RAND'), false);
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` ORDER BY RAND() ASC");
    }

    public function testSelectWithSimpleJoin()
    {
        $this->criteria->table('table');
        $this->assertEqual($this->select->toString(), 'SELECT * FROM `table`');
        $this->criteria->join('foo', new criterion('foo.id', 'table.id', criteria::EQUAL, true));
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` LEFT JOIN `foo` ON `foo`.`id` = `table`.`id`");
    }

    public function testSelectInnerJoin()
    {
        $this->criteria->table('table');
        $this->assertEqual($this->select->toString(), 'SELECT * FROM `table`');
        $this->criteria->join('foo', new criterion('alias.id', 'table.id', criteria::EQUAL, true), 'alias', criteria::JOIN_INNER);
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` INNER JOIN `foo` `alias` ON `alias`.`id` = `table`.`id`");
    }

    public function testSelectSomeFieldsWithSimpleJoin()
    {
        $this->criteria->table('table');
        $this->criteria->select('table.*')->select('foo.id', 'foo_id');
        $this->criteria->join('foo', new criterion('foo.id', 'table.id', criteria::EQUAL, true));
        $this->assertEqual($this->select->toString(), "SELECT `table`.*, `foo`.`id` AS `foo_id` FROM `table` LEFT JOIN `foo` ON `foo`.`id` = `table`.`id`");
    }

    public function testAutoAddPrefixToCondition()
    {
        $this->criteria->table('table');
        $this->criteria->where('field', 'value');
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` WHERE `table`.`field` = 'value'");
    }

    public function testGroupBy()
    {
        $this->criteria->table('table');
        $this->criteria->groupBy('table.field');
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` GROUP BY `table`.`field`");
    }

    public function testDistinct()
    {
        $this->criteria->table('table');
        $this->criteria->distinct();
        $this->assertEqual($this->select->toString(), "SELECT DISTINCT * FROM `table`");

        $this->criteria->select('foo');
        $this->assertEqual($this->select->toString(), "SELECT DISTINCT `foo` FROM `table`");

        $this->criteria->distinct(false);
        $this->assertEqual($this->select->toString(), "SELECT `foo` FROM `table`");
    }

    public function testSubselect()
    {
        $this->criteria->table('table');
        $this->criteria->groupBy('table.field');

        $criteria = new criteria($this->criteria, 'x');
        $select = new simpleSelect($criteria);

        $this->assertEqual($select->toString(), "SELECT * FROM (SELECT * FROM `table` GROUP BY `table`.`field`) `x`");
    }

    public function testSubselectInJoin()
    {
        $this->criteria->table('table');
        $this->criteria->select('table.*')->select('foo.id', 'foo_id');

        $criteria = new criteria('zzz');
        $criteria->where('asd', 666);

        $this->criteria->join($criteria, new criterion('x.id', 'table.id', criteria::EQUAL, true), 'x');

        $this->assertEqual($this->select->toString(), "SELECT `table`.*, `foo`.`id` AS `foo_id` FROM `table` LEFT JOIN (SELECT * FROM `zzz` WHERE `zzz`.`asd` = 666) `x` ON `x`.`id` = `table`.`id`");
    }

    public function testSelectFunctionObject()
    {
        $function = new sqlFunction('INET_ATON', 'table.field', true);
        $function2 = new sqlFunction('MAX', 'table.field', true);
        $this->criteria->select($function, 'alias')->select($function2, 'alias2');
        $this->assertEqual($this->select->toString(), 'SELECT INET_ATON(`table`.`field`) AS `alias`, MAX(`table`.`field`) AS `alias2`');
    }

    public function testSelectOperator()
    {
        $operator = new sqlOperator('+', array('table.field2', 100));
        $this->criteria->table('table');
        $this->criteria->where('field', $operator);
        $this->assertEqual($this->select->toString(), 'SELECT * FROM `table` WHERE `table`.`field` = `table`.`field2` + 100');
    }

    public function testSelectFunctionsAndOperators()
    {
        $function = new sqlFunction('count', '*', true);
        $this->criteria->select($function, 'cnt');
        $this->assertEqual($this->select->toString(), 'SELECT COUNT(*) AS `cnt`');

        $function = new sqlFunction('count', new sqlOperator('DISTINCT', 'field'));
        $this->criteria->select($function, 'cnt');
        $this->assertEqual($this->select->toString(), 'SELECT COUNT(DISTINCT `field`) AS `cnt`');
    }

    public function testSelectConcreteFieldsNoConditionsSelectFieldsAlias()
    {
        $this->criteria->table('table');
        $this->criteria->select('field1');
        $this->criteria->select('field2', 'alias');
        $this->criteria->select('field3');
        $this->assertEqual($this->select->toString(), 'SELECT `field1`, `field2` AS `alias`, `field3` FROM `table`');
    }

    public function testCriterionWithOrAndAdditionalParentheses()
    {
        $criterion = new criterion('f1', 'v1');
        $criterion->addOr(new criterion('f2', 'v2'));

        $this->criteria->table('table');
        $this->criteria->where($criterion);
        $this->criteria->where('f3', 'v3');
        $this->assertEqual($this->select->toString(), "SELECT * FROM `table` WHERE ((`table`.`f1` = 'v1') OR (`table`.`f2` = 'v2')) AND `table`.`f3` = 'v3'");
    }
}

?>