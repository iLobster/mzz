<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formRangeRule');

class formRangeRuleTest extends UnitTestCase
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

    public function testMatch()
    {
        $_POST['number'] = 10;
        $this->request->refresh();

        $rule = new formRangeRule('number', '', array(1, 20));
        $this->assertTrue($rule->validate());
    }

    public function testNotMatch()
    {
        $_POST['number'] = 0;
        $this->request->refresh();

        $rule = new formRangeRule('number', '', array(1, 20));
        $this->assertFalse($rule->validate());
    }

    public function testException()
    {
        $_POST['number'] = 0;
        $this->request->refresh();

        $rule = new formRangeRule('number', '', array(20));

        try {
            $rule->validate();
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/2 параметра/i", $e->getMessage());
        }
    }
}

?>