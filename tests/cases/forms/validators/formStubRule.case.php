<?php

fileLoader::load('forms/validators/formAbstractRule');
class formStubRule extends formAbstractRule
{
    public function validate()
    {
        return true;
    }
}

class formMultipleStubRule extends formStubRule
{
    protected $multiple = true;
}

class formStubRuleTest extends UnitTestCase
{
    public function setup()
    {
    }

    function teardown()
    {
    }

    public function testName()
    {
        $rule = new formStubRule('field', '');
        $this->assertTrue($rule->getName(), 'field');

        $rule = new formStubRule('string:field', '');
        $this->assertTrue($rule->getName(), 'field');

        $rule = new formStubRule(array('field1', 'field2'), '');
        $this->assertEqual($rule->getName(), 'field1');
    }

    public function testNameMultiple()
    {
        $rule = new formMultipleStubRule('field', '');
        $this->assertTrue($rule->getName(), 'field');

        $rule = new formMultipleStubRule('string:field', '');
        $this->assertTrue($rule->getName(), 'field');

        $rule = new formMultipleStubRule(array('field1', 'field2'), '');
        $this->assertEqual($rule->getName(), 'field1 field2');

        $rule = new formMultipleStubRule(array('string:field1', 'float:field2'), '');
        $this->assertEqual($rule->getName(), 'field1 field2');
    }

    public function testSetValue()
    {
        $rule = new formStubRule('field', '', array(), 'string-field');
        $this->assertEqual($rule->getValue(), 'string-field');
        $rule->setValue($val = "newvalue");
        $this->assertEqual($rule->getValue(), $val);
    }

    public function testSetValueMultiple()
    {
        $values = array('first' => 'string-field1', 'second' => 'string-field2');
        $rule = new formMultipleStubRule(array('first' => 'field1', 'second' => 'field2'), '', array(), $values);
        $this->assertEqual($rule->getValue(), array('first' => 'string-field1', 'second' => 'string-field2'));
        $rule->setValue($val = 'newvalue', 'second');
        $this->assertEqual($rule->getValue(), array('first' => 'string-field1', 'second' => 'newvalue'));
    }

    public function testGetValueMultiple()
    {
        $values = array('first' => 'string-field1', 'second' => 'string-field2');
        $rule = new formMultipleStubRule(array('first' => 'field1', 'second' => 'field2'), '', array(), $values);
        $this->assertEqual($rule->getValue('first'), 'string-field1');
        $this->assertEqual($rule->getValue('second'), 'string-field2');
    }

    public function testSetValueWithoutNameMultiple()
    {
        $rule = new formMultipleStubRule(array('field1', 'field2'), '');
        try {
            $rule->setValue('error');
            $this->fail('Не было брошено исключение');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern('/requires the name/', $e->getMessage());
        } catch (Exception $e) {
            $this->fail('Брошено не ожидаемое исключение');
        }
    }
}

?>