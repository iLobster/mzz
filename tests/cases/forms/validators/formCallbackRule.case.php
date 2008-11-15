<?php
fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formCallbackRule');

function simpleCallbackRuleFunction($value, $a, $b, $c) {
    return ($a < $b) && ($b < $c);
}

class formCallbackRuleTest extends UnitTestCase
{
    public function setup()
    {
    }

    function teardown()
    {
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