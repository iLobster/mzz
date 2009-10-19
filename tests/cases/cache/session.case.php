<?php

fileLoader::load('cache');

class sessionCacheText extends unitTestCase
{
    protected $cache;
    protected $sessionKeyName = '__cache';

    public function __construct()
    {
        $cacheData = array(
            'insession' => array(
                'backend' => 'session',
                'params' => array('session_key' => $this->sessionKeyName)
            )
        );

        $this->cache = cache::factory('insession', $cacheData);
    }

    public function setUp()
    {
        $this->cache->flush();
    }

    public function testSetGet()
    {
        $result = $this->cache->set('cache_key', $cacheString = 'cachemeplease', array(), $expire = 100);
        $this->assertTrue($result);

        $this->cache->get('cache_key', $result);
        $this->assertEqual($cacheString, $result);
    }

    public function testGetNotExists()
    {
        $this->assertFalse($this->cache->get('i-am-not-exists'));
    }

    public function testExpired()
    {
        $cacheKey = 'cacheKey';
        $value = 'i-am-not-long-lived-value';

        $this->cache->set($cacheKey, $value, array(), 1);
        $this->assertTrue($this->cache->get($cacheKey, $result));
        $this->assertEqual($result, $value);
        sleep(2);
        $this->assertFalse($this->cache->get($cacheKey));
    }

    public function testFlush()
    {
        $cacheKey = 'cacheKey';
        $value = 'some-value';

        $result = $this->cache->set($cacheKey, $value, array(), 1);
        $this->assertTrue($result);
        $this->cache->flush();
        $this->assertFalse($this->cache->get($cacheKey));
    }
}

?>