<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formEqualRule');

class formEqualRuleTest extends UnitTestCase
{
    public function testEqual()
    {
        $rule = new formEqualRule('', array('second'));
        $rule->setData(array('second' => '10'));
        $this->assertTrue($rule->validate('10'));
    }

    public function testNotEqual()
    {
        $rule = new formEqualRule('', array('second'));
        $rule->setData(array('second' => '1'));
        $this->assertFalse($rule->validate('10'));
    }

    public function testNoSecond()
    {
        $rule = new formEqualRule();
        try {
            $rule->validate('10');
            $this->fail('Должно быть брошено исключение');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/Отсутствует имя/i", $e->getMessage());
        }
    }

    public function testTrueNotEqual()
    {
        $rule = new formEqualRule('', array('second', false));
        $rule->setData(array('second' => '1'));
        $this->assertTrue($rule->validate(10));
    }
}

?>