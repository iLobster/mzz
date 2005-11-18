<?php

require_once '../../system/resolver/fileresolvert.php';

class fileResolverTest extends unitTestCase
{
    public $resolver;
    function setUp()
    {
        $this->resolver = new fileResolver('./cases/resolver/*');
    }
    
    function testResolveExist()
    {
        //$this->resolver->addPattern();
        $this->assertEqual(realpath(dirname(__FILE__) . '/' . basename(__FILE__)), realpath($this->resolver->resolve(basename(__FILE__))));
        $this->resolver->addPattern('./*');
        $this->assertEqual(realpath('./run.php'), realpath($this->resolver->resolve('run.php')));
    }
    
    function testResolveNotExist()
    {
        $this->assertNull($this->resolver->resolve(''));
    }
}

?>