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
        touch(systemConfig::$pathToTemp . '/respond');
    }

    public function tearDown()
    {
        $this->deleteCache();
        unlink(systemConfig::$pathToTemp . '/respond');
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
        $respond_path = systemConfig::$pathToTemp . '/respond';
        $respond_realpath = realpath(systemConfig::$pathToTemp . '/respond');
        $this->mock->expectOnce('resolve', array('/request'));

        $this->mock->setReturnValue('resolve', $respond_path);
        $this->assertEqual($respond_realpath, $this->resolver->resolve('/request'));
        $this->assertEqual($respond_realpath, $this->resolver->resolve('/request'));
        unset($this->resolver);

        $this->assertEqual(unserialize(file_get_contents($this->cacheFile)), array('/request' => $respond_realpath));
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