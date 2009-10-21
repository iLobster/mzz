<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formLengthRule');

class formLengthRuleTest extends UnitTestCase
{
    public function testLengthEqual()
    {
        $rule = new formLengthRule('', 6);
        $this->assertTrue($rule->validate('string'));
    }

    public function testLengthNotEqual()
    {
        $rule = new formLengthRule('', 7);
        $this->assertFalse($rule->validate('string'));
        $rule = new formLengthRule('', 5);
        $this->assertFalse($rule->validate('string'));
    }

    public function testLongerThan()
    {
        $rule = new formLengthRule('', array(3, null));
        $this->assertTrue($rule->validate('string'));
    }

    public function testNotLongerThan()
    {
        $rule = new formLengthRule('', array(7, null));
        $this->assertFalse($rule->validate('string'));
    }

    public function testInRange()
    {
        $rule = new formLengthRule('', array(3, 10));
        $this->assertTrue($rule->validate('string'));
    }

    public function testNotInRange()
    {
        $rule = new formLengthRule('', array(10, 11));
        $this->assertFalse($rule->validate('string'));
    }

    public function testShorterThan()
    {
        $rule = new formLengthRule('', array(null, 10));
        $this->assertTrue($rule->validate('string'));
    }

    public function testNotShorterThan()
    {
        $rule = new formLengthRule('', array(null, 1));
        $this->assertFalse($rule->validate('string'));
    }

    public function testUnexpectedArgs()
    {
        $rule = new formLengthRule('', array(666));
        try {
            $rule->validate('string');
            $this->fail('Должно быть брошено исключение');
        } catch (mzzRuntimeException $e) {
            $this->pass();
        }
    }
}

?>