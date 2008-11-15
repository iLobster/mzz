<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formUrlRule');

class formUrlRuleTest extends UnitTestCase
{
    private $rule;

    public function setup()
    {
        $this->rule = new formUrlRule('url', '');
    }

    function teardown()
    {
    }

    public function testSimpleUrl()
    {
        $this->assertTrue($this->rule->setValue('http://www.foo.ru')->validate());
    }

    public function testUnknownProtocol()
    {
        $this->assertFalse($this->rule->setValue('res://www.foo.ru')->validate());
    }

    public function testHostNameValidation()
    {
        $this->assertFalse($this->rule->setValue('http://www.fo--o.ru')->validate());
    }

    public function testFullUrl()
    {
        $url = 'http://www.foo.ru:8022/path/to_script.php?param=1&param2=value#something';
        $this->assertTrue($this->rule->setValue($url)->validate());
    }
}

?>