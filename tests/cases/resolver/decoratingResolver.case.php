<?php

fileLoader::load('cases/resolver/testCaseFileResolver');

mock::generate('testCaseFileResolver');

class StubDecoratingResolver extends decoratingResolver {}
class decoratingResolverTest extends unitTestCase
{
    public $resolver;
    public $mock;

    function setUp()
    {
        $this->mock = new mocktestCaseFileResolver();
        $this->resolver = new StubDecoratingResolver($this->mock);
    }

    function testDecoratingResolve()
    {
        $this->mock->expectOnce('resolve', array('/request'));
        $this->mock->setReturnValue('resolve', '/respond');

        $this->mock->expectOnce('foo', array('/fooRequest'));
        $this->mock->setReturnValue('foo', '/fooRespond');

        $this->assertEqual('/respond', $this->resolver->resolve('/request'));
        $this->assertEqual('/fooRespond', $this->resolver->foo('/fooRequest'));
    }
}

?>