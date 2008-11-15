<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formNumericRule');

class formNumericRuleTest extends UnitTestCase
{
    public function setup()
    {
    }

    function teardown()
    {
    }

    public function testExists()
    {
        $rule = new formNumericRule('numeric');
        $this->assertTrue($rule->setValue('10')->validate());
    }

    public function testErrorMessage()
    {
        $rule = new formNumericRule('numeric', $msg = 'The value must exists');
        $this->assertFalse($rule->setValue('a')->validate());
        $this->assertEqual($rule->getErrorMsg(), $msg);
    }
}

?>