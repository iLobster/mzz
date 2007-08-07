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
        $_POST['first'] = '10';
        $_POST['second'] = '10';
        $this->request->refresh();

        $rule = new formEqualRule('first', '', array('second'));
        $this->assertTrue($rule->validate());
    }

    public function testNotEqual()
    {
        $_POST['first'] = '10';
        $_POST['second'] = '1';
        $this->request->refresh();

        $rule = new formEqualRule('first', '', array('second'));
        $this->assertFalse($rule->validate());
    }

    public function testNoSecond()
    {
        $_POST['first'] = '10';
        unset($_POST['second']);
        $this->request->refresh();

        $rule = new formEqualRule('first', '');

        try {
            $rule->validate();
            $this->fail('Должно быть брошено исключение');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/Отсутствует имя/i", $e->getMessage());
        }
    }

    public function testTrueNotEqual()
    {
        $_POST['first'] = '10';
        $_POST['second'] = '1';
        $this->request->refresh();

        $rule = new formEqualRule('first', '', array('second', false));
        $this->assertTrue($rule->validate());
    }
}

?>