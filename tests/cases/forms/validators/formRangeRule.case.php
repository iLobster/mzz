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

    public function testOneSideRanges()
    {
        $_POST['number'] = 666;
        $this->request->refresh();

        $rule = new formRangeRule('number', '', array(1, null));
        $this->assertTrue($rule->validate());

        $rule = new formRangeRule('number', '', array(1000, null));
        $this->assertFalse($rule->validate());

        $rule = new formRangeRule('number', '', array(null, 1000));
        $this->assertTrue($rule->validate());

        $rule = new formRangeRule('number', '', array(null, 100));
        $this->assertFalse($rule->validate());

        try {
            $rule = new formRangeRule('number', '', array(null, null));
            $rule->validate();
            $this->fail();
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/2 параметра/i", $e->getMessage());
        }
    }

    public function testException()
    {
        $_POST['number'] = 0;
        $this->request->refresh();

        $rule = new formRangeRule('number', '', array(20));

        try {
            $rule->validate();
            $this->fail();
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/2 параметра/i", $e->getMessage());
        }
    }
}

?>