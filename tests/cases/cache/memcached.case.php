<?php

fileLoader::load('cache');

class memcachedTest extends unitTestCase
{
    public function testGetSet()
    {
        $cache = cache::factory('memcached');
        $cache->set($identifier = 'baz', $data = 'foobar');
        $this->assertEqual($cache->get($identifier), $data);

        $cache->set($identifier2 = 'baz2', $data2 = 'foobar2');
        $this->assertEqual($cache->get($identifier2), $data2);
    }

    public function testGetNonExistIdentifier()
    {
        $cache = cache::factory('memory');
        $this->assertFalse($cache->get('foobar'));
    }

    public function testDrop()
    {
        $cache = cache::factory('memory');
        $cache->set($identifier = 'foobar', $data = 'baz');
        $this->assertEqual($cache->get($identifier), $data);

        $cache->flush();
        $this->assertFalse($cache->get($identifier));
    }
}

?>