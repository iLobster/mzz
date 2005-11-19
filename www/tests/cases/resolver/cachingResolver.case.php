<?php

require_once '../../system/core/fileloader.php';
require_once '../../system/core/Fs.php';
require_once '../../system/resolver/decoratingResolver.php';
require_once '../../system/resolver/cachingResolver.php';

mock::generate('testCaseFileResolver');

class cachingResolverTest extends unitTestCase
{
    public $resolver;
    public $mock;

    function setUp()
    {
        $this->mock = new mocktestCaseFileResolver();
        @unlink(TEMP_DIR . 'resolver.cache');
        $this->resolver = new cachingResolver($this->mock);
    }

    function testCachingResolve()
    {
        $this->mock->expectOnce('resolve', array('/request'));
        $this->mock->setReturnValue('resolve', '/respond');

        $this->assertEqual('/respond', $this->resolver->resolve('/request'));
        $this->assertEqual('/respond', $this->resolver->resolve('/request'));
        unset($this->resolver);
        $this->assertEqual(file_get_contents(TEMP_DIR . 'resolver.cache'), 'a:1:{s:8:"/request";s:8:"/respond";}');
        @unlink(TEMP_DIR . 'resolver.cache');
    }
}

?>