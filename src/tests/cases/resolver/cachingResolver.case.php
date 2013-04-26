<?php

fileLoader::load('cases/resolver/testCaseFileResolver');

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
        foreach (glob(systemConfig::$pathToTemp . '/cache/*') as $file) {
            unlink($file);
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

        clearstatcache();

        $this->createResolver();
        $this->resolver->resolve('/request');
        unset($this->resolver);
    }

    public function testCachingResolveUpdated()
    {
        $this->mock->expectOnce('resolve', array('/foo'));
        $this->mock->setReturnValue('resolve', '/bar');
        $this->createResolver();
        $this->resolver->resolve('/foo');
        unset($this->resolver);
    }
}

?>