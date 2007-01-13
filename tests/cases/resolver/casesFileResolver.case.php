<?php

mock::generate('sysFileResolver');

class casesFileResolverTest extends UnitTestCase
{
    public $resolver;
    public $mock;
    
    public function setUp()
    {
        $this->mock = new mocksysFileResolver();
        $this->resolver = new casesFileResolver($this->mock);
    }
    
    public function testResolve()
    {
        $this->mock->expectOnce('resolve', array('cases/module/name.case.php'));
        $this->mock->setReturnValue('resolve', 'resolved_path');
        
        $this->assertEqual('resolved_path', $this->resolver->resolve('module/name.case'));
    }
}

?>