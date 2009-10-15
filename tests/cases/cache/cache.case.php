<?php

fileLoader::load('cache');

class cacheTest extends unitTestCase
{
    public function testUnknownConfig()
    {
        $toolkit = systemToolkit::getInstance();
        try {
            $cache = $toolkit->getCache('unknown');
            $this->fail('no exception about unknown cache config');
        } catch (mzzUnknownCacheConfigException $e) {
            $this->pass();
        }
    }

    public function testUnknownBackend()
    {
        $toolkit = systemToolkit::getInstance();
        try {
            $cache = $toolkit->getCache('default', array('default' => array('backend' => 'unknown')));
            $this->fail('no exception about unknown backend');
        } catch (mzzUnknownCacheBackendException $e) {
            $this->pass();
        }
    }

    public function testGetRightCacheBackend()
    {
        $toolkit = systemToolkit::getInstance();

        $cache = $toolkit->getCache('memory', array('memory' => array('backend' => 'memory')));
        $this->assertIsA($cache, 'cache');
    }
}

?>