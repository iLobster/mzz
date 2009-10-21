<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formHostnameRule');

class formHostnameRuleTest extends UnitTestCase
{
    public function setUp()
    {
        $this->rule = new formHostnameRule();
    }

    public function testSimple()
    {
        $this->assertTrue($this->rule->validate('foo.ru'));
    }

    public function testTooLong()
    {
        $this->assertFalse($this->rule->validate(str_repeat('a', 300) . '.ru'));
    }

    public function testTooShort()
    {
        $this->assertFalse($this->rule->validate('ru'));
    }

    public function testInvalidChars()
    {
        $this->assertFalse($this->rule->validate('домен.ru'));
    }

    public function testDashFirst()
    {
        $this->assertFalse($this->rule->validate('-domain.ru'));
    }

    public function testDashLast()
    {
        $this->assertFalse($this->rule->validate('domain-.ru'));
    }

    public function testDash3And4()
    {
        $this->assertFalse($this->rule->validate('do--main.ru'));
    }

    public function testInvalidTLD()
    {
        $this->assertFalse($this->rule->validate('domain.foo'));
    }

    public function testIp()
    {
        $this->assertTrue($this->rule->validate('127.0.0.1'));
    }
}

?>