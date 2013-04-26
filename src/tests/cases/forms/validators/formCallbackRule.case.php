<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formCallbackRule');

function simpleCallbackRuleFunction($value, $a, $b, $c)
{
    return ($a < $b) && ($b < $c) && $value == $a;
}

class formCallbackRuleTest extends UnitTestCase
{
    public function testIsCorrect()
    {
        $rule = new formCallbackRule($msg = 'Incorrect values', array(
            'simpleCallbackRuleFunction',
            1,
            2,
            3));
        $this->assertTrue($rule->validate(1));
    }
}

?>