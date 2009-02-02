<?php

fileLoader::load('db/criterion');

class criterionTest extends unitTestCase
{
    private $simpleSelect;

    public function setUp()
    {
        $this->simpleSelect = new simpleSelect(new criteria());
    }

    public function testSimpleEqualCondition()
    {
        $criterion = new criterion('field', 'value');
        $this->assertEqual($criterion->generate($this->simpleSelect), "`field` = 'value'");
    }

    public function testSimpleNotEqualCondition()
    {
        $criterion = new criterion('field', 'value', criteria::NOT_EQUAL);
        $this->assertEqual($criterion->generate($this->simpleSelect), "`field` <> 'value'");
    }

    public function testSimpleInCondition()
    {
        $criterion = new criterion('field', array('value1', 'value2'), criteria::IN);
        $this->assertEqual($criterion->generate($this->simpleSelect), "`field` IN ('value1', 'value2')");

        $criterion = new criterion('field', array(), criteria::IN);
        $this->assertEqual($criterion->generate($this->simpleSelect), "FALSE");
    }

    public function testSimpleLikeCondition()
    {
        $criterion = new criterion('field', '%q_', criteria::LIKE);
        $this->assertEqual($criterion->generate($this->simpleSelect), "`field` LIKE '%q_'");
    }

    public function testIsNullCondition()
    {
        $criterion = new criterion('field', '', criteria::IS_NULL);
        $this->assertEqual($criterion->generate($this->simpleSelect), "`field` IS NULL");

        $criterion = new criterion('field', '', criteria::IS_NOT_NULL);
        $this->assertEqual($criterion->generate($this->simpleSelect), "`field` IS NOT NULL");
    }

    public function testSimpleBetweenCondition()
    {
        $criterion = new criterion('field', array(1, 10), criteria::BETWEEN);
        $this->assertEqual($criterion->generate($this->simpleSelect), "`field` BETWEEN 1 AND 10");

        $criterion = new criterion('field', array(1, 10), criteria::NOT_BETWEEN);
        $this->assertEqual($criterion->generate($this->simpleSelect), "`field` NOT BETWEEN 1 AND 10");
    }

    public function testSimpleFulltextCondition()
    {
        $criterion = new criterion('field', 'foo', criteria::FULLTEXT);
        $this->assertEqual($criterion->generate($this->simpleSelect), "MATCH (`field`) AGAINST ('foo')");

        $criterion = new criterion(array('t1.field1', 't2.field2', 'field3'), 'foo', criteria::FULLTEXT);
        $this->assertEqual($criterion->generate($this->simpleSelect), "MATCH (`t1`.`field1`, `t2`.`field2`, `field3`) AGAINST ('foo')");
    }

    public function testAddAndCondition()
    {
        $criterion = new criterion('field', 'value');
        $criterion->addAnd(new criterion('field2', 'value2'));
        $criterion->addAnd(new criterion('field3', 'value3'));
        $this->assertEqual($criterion->generate($this->simpleSelect), "(`field` = 'value') AND (`field2` = 'value2') AND (`field3` = 'value3')");
    }

    public function testGetField()
    {
        $criterion = new criterion('field', 'value');
        $this->assertEqual($criterion->getField(), 'field');
    }

    public function testGetValue()
    {
        $criterion = new criterion('field', 'value');
        $this->assertEqual($criterion->getValue(), 'value');
    }

    public function testGetFieldComposite()
    {
        $criterion = new criterion();
        $criterion->add(new criterion('field', 'value'));
        $this->assertNull($criterion->getField());
    }

    public function testAdd()
    {
        $criterion = new criterion();
        $criterion2 = new criterion('field', 'value');
        $criterion->add($criterion2);
        $this->assertEqual($criterion->generate($this->simpleSelect), "(`field` = 'value')");
    }

    public function testFieldWithAlias()
    {
        $criterion = new criterion('foo.bar', 'value');
        $this->assertEqual($criterion->getValue(), 'value');
        $this->assertEqual($criterion->getField(), 'bar');

        $this->assertEqual($criterion->generate($this->simpleSelect), "`foo`.`bar` = 'value'");
    }

