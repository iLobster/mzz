<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formRequiredRule');

class formRequiredRuleTest extends UnitTestCase
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

    public function testExists()
    {
        $_POST['name'] = '0';
        $this->request->refresh();

        $rule = new formRequiredRule('name');
        $this->assertTrue($rule->validate());
    }

    public function testErrorMessage()
    {
        $rule = new formRequiredRule('foobar', $msg = 'The value must exists');
        $this->assertFalse($rule->validate());
        $this->assertEqual($rule->getErrorMsg(), $msg);
    }

    public function testGetName()
    {
        $rule = new formRequiredRule($name = 'foobar', $msg = 'The value must exists');
        $this->assertEqual($rule->getName(), $name);
    }
}

?>