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

        $this->cache = systemToolkit::getInstance()->getCache('insession', $cacheData);
    }

    public function setUp()
    {
        $this->cache->flush();
    }

    public function testSetGet()
    {
        $result = $this->cache->set('cache_key', $cacheString = 'cachemeplease', array(), $expire = 100);
        $this->assertTrue($result);

        $resultString = $this->cache->get('cache_key');
        $this->assertEqual($cacheString, $resultString);
    }

    public function testGetNotExists()
    {
        $result = $this->cache->get('i-am-not-exists');
        $this->assertNull($result);
    }

    public function testExpired()
    {
        $cacheKey = 'cacheKey';
        $value = 'i-am-not-long-lived-value';

        $this->cache->set($cacheKey, $value, array(), 1);
        $this->assertEqual($this->cache->get($cacheKey), $value);
        sleep(2);
        $this->assertNull($this->cache->get($cacheKey));
    }

    public function testFlush()
    {
        $cacheKey = 'cacheKey';
        $value = 'some-value';

        $result = $this->cache->set($cacheKey, $value, array(), 1);
        $this->assertTrue($result);
        $this->cache->flush();
        $this->assertNull($this->cache->get($cacheKey));
    }
}

?>