    public function testFieldAndFieldComparison()
    {
        $criterion = new criterion('field', 'field2', criteria::EQUAL, true);
        $this->assertEqual($criterion->generate($this->simpleSelect), "`field` = `field2`");

        $criterion = new criterion('field', 'field2', criteria::GREATER, true);
        $this->assertEqual($criterion->generate($this->simpleSelect), "`field` > `field2`");
    }

    public function testFieldAndFieldWithAliasComparison()
    {
        $criterion = new criterion('foo.field', 'bar.field2', criteria::EQUAL, true);
        $this->assertEqual($criterion->generate($this->simpleSelect), "`foo`.`field` = `bar`.`field2`");
    }

    public function testCompositeConjunction()
    {
        $criterion = new criterion();

        $cr1 = new criterion('field1', 'value1');
        $cr2 = new criterion('field2', 'value2');
        $cr3 = new criterion('field2', 'value3');
        $cr4 = new criterion('field4', 'value4', criteria::GREATER_EQUAL);
        $cr5 = new criterion('field5', 'value5', criteria::LESS_EQUAL);

        $cr2->addOr($cr3);
        $this->assertEqual($cr2->generate($this->simpleSelect), "((`field2` = 'value2') OR (`field2` = 'value3'))");

        $cr1->addAnd($cr2);
        $this->assertEqual($cr1->generate($this->simpleSelect), "(`field1` = 'value1') AND (((`field2` = 'value2') OR (`field2` = 'value3')))");

        $cr4->addAnd($cr5);
        $this->assertEqual($cr4->generate($this->simpleSelect), "(`field4` >= 'value4') AND (`field5` <= 'value5')");

        $criterion->add($cr1);
        $this->assertEqual($criterion->generate($this->simpleSelect), "((`field1` = 'value1') AND (((`field2` = 'value2') OR (`field2` = 'value3'))))");

        $criterion->addOr($cr4);
        $this->assertEqual($criterion->generate($this->simpleSelect), "(((`field1` = 'value1') AND (((`field2` = 'value2') OR (`field2` = 'value3')))) OR ((`field4` >= 'value4') AND (`field5` <= 'value5')))");
    }

    public function testDefaultTableName()
    {
        $criterion = new criterion('field', 'value');
        $this->assertEqual($criterion->generate($this->simpleSelect, $table = 'table'), "`table`.`field` = 'value'");
    }

    public function testSQLFuncitionAsValue()
    {
        $criterion = new criterion('field', new sqlFunction('FUNCTION', 'value', true));
        $this->assertEqual($criterion->generate($this->simpleSelect, $table = 'table'), "`table`.`field` = FUNCTION(`value`)");

        $criterion = new criterion('field', new sqlFunction('FUNCTION', 'value"'));
        $this->assertEqual($criterion->generate($this->simpleSelect, $table = 'table'), "`table`.`field` = FUNCTION('value\\\"')");
    }

    public function testFunctionAndFunctionComparasion()
    {
        $criterion = new criterion(new sqlFunction('FUNCTION', 'value'), new sqlFunction('FUNCTION', 'value', true));
        $this->assertEqual($criterion->generate($this->simpleSelect), "FUNCTION('value') = FUNCTION(`value`)");
    }

    public function testCriteriaAsFunction()
    {
        $criteria = new criteria('instruction');

        $greatest = new sqlFunction('greatest', array('controldate' => true, 'last_prolongation' => true));
        $criterion = new criterion($greatest, array(123, 456), criteria::BETWEEN);

        $this->assertEqual($criterion->generate($this->simpleSelect), "GREATEST(`controldate`, `last_prolongation`) BETWEEN 123 AND 456");
    }

    public function testCaseWhereCondition()
    {
        $criterion = new criterion('field', array(1 => 'one', 2 => 'two'), criteria::CASEWHERE);
        $this->assertEqual($criterion->generate($this->simpleSelect), "CASE `field` WHEN 1 THEN 'one' WHEN 2 THEN 'two' END");
    }
}

?>