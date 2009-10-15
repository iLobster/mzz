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
        $this->cache = systemToolkit::getInstance()->getCache('memory', array(
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
        $this->assertEqual($this->cache->get('key'), 'value');
    }

    public function testSetGetObject()
    {
        $object = new stdClass();

        $this->cache->set('object', $object);
        $this->assertEqual($this->cache->get('object'), $object);
    }

    public function testTags()
    {
        $this->cache->set('key_with_tag', 'foo', array('tag1'));
        $this->assertEqual($this->cache->get('key_with_tag'), 'foo');
        $this->cache->clear('tag1');
        $this->assertFalse($this->cache->get('key_with_tag'));
    }
}

?>