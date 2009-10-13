<?php

fileLoader::load('cache');

class cacheMemoryTest extends unitTestCase
{
    private $cache;

    public function setUp()
    {
        $this->cache = cache::factory('memory', array('memory' => array('backend' => 'memory')));
    }

    public function testGetSet()
    {
        $this->cache->set($identifier = 'baz', $data = 'foobar');
        $this->assertEqual($this->cache->get($identifier), $data);

        $this->cache->set($identifier2 = 'baz2', $data2 = 'foobar2');
        $this->assertEqual($this->cache->get($identifier2), $data2);
    }

    public function testGetNonExistIdentifier()
    {
        $this->assertFalse($this->cache->get('foobar'));
    }

    public function testDrop()
    {
        $this->cache->set($identifier = 'foobar', $data = 'baz');
        $this->assertEqual($this->cache->get($identifier), $data);

        $this->cache->delete($identifier);
        $this->assertFalse($this->cache->get($identifier));
    }

    public function testTags()
    {
        $this->cache->set('key', 'value', array('t1', 't2'));
        $this->assertEqual($this->cache->get('key'), 'value');
        $this->cache->clear('t1');
        $this->assertFalse($this->cache->get('key'));
    }
}

?>