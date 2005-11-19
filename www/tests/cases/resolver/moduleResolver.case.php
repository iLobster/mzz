<?php

require_once '../../system/resolver/moduleResolver.php';

mock::generate('sysFileResolver');

class moduleResolverTest extends UnitTestCase
{
    public $resolver;
    public $mock;
    
    public function setUp()
    {
        $this->mock = new mocksysFileResolver();
        $this->resolver = new moduleResolver($this->mock);
    }
    
    public function testResolve()
    {
        $this->mock->expectOnce('resolve', array('modules/news/news.list.controller.php'));
        $this->mock->setReturnValue('resolve', 'resolved_path');
        
        $this->assertEqual('resolved_path', $this->resolver->resolve('news/news.list.controller'));
    }
    
    public function testShortResolve()
    {
        $this->mock->expectOnce('resolve', array('modules/news/news.list.controller.php'));
        $this->mock->setReturnValue('resolve', 'resolved_path');
        
        $this->assertEqual('resolved_path', $this->resolver->resolve('news.list.controller'));
    }
    
    public function testFactoryResolve()
    {
        $this->mock->expectOnce('resolve', array('modules/news/news.factory.php'));
        $this->mock->setReturnValue('resolve', 'resolved_path');
        
        $this->assertEqual('resolved_path', $this->resolver->resolve('news.factory'));
    }
}

?>