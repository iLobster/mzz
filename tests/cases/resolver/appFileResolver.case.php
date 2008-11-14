<?php

class appFileResolverTest extends UnitTestCase
{
    public $resolver;

    function setUp()
    {
        $this->resolver = new appFileResolver();
    }

    function testResolve()
    {
        $this->assertEqual(realpath(systemConfig::$pathToApplication . '/configs/config.php'), realpath($this->resolver->resolve('configs/config.php')));
    }
}

?>