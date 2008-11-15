<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formEmailRule');

class formEmailRuleTest extends UnitTestCase
{
    public function setup()
    {
        $this->rule = new formEmailRule('email', '');
    }

    function teardown()
    {
    }

    public function testSimple()
    {
        $this->assertTrue($this->rule->setValue('name@domain.ru')->validate());
    }

    public function testNoAtChar()
    {
        $this->assertFalse($this->rule->setValue('namedomain.ru')->validate());
    }

    public function testInvalidDomain()
    {
        $this->assertFalse($this->rule->setValue('name@-domain.ru')->validate());
    }

    public function testInvalidName()
    {
        $this->assertFalse($this->rule->setValue('мззname@domain.ru')->validate());
    }
}

?>