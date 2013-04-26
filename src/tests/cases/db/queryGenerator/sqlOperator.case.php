<?php

fileLoader::load('db/sqlOperator');

class sqlOperatorTest extends unitTestCase
{
    private $simpleSelect;

    function setUp()
    {
        $this->simpleSelect = new simpleSelect(new criteria());
    }

    public function testGenerateInts()
    {
        $sqlOperator = new sqlOperator('+', array(1, 2));
        $this->assertEqual($sqlOperator->toString($this->simpleSelect), '1 + 2');
    }

    public function testGenerateFields()
    {
        $sqlOperator = new sqlOperator('-', array('table.field', 'field2'));
        $this->assertEqual($sqlOperator->toString($this->simpleSelect), '`table`.`field` - `field2`');
    }

    public function testGenerateMixed()
    {
        $sqlOperator = new sqlOperator('*', array(5, 'field2'));
        $this->assertEqual($sqlOperator->toString($this->simpleSelect), '5 * `field2`');

        $sqlOperator = new sqlOperator('/', array('table.field', 2));
        $this->assertEqual($sqlOperator->toString($this->simpleSelect), '`table`.`field` / 2');
    }

    public function testLeftsideOperators()
    {
        $sqlOperator = new sqlOperator('INTERVAL', '1 DAY');
        $this->assertEqual($sqlOperator->toString($this->simpleSelect), 'INTERVAL 1 DAY');

        $sqlOperator = new sqlOperator('DISTINCT', array('field'));
        $this->assertEqual($sqlOperator->toString($this->simpleSelect), 'DISTINCT `field`');
    }

    public function testGenerateMultiple()
    {
        $sqlOperator = new sqlOperator('-', array('table.field', 'field2', 1 , 2));
        $this->assertEqual($sqlOperator->toString($this->simpleSelect), '`table`.`field` - `field2` - 1 - 2');
    }

    public function testNested()
    {
        $operatorNested = new sqlOperator('+', array(1, 2));
        $sqlOperator = new sqlOperator('-', array($operatorNested, 'field'));
        $this->assertEqual($sqlOperator->toString($this->simpleSelect), '(1 + 2) - `field`');
    }

    public function testNestedPriority()
    {
        $operatorNested = new sqlOperator('+', array(1, 2));
        $operatorNested2 = new sqlOperator('/', array($operatorNested, 'field'));

        $sqlOperator = new sqlOperator('*', array($operatorNested2, $operatorNested));
        $this->assertEqual($sqlOperator->toString($this->simpleSelect), '((1 + 2) / `field`) * (1 + 2)');
    }

    public function testUnexpectedOperator()
    {
        $sqlOperator = new sqlOperator('foo', array(5, 'field2'));

        try {
            $sqlOperator->toString($this->simpleSelect);
        } catch (mzzInvalidParameterException $e) {
            $this->assertPattern("/оператора/i", $e->getMessage());
        } catch (Exception $e) {
            $this->fail('Исключение не ожидаемого типа');
        }
    }

    public function testSqlFunctions()
    {
        $sqlOperator = new sqlOperator('-', array(new sqlFunction('NOW'), new sqlOperator('INTERVAL', '1 DAY')));
        $this->assertEqual($sqlOperator->toString($this->simpleSelect), 'NOW() - (INTERVAL 1 DAY)');
    }
}

?>