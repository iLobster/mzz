<?php

fileLoader::load('forms/validators/formNumericRule');

class formNumericRuleTest extends UnitTestCase
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
        $_POST['numeric_name'] = '10';
        $this->request->refresh();

        $rule = new formNumericRule('numeric_name');
        $this->assertTrue($rule->validate());
    }

    public function testErrorMessage()
    {
        $_POST['numeric_name2'] = 'a';
        $this->request->refresh();

        $rule = new formNumericRule('numeric_name2', $msg = 'The value must exists');
        $this->assertFalse($rule->validate());
        $this->assertEqual($rule->getErrorMsg(), $msg);
    }
}

?>