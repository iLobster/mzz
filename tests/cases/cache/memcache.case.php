<?php

fileLoader::load('cache');

class memcachedTest extends unitTestCase
{
    /**
     * @var cacheMemcache
     */
    private $cache;

    public function setUp()
    {
        $this->cache = cache::factory('memcache', array(
            'memcache' => array(
                'backend' => 'memcache')));
        $this->flush();
    }

    public function tearDown()
    {
        $this->flush();
    }

    private function flush()
    {
        $this->cache->flush();
    }

    public function skip()
    {
        $this->skipIf($skip = !extension_loaded('memcache'), 'Memcache extension not found. Test skipped.');
        $this->skipIf($skip = !class_exists('Memcache'), 'Memcache class not found. Test skipped.');

        if (!$skip) {
            $this->setUp();

            $this->cache->get('blahblah', $result); // try to get something from the server
            $this->skipIf(!$this->cache->backend()->getStatus(cacheMemcache::DEFAULT_HOST, cacheMemcache::DEFAULT_PORT), 'memcached connect error');
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
        $this->assertTrue($this->cache->set($identifier = 'baz', $data = 'foobar'));
        $this->cache->get($identifier, $result);
        $this->assertEqual($result, $data);

        $this->cache->set($identifier2 = 'baz2', $data2 = 'foobar2');
        $this->cache->get($identifier2, $result);
        $this->assertEqual($result, $data2);
    }

    public function testGetNonExistIdentifier()
    {
        $this->assertFalse($this->cache->get('foobar'));
    }

    public function testNullAndFasleValue()
    {
        $this->cache->set('foo', false);
        $this->assertTrue($this->cache->get('foo', $result));
        $this->assertIdentical($result, false);
        $this->assertFalse($this->cache->get('bar', $result));
        $this->assertIdentical($result, null);
    }

    public function testDrop()
    {
        $this->cache->set($identifier = 'foobar', $data = 'baz');
        $this->cache->get($identifier, $result);
        $this->assertEqual($result, $data);

        $this->cache->flush();
        $this->assertFalse($this->cache->get($identifier));
    }

    public function testTags()
    {
        $this->cache->set('key', 'value', array(
            't1',
            't2'));
        $this->cache->get('key', $result);
        $this->assertEqual($result, 'value');
        $this->cache->clear('t1');
        $this->assertFalse($this->cache->get('key'));
    }
}

?>