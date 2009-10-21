<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formRegexRule');

class formRegexRuleTest extends UnitTestCase
{
    public function testMatch()
    {
        $rule = $this->createValidator($msg = 'The value must match', '!^testName$!');
        $this->assertTrue($rule->validate('testName'));
    }

    public function testErrorMessage()
    {
        $rule = $this->createValidator($msg = 'The value must match', '!^testName$!');
        $this->assertFalse($rule->validate('wrongName'));
        $this->assertEqual($rule->getErrorMsg(), $msg);
    }

    protected function createValidator($msg, $regex)
    {
        return new formRegexRule($msg, $regex);
    }
}

?>