<?php

mock::generate('sysFileResolver');

class configFileResolverTest extends UnitTestCase
{
    public $resolver;
    public $mock;
    
    public function setUp()
    {
        $this->mock = new mocksysFileResolver();
        $this->resolver = new configFileResolver($this->mock);
    }
    
    public function testResolve()
    {
        $this->mock->expectOnce('resolve', array('configs/common.ini'));
        $this->mock->setReturnValue('resolve', 'resolved_path');
        
        $this->assertEqual('resolved_path', $this->resolver->resolve('configs/common.ini'));
    }
    
    public function testNotResolve()
    {
        $this->mock->expectOnce('resolve', array(null));
        $this->mock->setReturnValue('resolve', null);
        
        $this->assertNull($this->resolver->resolve('aconfigs/common.ini'));
    }
}

?>