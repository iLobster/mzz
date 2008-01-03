<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formHostnameRule');

class formHostnamelRuleTest extends UnitTestCase
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

    public function testSimple()
    {
        $_POST['host'] = 'foo.ru';
        $this->request->refresh();

        $rule = new formHostnameRule('host', '');
        $this->assertTrue($rule->validate());
    }

    public function testTooLong()
    {
        $_POST['host'] = str_repeat('a', 300) . '.ru';
        $this->request->refresh();

        $rule = new formHostnameRule('host', '');
        $this->assertFalse($rule->validate());
    }

    public function testTooShort()
    {
        $_POST['host'] = 'ru';
        $this->request->refresh();

        $rule = new formHostnameRule('host', '');
        $this->assertFalse($rule->validate());
    }

    public function testInvalidChars()
    {
        $_POST['host'] = 'домен.ru';
        $this->request->refresh();

        $rule = new formHostnameRule('host', '');
        $this->assertFalse($rule->validate());
    }

    public function testInvalidTLD()
    {
        $_POST['host'] = 'domain.foo';
        $this->request->refresh();

        $rule = new formHostnameRule('host', '');
        $this->assertFalse($rule->validate());
    }
}

?>