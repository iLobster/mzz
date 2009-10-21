<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formUrlRule');

class formUrlRuleTest extends UnitTestCase
{
    private $rule;

    public function setup()
    {
        $this->rule = new formUrlRule();
    }

    public function testSimpleUrl()
    {
        $this->assertTrue($this->rule->validate('http://www.foo.ru'));
    }

    public function testUnknownProtocol()
    {
        $this->assertFalse($this->rule->validate('res://www.foo.ru'));
    }

    public function testHostNameValidation()
    {
        $this->assertFalse($this->rule->validate('http://www.fo--o.ru'));
    }

    public function testFullUrl()
    {
        $url = 'http://www.foo.ru:8022/path/to_script.php?param=1&param2=value#something';
        $this->assertTrue($this->rule->validate($url));
    }
}

?>