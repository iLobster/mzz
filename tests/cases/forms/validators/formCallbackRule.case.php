<?php
fileLoader::load('forms/validators/formCallbackRule');

function simpleCallbackRuleFunction($a, $b, $c) {
    return ($a < $b) && ($b < $c);
}

class formCallbackRuleTest extends UnitTestCase
{
    //private $request;

    public function setup()
    {
        //$this->request = systemToolkit::getInstance()->getRequest();
        //$this->request->save();
    }

    function teardown()
    {
        //$this->request->restore();
    }

    public function testIsCorrect()
    {
        //$_POST['regex_name'] = 'testName';
        //$this->request->refresh();

        $rule = new formCallbackRule('rule_name', $msg = 'Incorrect values', array('simpleCallbackRuleFunction', 1, 2, 3));
        $this->assertTrue($rule->validate());
    }
}

?>