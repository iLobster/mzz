<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formRequiredRule');

class formRequiredRuleTest extends UnitTestCase
{
    public function setup()
    {
    }

    function teardown()
    {
    }

    public function testExists()
    {
        $rule = new formRequiredRule('name');
        $rule->setValue('0');
        $this->assertTrue($rule->validate());
    }

    public function testErrorMessage()
    {
        $rule = new formRequiredRule('foobar', $msg = 'The value must exists');
        $this->assertFalse($rule->validate());
        $this->assertEqual($rule->getErrorMsg(), $msg);
    }

    public function testGetName()
    {
        $rule = new formRequiredRule($name = 'foobar', $msg = 'The value must exists');
        $this->assertEqual($rule->getName(), $name);
    }

    public function testMultiple()
    {
        $rule = new formRequiredRule(array('foo', 'bar'), $msg = 'The value must exists');
        $this->assertEqual($rule->getName(), 'foo bar');
        $this->assertFalse($rule->validate());
        $this->assertEqual($rule->getErrorMsg(), $msg);

        $rule->setValue('test', 'first');
        $this->assertFalse($rule->validate());

        $rule->setValue('test', 'second');
        $this->assertTrue($rule->validate());

        $rule->setValue('', 'first');
        $this->assertFalse($rule->validate());
    }
}

?>