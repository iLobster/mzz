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
        $sqlFunction = new sqlFunction('Function', array('`field`', "value", 3));
        $this->assertEqual($sqlFunction->toString(), "FUNCTION(`field`, 'value', '3')");

        $sqlFunction = new sqlFunction('Function', "arg");
        $this->assertEqual($sqlFunction->toString(), "FUNCTION('arg')");

        $sqlFunction = new sqlFunction('Function', "`field`");
        $this->assertEqual($sqlFunction->toString(), "FUNCTION(`field`)");
    }
}

?>