<?php

fileLoader::load('resolver/templateResolver');
mock::generate('sysFileResolver');

class templateResolverTest extends UnitTestCase
{
    public $resolver;
    public $mock;

    public function setUp()
    {
        $this->mock = new mocksysFileResolver();
        $this->resolver = new templateResolver($this->mock);
    }

    public function testResolve()
    {
        $this->mock->expectOnce('resolve', array('/modules/user/templates/list.tpl'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToSystem . '/modules/user/templates/list.tpl');

        $this->assertEqual(realpath(systemConfig::$pathToSystem . '/modules/user/templates/list.tpl'), realpath($this->resolver->resolve('user/list.tpl')));
    }

    public function testSimpleResolve()
    {
        $this->mock->expectOnce('resolve', array('/modules/simple/templates/jip.tpl'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToSystem . '/modules/simple/templates/jip.tpl');

        $this->assertEqual(systemConfig::$pathToSystem . '/modules/simple/templates/jip.tpl', $this->resolver->resolve('jip.tpl'));
    }
}

?>