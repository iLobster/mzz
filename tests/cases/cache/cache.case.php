<?php

fileLoader::load('cache');

class cacheTest extends unitTestCase
{
    public function testUnknownConfig()
    {
        try {
            $cache = cache::factory('unknown');
            $this->fail('no exception about unknown cache config');
        } catch (mzzUnknownCacheConfigException $e) {
            $this->pass();
        }
    }

    public function testUnknownBackend()
    {
        try {
            $cache = cache::factory('default', array('default' => array('backend' => 'unknown')));
            $this->fail('no exception about unknown backend');
        } catch (mzzUnknownCacheBackendException $e) {
            $this->pass();
        }
    }

    public function testGetRightCacheBackend()
    {
        $cache = cache::factory('memory', array('memory' => array('backend' => 'memory')));
        $this->assertIsA($cache, 'cache');
    }
}

?>