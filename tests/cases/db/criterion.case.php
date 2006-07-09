<?php

fileLoader::load('db/criterion');

class criterionTest extends unitTestCase
{
    //private $criterion;

    public function setUp()
    {
    }

    public function testSimpleEqualCondition()
    {
        $criterion = new criterion('field', 'value');
        $this->assertEqual($criterion->generate(), "`field` = 'value'");
    }

    public function testSimpleNotEqualCondition()
    {
        $criterion = new criterion('field', 'value', criteria::NOT_EQUAL);
        $this->assertEqual($criterion->generate(), "`field` <> 'value'");
    }

    public function testSimpleInCondition()
    {
        $criterion = new criterion('field', array('value1', 'value2'), criteria::IN);
        $this->assertEqual($criterion->generate(), "`field` IN ('value1', 'value2')");
    }

    public function testSimpleLikeCondition()
    {
        $criterion = new criterion('field', '%q_', criteria::LIKE);
        $this->assertEqual($criterion->generate(), "`field` LIKE '%q_'");
    }

    public function testSimpleBetweenCondition()
    {
        $criterion = new criterion('field', array(1, 10), criteria::BETWEEN);
        $this->assertEqual($criterion->generate(), "`field` BETWEEN '1' AND '10'");
    }

    public function testAddAndCondition()
    {
        $criterion = new criterion('field', 'value');
        $criterion->addAnd(new criterion('field2', 'value2'));
        $this->assertEqual($criterion->generate(), "(`field` = 'value') AND (`field2` = 'value2')");
    }

    public function testGetField()
    {
        $criterion = new criterion('field', 'value');
        $this->assertEqual($criterion->getField(), 'field');
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
        $this->assertEqual($criterion->generate(), "(`field` = 'value')");
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
        $this->assertEqual($cr2->generate(), "(`field2` = 'value2') OR (`field2` = 'value3')");

        $cr1->addAnd($cr2);
        $this->assertEqual($cr1->generate(), "(`field1` = 'value1') AND ((`field2` = 'value2') OR (`field2` = 'value3'))");

        $cr4->addAnd($cr5);
        $this->assertEqual($cr4->generate(), "(`field4` >= 'value4') AND (`field5` <= 'value5')");

        $criterion->add($cr1);
        $this->assertEqual($criterion->generate(), "((`field1` = 'value1') AND ((`field2` = 'value2') OR (`field2` = 'value3')))");

        $criterion->addOr($cr4);
        $this->assertEqual($criterion->generate(), "((`field1` = 'value1') AND ((`field2` = 'value2') OR (`field2` = 'value3'))) OR ((`field4` >= 'value4') AND (`field5` <= 'value5'))");
    }
}

?>