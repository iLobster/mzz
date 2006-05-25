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
}

?>