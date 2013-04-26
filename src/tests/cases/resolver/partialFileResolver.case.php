<?php

fileLoader::load('cases/resolver/testCaseFileResolver');

mock::generate('testCaseFileResolver');

class partialFileResolverTest extends unitTestCase
{
    public $resolver;
    public $mock;
    
    function setUp()
    {
        $this->mock = new mocktestCaseFileResolver();
        $this->resolver = new partialFileResolver($this->mock);
    }
    
    function testPartialResolve()
    {
        $this->mock->expectOnce('resolve', array('/request'));
        $this->mock->setReturnValue('resolve', '/respond');
        
        $this->assertEqual('/respond', $this->resolver->resolve('/request'));
    }
}

?>