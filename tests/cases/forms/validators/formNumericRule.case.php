<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formNumericRule');

class formNumericRuleTest extends UnitTestCase
{
    public function testExists()
    {
        $rule = new formNumericRule();
        $this->assertTrue($rule->validate('10'));
    }

    public function testErrorMessage()
    {
        $rule = new formNumericRule($msg = 'The value must exists');
        $this->assertFalse($rule->validate('a'));
        $this->assertEqual($rule->getErrorMsg(), $msg);
    }
}

?>