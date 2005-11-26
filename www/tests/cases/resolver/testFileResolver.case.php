<?php

class testFileResolverTest extends UnitTestCase
{
    public $resolver;
    
    function setUp()
    {
        $this->resolver = new testFileResolver();
    }
    
    function testResolve()
    {
        $this->assertEqual(realpath(APPLICATION_DIR . 'tests/cases/resolver/testFileResolver.case.php'), realpath($this->resolver->resolve('cases/resolver/testFileResolver.case.php')));
    }
}

?>