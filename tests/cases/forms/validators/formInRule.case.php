<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formInRule');

class formInRuleTest extends UnitTestCase
{
    public function setup()
    {
    }

    function teardown()
    {
    }

    public function testIn()
    {
        $rule = new formInRule('foo', '', array('bar', 'baz'));
        $this->assertTrue($rule->setValue('bar')->validate());
    }

    public function testInWithKeys()
    {
        $rule = new formInRule('foo', '', array('somekey' => 'bar', 'baz'));
        $this->assertTrue($rule->setValue('bar')->validate());
    }

    public function testInWithArray()
    {
        $rule = new formInRule('array:foo', '', array('bar', 'baz'));
        $this->assertTrue($rule->setValue(array('bar', 'baz'))->validate());
    }

    public function testNotInWithArray()
    {
        $rule = new formInRule('array:foo', '', array('baz'));
        $this->assertFalse($rule->setValue(array('bar', 'baz'))->validate());
    }

    public function testNullInAndZeroNotIn()
    {
        $rule = new formInRule('foo', '', array(1, 2));
        $this->assertFalse($rule->setValue('0')->validate());
        $this->assertTrue($rule->setValue(0)->validate());
        $this->assertTrue($rule->setValue(null)->validate());
    }

    public function testNotIn()
    {
        $rule = new formInRule('foo', '', array('bar', 'baz'));
        $this->assertFalse($rule->setValue('foobar')->validate());
    }

    public function testNotArray()
    {
        $rule = new formInRule('foo', '', 'string');
        $rule->setValue('foobar');
        try {
            $rule->validate();
            $this->fail('Должно быть брошено исключение');
        } catch (mzzInvalidParameterException $e) {
            $this->pass();
        }
    }
}

?>