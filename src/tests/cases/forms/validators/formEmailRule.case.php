<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formEmailRule');

class formEmailRuleTest extends UnitTestCase
{
    public function setup()
    {
        $this->rule = new formEmailRule();
    }

    public function testSimple()
    {
        $this->assertTrue($this->rule->validate('name@domain.ru'));
    }

    public function testNoAtChar()
    {
        $this->assertFalse($this->rule->validate('namedomain.ru'));
    }

    public function testInvalidDomain()
    {
        $this->assertFalse($this->rule->validate('name@-domain.ru'));
    }

    public function testInvalidName()
    {
        $this->assertFalse($this->rule->validate('мззname@domain.ru'));
    }
}

?>