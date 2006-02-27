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
        $this->assertEqual(realpath(__FILE__), realpath($this->resolver->resolve('cases/resolver/testFileResolver.case.php')));
    }
}

?>