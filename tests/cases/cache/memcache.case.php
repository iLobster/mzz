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

            $this->cache->get('blahblah'); // try to get something from the server
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

        $this->cache->flush();
        $this->assertFalse($this->cache->get($identifier));
    }

    public function testTags()
    {
        $this->cache->set('key', 'value', array(
            't1',
            't2'));
        $this->assertEqual($this->cache->get('key'), 'value');
        $this->cache->clear('t1');
        $this->assertFalse($this->cache->get('key'));
    }
}

?>