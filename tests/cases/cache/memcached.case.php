<?php

fileLoader::load('cache');

class memcachedTest extends unitTestCase
{
    public function skip()
    {
        $this->skipIf(!extension_loaded('memcache'), 'Memcache extension not found. Test skipped.');
        $this->skipIf(!class_exists('Memcache'), 'Memcache class not found. Test skipped.');
    }

    public function testGetSet()
    {
        $cache = $this->_createCache();
        $cache->set($identifier = 'baz', $data = 'foobar');
        $this->assertEqual($cache->get($identifier), $data);

        $cache->set($identifier2 = 'baz2', $data2 = 'foobar2');
        $this->assertEqual($cache->get($identifier2), $data2);
    }

    public function testGetNonExistIdentifier()
    {
        $cache = $this->_createCache();
        $this->assertFalse($cache->get('foobar'));
    }

    public function testDrop()
    {
        $cache = $this->_createCache();
        $cache->set($identifier = 'foobar', $data = 'baz');
        $this->assertEqual($cache->get($identifier), $data);

        $cache->flush();
        $this->assertFalse($cache->get($identifier));
    }

    public function _createCache()
    {
        return cache::factory('memcached', array('memcached' => array('backend' => 'memcached')));
    }
}

?>