<?php

fileLoader::load('cache');

class cacheFileTest extends unitTestCase
{
    private $cache;

    private $path;

    public function __construct()
    {
        $this->path = dirname(__FILE__) . '/tmp';
        $this->clearDir();
    }

    public function setUp()
    {
        $this->cache = cache::factory('memory', array(
            'memory' => array(
                'backend' => 'file',
                'params' => array(
                    'path' => $this->path,
                    'prefix' => 'case_'))));
    }

    public function tearDown()
    {
        $this->clearDir();
    }

    private function clearDir()
    {
        foreach (glob($this->path . '/*') as $file) {
            unlink($file);
        }
    }

    public function testSimpleSetGet()
    {
        $this->cache->set('key', 'value');
        $this->cache->get('key', $result);
        $this->assertEqual($result, 'value');
    }

    public function testSetGetObject()
    {
        $object = new stdClass();

        $this->cache->set('object', $object);
        $this->cache->get('object', $result);
        $this->assertEqual($result, $object);
    }

    public function testTags()
    {
        $this->cache->set('key_with_tag', 'foo', array('tag1'));
        $this->cache->get('key_with_tag', $result);
        $this->assertEqual($result, 'foo');
        $this->cache->clear('tag1');
        $this->assertFalse($this->cache->get('key_with_tag', $result));
    }
}

?>