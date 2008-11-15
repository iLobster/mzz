<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formHostnameRule');

class formHostnameRuleTest extends UnitTestCase
{
    public function setup()
    {
        $this->rule = new formHostnameRule('host', '');
    }

    function teardown()
    {
    }

    public function testSimple()
    {
        $this->assertTrue($this->rule->setValue('foo.ru')->validate());
    }

    public function testTooLong()
    {
        $this->assertFalse($this->rule->setValue(str_repeat('a', 300) . '.ru')->validate());
    }

    public function testTooShort()
    {
        $this->assertFalse($this->rule->setValue('ru')->validate());
    }

    public function testInvalidChars()
    {
        $this->assertFalse($this->rule->setValue('домен.ru')->validate());
    }

    public function testDashFirst()
    {
        $this->assertFalse($this->rule->setValue('-domain.ru')->validate());
    }

    public function testDashLast()
    {
        $this->assertFalse($this->rule->setValue('domain-.ru')->validate());
    }

    public function testDash3And4()
    {
        $this->assertFalse($this->rule->setValue('do--main.ru')->validate());
    }

    public function testInvalidTLD()
    {
        $this->assertFalse($this->rule->setValue('domain.foo')->validate());
    }

    public function testIp()
    {
        $this->assertTrue($this->rule->setValue('127.0.0.1')->validate());
    }
}

?>