<?php

fileLoader::load('db/sqlFunction');


class sqlFunctionTest extends unitTestCase
{
    private $simpleSelect;

    function setUp()
    {
        $this->simpleSelect = new simpleSelect(new criteria());
    }

    public function testSqlFunctionGenerate()
    {
        $sqlFunction = new sqlFunction('NOW');
        $this->assertEqual($sqlFunction->toString($this->simpleSelect), 'NOW()');
    }

    public function testUpper()
    {
        $sqlFunction = new sqlFunction('Unix_Timestamp');
        $this->assertEqual($sqlFunction->toString($this->simpleSelect), 'UNIX_TIMESTAMP()');
    }

    public function testFunctionWithArguments()
    {
        $sqlFunction = new sqlFunction('Function', array('field' => true, "value", 3));
        $this->assertEqual($sqlFunction->toString($this->simpleSelect), "FUNCTION(`field`, 'value', 3)");

        $sqlFunction = new sqlFunction('Function', "arg");
        $this->assertEqual($sqlFunction->toString($this->simpleSelect), "FUNCTION('arg')");

        $sqlFunction = new sqlFunction('Function', 'table.field', true);
        $this->assertEqual($sqlFunction->toString($this->simpleSelect), "FUNCTION(`table`.`field`)");
    }

    public function testNullAndNumberArguments()
    {
        $sqlFunction = new sqlFunction('Function', array("value", 3, null, 3.5));
        $this->assertEqual($sqlFunction->toString($this->simpleSelect), "FUNCTION('value', 3, null, 3.5)");

        $sqlFunction = new sqlFunction('Function', 3);
        $this->assertEqual($sqlFunction->toString($this->simpleSelect), "FUNCTION(3)");

        $sqlFunction = new sqlFunction('Function', 5.5);
        $this->assertEqual($sqlFunction->toString($this->simpleSelect), "FUNCTION(5.5)");
    }

    public function testCompositeFunction()
    {
        $function1 = new sqlFunction('Function_1', 'table.field', true);

        $function2_arguments = array('table.field' => true, 'value');
        $function2 = new sqlFunction('Function_2', $function2_arguments);

        $arguments = array($function1, $function2, 'value', 'field' => true);
        $sqlFunction = new sqlFunction('Function', $arguments);
        $this->assertEqual($sqlFunction->toString($this->simpleSelect), "FUNCTION(FUNCTION_1(`table`.`field`), FUNCTION_2(`table`.`field`, 'value'), 'value', `field`)");
    }

    public function testQuote()
    {
        $function = new sqlFunction('function', 'value " value');
        $this->assertEqual($function->toString($this->simpleSelect), "FUNCTION('value \\\" value')");
    }

    public function testAsterisc()
    {
        $function = new sqlFunction('count', '*', true);
        $this->assertEqual($function->toString($this->simpleSelect), "COUNT(*)");
    }

    public function testNested()
    {
        $function = new sqlFunction('foo', new sqlFunction('bar', '*', true));
        $this->assertEqual($function->toString($this->simpleSelect), "FOO(BAR(*))");
    }

    public function testSqlOperator()
    {
        $function = new sqlFunction('count', new sqlOperator('DISTINCT', 'field'));
        $this->assertEqual($function->toString($this->simpleSelect), "COUNT(DISTINCT `field`)");
    }

    public function testNotEqualFieldNames()
    {
        $func_foo = new sqlFunction('foo', array('table.foo' => true, 'value'));
        $func_bar = new sqlFunction('foo', array('table.bar' => true, 'value'));
        $this->assertNotEqual($func_foo->getFieldName(), $func_bar->getFieldName());
    }
}

?>