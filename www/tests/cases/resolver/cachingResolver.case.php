<?php

//require_once '../../system/core/fileloader.php';

fileLoader::load('core/Fs');
fileLoader::load('resolver/decoratingResolver');
fileLoader::load('resolver/cachingResolver');


mock::generate('testCaseFileResolver');

class cachingResolverTest extends unitTestCase
{
    public $resolver;
    public $mock;

    function setUp()
    {
        $this->mock = new mocktestCaseFileResolver();
        @unlink(systemConfig::$pathToTemp . 'resolver.cache');
        $this->resolver = new cachingResolver($this->mock);
    }

    function testCachingResolve()
    {
        $this->mock->expectOnce('resolve', array('/request'));
        $this->mock->setReturnValue('resolve', '/respond');

        $this->assertEqual('/respond', $this->resolver->resolve('/request'));
        $this->assertEqual('/respond', $this->resolver->resolve('/request'));
        unset($this->resolver);
        $this->assertEqual(file_get_contents(systemConfig::$pathToTemp . 'resolver.cache'), 'a:1:{s:8:"/request";s:8:"/respond";}');
        @unlink(TEMP_DIR . 'resolver.cache');
    }
}

?>