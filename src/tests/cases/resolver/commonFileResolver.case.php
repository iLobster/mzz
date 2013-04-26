<?php

mock::generate('fileResolver');

class commonFileResolverTest extends UnitTestCase
{
    public $resolver;
    public $mock;

    public function setUp()
    {
        $this->mock = new mockfileResolver();
        $this->resolver = new commonFileResolver($this->mock);
    }

    public function testResolveConfig()
    {
        $this->mock->expectOnce('resolve', array(
            'configs/common.ini'));
        $this->mock->setReturnValue('resolve', 'resolved_path');

        $this->assertEqual('resolved_path', $this->resolver->resolve('configs/common.ini'));
    }

    public function testNotResolveConfig()
    {
        $this->mock->expectOnce('resolve', array(
            null));
        $this->mock->setReturnValue('resolve', null);

        $this->assertNull($this->resolver->resolve('aconfigs/common.ini'));
    }

    public function testResolveTemplate()
    {
        $this->mock->expectOnce('resolve', array(
            '/modules/user/templates/list.tpl'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToSystem . '/modules/user/templates/list.tpl');

        $this->assertEqual(realpath(systemConfig::$pathToSystem . '/modules/user/templates/list.tpl'), realpath($this->resolver->resolve('user/list.tpl')));
    }

    public function testSimpleResolveTemplate()
    {
        $this->mock->expectOnce('resolve', array(
            '/modules/simple/templates/jip.tpl'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToSystem . '/modules/simple/templates/jip.tpl');

        $this->assertEqual(systemConfig::$pathToSystem . '/modules/simple/templates/jip.tpl', $this->resolver->resolve('jip.tpl'));
    }

    public function testResolveLib()
    {
        $this->mock->expectOnce('resolve', array(
            '../libs/Smarty/Smarty.class.php'));
        $this->mock->setReturnValue('resolve', 'resolved_path');

        $this->assertEqual('resolved_path', $this->resolver->resolve('libs/Smarty/Smarty.class'));
    }
}

?>