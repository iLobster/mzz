<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formRangeRule');

class formRangeRuleTest extends UnitTestCase
{
    public function testMatch()
    {
        $rule = new formRangeRule('', array(1, 20));
        $this->assertTrue($rule->validate(10));
    }

    public function testNotMatch()
    {
        $rule = new formRangeRule('', array(1, 20));
        $this->assertFalse($rule->validate(0));
    }

    public function testOneSideRanges()
    {
        $num = 666;

        $rule = new formRangeRule('', array(1, null));
        $this->assertTrue($rule->validate($num));

        $rule = new formRangeRule('', array(1000, null));
        $this->assertFalse($rule->validate($num));

        $rule = new formRangeRule('', array(null, 1000));
        $this->assertTrue($rule->validate($num));

        $rule = new formRangeRule('', array(null, 100));
        $this->assertFalse($rule->validate($num));

        try {
            $rule = new formRangeRule('', array(null, null));
            $rule->validate($num);
            $this->fail();
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/2 параметра/i", $e->getMessage());
        }
    }

    public function testException()
    {
        $rule = new formRangeRule('', array(20));

        try {
            $rule->validate(0);
            $this->fail();
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/2 параметра/i", $e->getMessage());
        }
    }
}

?>