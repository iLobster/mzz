<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formInRule');

class formInRuleTest extends UnitTestCase
{
    public function testIn()
    {
        $rule = new formInRule('', array('bar', 'baz'));
        $this->assertTrue($rule->validate('bar'));
    }

    public function testInWithKeys()
    {
        $rule = new formInRule('', array('somekey' => 'bar', 'baz'));
        $this->assertTrue($rule->validate('bar'));
    }

    public function testInWithArray()
    {
        $rule = new formInRule('', array('bar', 'baz'));
        $this->assertTrue($rule->validate(array('bar', 'baz')));
    }

    public function testNotInWithArray()
    {
        $rule = new formInRule('', array('baz'));
        $this->assertFalse($rule->validate(array('bar', 'baz')));
    }

    public function testNullInAndZeroNotIn()
    {
        $rule = new formInRule('', array(1, 2));
        $this->assertFalse($rule->validate('0'));
        $this->assertFalse($rule->validate(0));
        $this->assertFalse($rule->validate(null));
    }

    public function testNotIn()
    {
        $rule = new formInRule('', array('bar', 'baz'));
        $this->assertFalse($rule->validate('foobar'));
    }

    public function testNotArray()
    {
        $rule = new formInRule('', 'string');
        try {
            $rule->validate('foobar');
            $this->fail('Должно быть брошено исключение');
        } catch (mzzInvalidParameterException $e) {
            $this->pass();
        }
    }
}

?>