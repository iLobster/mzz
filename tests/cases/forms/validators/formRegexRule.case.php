<?php

fileLoader::load('forms/validators/formRegexRule');

class formRegexRuleTest extends UnitTestCase
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
        $_POST['regex_name'] = 'testName';
        $this->request->refresh();

        $rule = new formRegexRule('regex_name', $msg = 'The value must match', '!testName!si');
        $this->assertTrue($rule->validate());
    }

    public function testErrorMessage()
    {
        $_POST['regex_name2'] = 'nontestName';
        $this->request->refresh();

        $rule = new formRegexRule('regex_name2', $msg = 'The value must match', '!^testName&!');
        $this->assertFalse($rule->validate());
        $this->assertEqual($rule->getErrorMsg(), $msg);
    }
}

?>