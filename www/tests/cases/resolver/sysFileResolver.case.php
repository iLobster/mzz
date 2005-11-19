<?php

require_once '../../system/resolver/sysFileResolver.php';

class sysFileResolverTest extends UnitTestCase
{
    public $resolver;
    
    function setUp()
    {
        $this->resolver = new sysFileResolver();
    }
    
    function testResolve()
    {
        $this->assertEqual(realpath(SYSTEM_DIR . 'core/core.php'), realpath($this->resolver->resolve('core/core.php')));
    }
}

?>