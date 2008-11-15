<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formRangeRule');

class formRangeRuleTest extends UnitTestCase
{
    public function setup()
    {
    }

    function teardown()
    {
    }

    public function testMatch()
    {
        $rule = new formRangeRule('number', '', array(1, 20));
        $this->assertTrue($rule->setValue(10)->validate());
    }

    public function testNotMatch()
    {
        $rule = new formRangeRule('number', '', array(1, 20));
        $this->assertFalse($rule->setValue(0)->validate());
    }

    public function testOneSideRanges()
    {
        $num = 666;

        $rule = new formRangeRule('number', '', array(1, null));
        $this->assertTrue($rule->setValue($num)->validate());

        $rule = new formRangeRule('number', '', array(1000, null));
        $this->assertFalse($rule->setValue($num)->validate());

        $rule = new formRangeRule('number', '', array(null, 1000));
        $this->assertTrue($rule->setValue($num)->validate());

        $rule = new formRangeRule('number', '', array(null, 100));
        $this->assertFalse($rule->setValue($num)->validate());

        try {
            $rule = new formRangeRule('number', '', array(null, null));
            $rule->setValue($num)->validate();
            $this->fail();
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/2 параметра/i", $e->getMessage());
        }
    }

    public function testException()
    {
        $rule = new formRangeRule('number', '', array(20));

        try {
            $rule->setValue(0)->validate();
            $this->fail();
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/2 параметра/i", $e->getMessage());
        }
    }
}

?>