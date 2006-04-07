<?php

fileLoader::load('resolver/appFileResolver');

class appFileResolverTest extends UnitTestCase
{
    public $resolver;

    function setUp()
    {
        $this->resolver = new appFileResolver();
    }

    function testResolve()
    {
        $this->assertEqual(realpath(systemConfig::$pathToApplication . '/config.php'), realpath($this->resolver->resolve('config.php')));
    }
}

?>