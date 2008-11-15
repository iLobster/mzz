<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formRegexRule');

class formRegexRuleTest extends UnitTestCase
{
    public function setup()
    {
    }

    function teardown()
    {
    }

    public function testMatch()
    {
        $rule = $this->createValidator($msg = 'The value must match', '!^testName$!');
        $rule->setValue('testName');
        $this->assertTrue($rule->validate());
    }

    public function testErrorMessage()
    {
        $rule = $this->createValidator($msg = 'The value must match', '!^testName$!');
        $rule->setValue('wrongName');
        $this->assertFalse($rule->validate());
        $this->assertEqual($rule->getErrorMsg(), $msg);
    }

    protected function createValidator($msg, $regex)
    {
        return new formRegexRule('regex',  $msg, $regex);
    }
}

?>