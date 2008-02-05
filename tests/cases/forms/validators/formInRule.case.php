<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formInRule');

class formInRuleTest extends UnitTestCase
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

    public function testIn()
    {
        $_POST['foo'] = 'bar';
        $this->request->refresh();

        $rule = new formInRule('foo', '', array('bar', 'baz'));
        $this->assertTrue($rule->validate());
    }

    public function testInWithKeys()
    {
        $_POST['foo'] = 'bar';
        $this->request->refresh();

        $rule = new formInRule('foo', '', array('somekey' => 'bar', 'baz'));
        $this->assertTrue($rule->validate());
    }

    public function testNotIn()
    {
        $_POST['foo'] = 'foobar';
        $this->request->refresh();

        $rule = new formInRule('foo', '', array('bar', 'baz'));
        $this->assertFalse($rule->validate());
    }

    public function testNotArray()
    {
        $_POST['foo'] = 'foobar';
        $this->request->refresh();

        $rule = new formInRule('foo', '', 'string');

        try {
            $rule->validate();
            $this->fail('Должно быть брошено исключение');
        } catch (mzzInvalidParameterException $e) {
            $this->pass();
        }
    }
}

?>