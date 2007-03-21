<?php

fileLoader::load('db/sqlFunction');


class sqlFunctionTest extends unitTestCase
{
    function setUp()
    {
    }

    public function tearDown()
    {
    }

    public function testSqlFunctionGenerate()
    {
        $sqlFunction = new sqlFunction('NOW');
        $this->assertEqual($sqlFunction->toString(), 'NOW()');
    }

    public function testUpper()
    {
        $sqlFunction = new sqlFunction('Unix_Timestamp');
        $this->assertEqual($sqlFunction->toString(), 'UNIX_TIMESTAMP()');
    }

    public function testFunctionWithArguments()
    {
        $sqlFunction = new sqlFunction('Function', array('field' => true, "value", 3));
        $this->assertEqual($sqlFunction->toString(), "FUNCTION(`field`, 'value', 3)");

        $sqlFunction = new sqlFunction('Function', "arg");
        $this->assertEqual($sqlFunction->toString(), "FUNCTION('arg')");

        $sqlFunction = new sqlFunction('Function', 'table.field', true);
        $this->assertEqual($sqlFunction->toString(), "FUNCTION(`table`.`field`)");
    }

    public function testNullAndNumberArguments()
    {
        $sqlFunction = new sqlFunction('Function', array("value", 3, null, 3.5));
        $this->assertEqual($sqlFunction->toString(), "FUNCTION('value', 3, null, 3.5)");

        $sqlFunction = new sqlFunction('Function', 3);
        $this->assertEqual($sqlFunction->toString(), "FUNCTION(3)");

        $sqlFunction = new sqlFunction('Function', 5.5);
        $this->assertEqual($sqlFunction->toString(), "FUNCTION(5.5)");
    }

    public function testCompositeFunction()
    {
        $function1 = new sqlFunction('Function_1','table.field', true);

        $function2_arguments = array('table.field' => true, 'value');
        $function2 = new sqlFunction('Function_2',$function2_arguments);

        $arguments = array($function1, $function2, 'value', 'field' => true);
        $sqlFunction = new sqlFunction('Function', $arguments);
        $this->assertEqual($sqlFunction->toString(), "FUNCTION(FUNCTION_1(`table`.`field`), FUNCTION_2(`table`.`field`, 'value'), 'value', `field`)");
    }

    public function testQuote()
    {
        $function = new sqlFunction('function', 'value " value');
        $this->assertEqual($function->toString(), "FUNCTION('value \\\" value')");
    }
}

?>