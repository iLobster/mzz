<?php

fileLoader::load('cache');

class memoryTest extends unitTestCase
{
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
        return cache::factory('memory', array('memory' => array('backend' => 'memory')));
    }
}

?>