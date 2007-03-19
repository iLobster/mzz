<?php

fileLoader::load('cache');

class cacheTest extends unitTestCase
{
    public function testGetSet()
    {
        $cache = new cache();
        $cache->save($identifier = 'baz', $data = 'foobar');
        $this->assertEqual($cache->load($identifier), $data);

        $cache->save($identifier2 = 'baz2', $data2 = 'foobar2');
        $this->assertEqual($cache->load($identifier2), $data2);
    }

    public function testGetNonExistIdentifier()
    {
        $cache = new cache();
        $this->assertNull($cache->load('foobar'));
    }

    public function testDrop()
    {
        $cache = new cache();
        $cache->save($identifier = 'foobar', $data = 'baz');
        $this->assertEqual($cache->load($identifier), $data);

        $cache->drop();
        $this->assertNull($cache->load($identifier));
    }
}

?>