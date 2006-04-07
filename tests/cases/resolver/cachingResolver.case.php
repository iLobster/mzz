<?php

fileLoader::load('resolver/decoratingResolver');
fileLoader::load('resolver/cachingResolver');

mock::generate('testCaseFileResolver');

class cachingResolverTest extends unitTestCase
{
    private $resolver;
    private $mock;
    private $cacheFile;
    private $mtime;


    public function __construct()
    {
        $this->deleteCache();
        $this->mtime = time() - 10000;
    }

    public function setUp()
    {
        $this->mock = new mocktestCaseFileResolver();
        $this->createResolver();
        $this->cacheFile = systemConfig::$pathToTemp . '/resolver.cache';
    }

    public function tearDown()
    {
        $this->deleteCache();
    }

    public function createResolver()
    {
        $this->resolver = new cachingResolver($this->mock);
    }

    public function deleteCache()
    {
        if(file_exists($this->cacheFile)) {
            unlink($this->cacheFile);
        }
    }

    public function testCachingResolve()
    {
        $this->mock->expectOnce('resolve', array('/request'));
        $this->mock->setReturnValue('resolve', '/respond');

        $this->assertEqual('/respond', $this->resolver->resolve('/request'));
        $this->assertEqual('/respond', $this->resolver->resolve('/request'));
        unset($this->resolver);

        $this->assertEqual(file_get_contents($this->cacheFile), 'a:1:{s:8:"/request";s:8:"/respond";}');
        $this->assertTrue(touch($this->cacheFile, $this->mtime), 'Cannot change mtime for ' . $this->cacheFile);

        clearstatcache();

        $this->createResolver();
        $this->resolver->resolve('/request');
        unset($this->resolver);

        $this->assertTrue(filemtime($this->cacheFile) == $this->mtime, 'Cache file updated');
    }

    public function testCachingResolveUpdated()
    {
        $this->mock->expectOnce('resolve', array('/foo'));
        $this->mock->setReturnValue('resolve', '/bar');
        $this->createResolver();
        $this->resolver->resolve('/foo');
        unset($this->resolver);

        $this->assertFalse(filemtime($this->cacheFile) <= $this->mtime, 'Cache file not updated');
    }
}

?>