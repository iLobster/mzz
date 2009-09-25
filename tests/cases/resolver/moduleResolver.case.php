<?php

mock::generate('fileResolver');

class moduleResolverTest extends UnitTestCase
{
    public $resolver;
    public $mock;

    public function setUp()
    {
        $this->mock = new mockfileResolver();
        $this->resolver = new moduleResolver($this->mock);
    }

    public function testResolve()
    {
        $this->mock->expectOnce('resolve', array('modules/news/newsListController.php'));
        $this->mock->setReturnValue('resolve', 'resolved_path');

        $this->assertEqual('resolved_path', $this->resolver->resolve('news/newsListController'));
    }

    public function testResolveName()
    {
        $this->mock->expectOnce('resolve', array('modules/news/news.php'));
        $this->mock->setReturnValue('resolve', 'resolved_path');

        $this->assertEqual('resolved_path', $this->resolver->resolve('news'));
    }

    public function testShortResolve()
    {
        $this->mock->expectOnce('resolve', array('modules/news/newsListController.php'));
        $this->mock->setReturnValue('resolve', 'resolved_path');

        $this->assertEqual('resolved_path', $this->resolver->resolve('news/newsListController'));
    }

    public function testFactoryResolve()
    {
        $this->mock->expectOnce('resolve', array('modules/news/newsFactory.php'));
        $this->mock->setReturnValue('resolve', 'resolved_path');

        $this->assertEqual('resolved_path', $this->resolver->resolve('newsFactory'));
    }

    public function testActionIniResolve()
    {
        $this->mock->expectOnce('resolve', array('modules/news/actions.ini'));
        $this->mock->setReturnValue('resolve', 'resolved_path');

        $this->assertEqual('resolved_path', $this->resolver->resolve('news/actions.ini'));
    }
}

?>