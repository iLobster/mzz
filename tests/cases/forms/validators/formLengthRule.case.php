<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formLengthRule');

class formLengthRuleTest extends UnitTestCase
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

    public function testLongerThan()
    {
        $_POST['string'] = 'string';
        $this->request->refresh();

        $rule = new formLengthRule('string', '', 6);
        $this->assertTrue($rule->validate());
    }

    public function testNotLongerThan()
    {
        $_POST['string'] = 'string';
        $this->request->refresh();

        $rule = new formLengthRule('string', '', 7);
        $this->assertFalse($rule->validate());
    }

    public function testInRange()
    {
        $_POST['string'] = 'string';
        $this->request->refresh();

        $rule = new formLengthRule('string', '', array(3, 10));
        $this->assertTrue($rule->validate());
    }

    public function testNotInRange()
    {
        $_POST['string'] = 'string';
        $this->request->refresh();

        $rule = new formLengthRule('string', '', array(10, 11));
        $this->assertFalse($rule->validate());
    }

    public function testShorterThan()
    {
        $_POST['string'] = 'string';
        $this->request->refresh();

        $rule = new formLengthRule('string', '', array(null, 10));
        $this->assertTrue($rule->validate());
    }

    public function testNotShorterThan()
    {
        $_POST['string'] = 'string';
        $this->request->refresh();

        $rule = new formLengthRule('string', '', array(null, 1));
        $this->assertFalse($rule->validate());
    }
}

?>