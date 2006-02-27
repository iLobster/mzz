<?php

fileLoader::load('resolver/sysFileResolver');

class sysFileResolverTest extends UnitTestCase
{
    public $resolver;
    
    function setUp()
    {
        $this->resolver = new sysFileResolver();
    }
    
    function testResolve()
    {
        $this->assertEqual(realpath(systemConfig::$pathToSystem . 'core/core.php'), realpath($this->resolver->resolve('core/core.php')));
    }
}

?>