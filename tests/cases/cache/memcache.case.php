<?php

fileLoader::load('cache');

class memcachedTest extends unitTestCase
{
    public function skip()
    {
        $this->skipIf($skip = !extension_loaded('memcache'), 'Memcache extension not found. Test skipped.');
        $this->skipIf($skip = !class_exists('Memcache'), 'Memcache class not found. Test skipped.');

        if (!$skip) {
            $this->_createCache()->get('blahblah'); // try to get something from the server
            $this->skipIf(!$this->_createCache()->getStatus(cacheMemcache::DEFAULT_HOST, cacheMemcache::DEFAULT_PORT), 'memcached connect error');
        }
        /*
        try {
            $this->_createCache();
        } catch (mzzException $e) {
            $this->skipIf(true, $e->getMessage());
        }
        */
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
        return cache::factory('memcache', array('memcache' => array('backend' => 'memcache')));
    }
}

?>