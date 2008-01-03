<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formEmailRule');

class formEmailRuleTest extends UnitTestCase
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
        $_POST['host'] = 'name@domain.ru';
        $this->request->refresh();

        $rule = new formEmailRule('host', '');
        $this->assertTrue($rule->validate());
    }

    public function testNoAtChar()
    {
        $_POST['host'] = 'namedomain.ru';
        $this->request->refresh();

        $rule = new formEmailRule('host', '');
        $this->assertFalse($rule->validate());
    }

    public function testInvalidDomain()
    {
        $_POST['host'] = 'name@-domain.ru';
        $this->request->refresh();

        $rule = new formEmailRule('host', '');
        $this->assertFalse($rule->validate());
    }

    public function testInvalidName()
    {
        $_POST['host'] = 'мззname@domain.ru';
        $this->request->refresh();

        $rule = new formEmailRule('host', '');
        $this->assertFalse($rule->validate());
    }
}

?>