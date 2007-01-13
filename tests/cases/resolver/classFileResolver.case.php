<?php

mock::generate('sysFileResolver');

class classFileResolverTest extends UnitTestCase
{
    public $resolver;
    public $mock;

    public function setUp()
    {
        $this->mock = new mocksysFileResolver();
        $this->resolver = new classFileResolver($this->mock);
    }

    public function testResolveShort()
    {
        $this->mock->expectOnce('resolve', array('core/core.php'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToSystem . '/core/core.php');

        $this->assertEqual(realpath(systemConfig::$pathToSystem . '/core/core.php'), realpath($this->resolver->resolve('core')));
    }

    public function testResolve()
    {
        $this->mock->expectOnce('resolve', array('core/core.php'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToSystem . '/core/core.php');

        $this->assertEqual(realpath(systemConfig::$pathToSystem . '/core/core.php'), realpath($this->resolver->resolve('core/core')));
    }
}

?>