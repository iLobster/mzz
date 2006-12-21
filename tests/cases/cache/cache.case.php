<?php

fileLoader::load('cache');

class configTest extends unitTestCase
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
}

?>