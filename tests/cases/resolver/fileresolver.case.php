<?php

class fileResolverTest extends unitTestCase
{
    public $resolver;
    function setUp()
    {
        $this->resolver = new fileResolver(realpath(dirname(__FILE__)) . '/*');
    }

    function testResolveExist()
    {
        $this->assertEqual(realpath(dirname(__FILE__) . '/' . basename(__FILE__)), realpath($this->resolver->resolve(basename(__FILE__))));
    }

    function testResolveNotExist()
    {
        $this->assertNull($this->resolver->resolve(''));
    }
}

?>