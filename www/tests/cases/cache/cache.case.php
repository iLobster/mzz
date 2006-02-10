<?php
fileLoader::load('cache');

class cacheTest extends unitTestCase
{
    private $cache;

    public function setUp()
    {
        $this->cache = new Cache(systemConfig::$pathToTemp);
    }

    public function tearDown()
    {
        $this->cache->clearCache();
    }

    public function testCache()
    {
        $id = systemConfig::$pathToTemp . 'test_cache.ini';
        $content = "[section1]\r\noption1 = value1\r\noption2 = value2\r\n";

        $file = new SplFileObject($id, "w");
        $file->fwrite($content);


        $this->assertFalse($this->cache->isCached($id));
        $result = parse_ini_file($id, 1);

        $this->cache->save($result, $id);

        $this->assertTrue($this->cache->isCached($id));

        $this->assertIdentical($this->cache->get($id), $result);

        touch($id, time() + 1);

        try {
            $this->assertFalse($this->cache->get($id), $result);
            $this->assertFalse(true, 'no exception thrown?');
        } catch (Exception $e) {
            $this->assertPattern("/cache.*?expired/i", $e->getMessage());
        }
    }



}

?>