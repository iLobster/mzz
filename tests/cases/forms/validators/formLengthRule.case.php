<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formLengthRule');

class formLengthRuleTest extends UnitTestCase
{
    public function setup()
    {
    }

    function teardown()
    {
    }

    public function testLengthEqual()
    {
        $rule = new formLengthRule('string', '', 6);
        $this->assertTrue($rule->setValue('string')->validate());
    }

    public function testLengthNotEqual()
    {
        $rule = new formLengthRule('string', '', 7);
        $this->assertFalse($rule->setValue('string')->validate());
        $rule = new formLengthRule('string', '', 5);
        $this->assertFalse($rule->setValue('string')->validate());
    }

    public function testLongerThan()
    {
        $rule = new formLengthRule('string', '', array(3, null));
        $this->assertTrue($rule->setValue('string')->validate());
    }

    public function testNotLongerThan()
    {
        $rule = new formLengthRule('string', '', array(7, null));
        $this->assertFalse($rule->setValue('string')->validate());
    }

    public function testInRange()
    {
        $rule = new formLengthRule('string', '', array(3, 10));
        $this->assertTrue($rule->setValue('string')->validate());
    }

    public function testNotInRange()
    {
        $rule = new formLengthRule('string', '', array(10, 11));
        $this->assertFalse($rule->setValue('string')->validate());
    }

    public function testShorterThan()
    {
        $rule = new formLengthRule('string', '', array(null, 10));
        $this->assertTrue($rule->setValue('string')->validate());
    }

    public function testNotShorterThan()
    {
        $rule = new formLengthRule('string', '', array(null, 1));
        $this->assertFalse($rule->setValue('string')->validate());
    }

    public function testUnexpectedArgs()
    {
        $rule = new formLengthRule('string', '', array(666));
        try {
            $rule->setValue('string')->validate();
            $this->fail('Должно быть брошено исключение');
        } catch (mzzRuntimeException $e) {
            $this->pass();
        }
    }
}

?>