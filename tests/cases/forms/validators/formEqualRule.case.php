<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formEqualRule');

class formEqualRuleTest extends UnitTestCase
{
    private $request;

    public function setup()
    {
        $this->request = systemToolkit::getInstance()->getRequest();
        $this->request->save();
    }

    function teardown()
    {
        $this->request->restore();
    }

    public function testEqual()
    {
        $_POST['second'] = '10';
        $this->request->refresh();

        $rule = new formEqualRule('first', '', array('second'));
        $this->assertTrue($rule->setValue('10')->validate());
    }

    public function testNotEqual()
    {
        $_POST['second'] = '1';
        $this->request->refresh();

        $rule = new formEqualRule('first', '', array('second'));
        $this->assertFalse($rule->setValue('10')->validate());
    }

    public function testNoSecond()
    {
        unset($_POST['second']);
        $this->request->refresh();

        $rule = new formEqualRule('first', '');
        $rule->setValue('10');
        try {
            $rule->validate();
            $this->fail('Должно быть брошено исключение');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/Отсутствует имя/i", $e->getMessage());
        }
    }

    public function testTrueNotEqual()
    {
        $_POST['second'] = '1';
        $this->request->refresh();

        $rule = new formEqualRule('first', '', array('second', false));
        $this->assertTrue($rule->setValue(10)->validate());
    }
}

?>