<?php

mock::generate('sysFileResolver');

class libResolverTest extends UnitTestCase
{
    public $resolver;
    public $mock;
    
    public function setUp()
    {
        $this->mock = new mocksysFileResolver();
        $this->resolver = new libResolver($this->mock);
    }
    
    public function testResolve()
    {
        $this->mock->expectOnce('resolve', array('../libs/Smarty/Smarty.class.php'));
        $this->mock->setReturnValue('resolve', 'resolved_path');
        
        $this->assertEqual('resolved_path', $this->resolver->resolve('libs/Smarty/Smarty.class'));
    }
    
    
}

?>