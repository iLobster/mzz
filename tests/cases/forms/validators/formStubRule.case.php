<?php

fileLoader::load('forms/validators/formAbstractRule');
class formStubRule extends formAbstractRule
{
    public function validate()
    {
        return true;
    }

    public function getFromRequest($name, $type)
    {
        return $type . "-" . $name;
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
        $rule = new formStubRule('field', '');
        $this->assertEqual($rule->getValue(), 'string-field');
        $rule->setValue($val = "newvalue");
        $this->assertEqual($rule->getValue(), $val);
    }

    public function testSetValueMultiple()
    {
        $rule = new formMultipleStubRule(array('first' => 'field1', 'second' => 'field2'), '');
        $this->assertEqual($rule->getValue(), array('first' => 'string-field1', 'second' => 'string-field2'));
        $rule->setValue($val = 'newvalue', 'second');
        $this->assertEqual($rule->getValue(), array('first' => 'string-field1', 'second' => 'newvalue'));
    }

    public function testGetValueMultiple()
    {
        $rule = new formMultipleStubRule(array('first' => 'field1', 'second' => 'field2'), '');
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

    public function testHandyNamesMultiple()
    {
        $rule = new formMultipleStubRule(array('field1', 'field2', 'field3', 'field4'), '');
        $this->assertEqual($rule->getValue('first'), 'string-field1');
        $this->assertEqual($rule->getValue('second'), 'string-field2');
        $this->assertNull($rule->getValue('field4'));
        $this->assertEqual($rule->getValue(3), 'string-field4');

        $rule->setValue($val = 'newvalue1', 'first');
        $rule->setValue($val = 'newvalue2', 'second');
        $this->assertEqual($rule->getValue('first'), 'newvalue1');
        $this->assertEqual($rule->getValue('second'), 'newvalue2');
    }
}

?>