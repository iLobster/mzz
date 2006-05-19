<?php
fileLoader::load('cache');

class cacheStub
{
    public function getSection()
    {
    }
    public function getName()
    {
    }
    public function method()
    {
        return 'zzzzzzz';
    }
}

class q
{
    public function getSection()
    {
        return 'stubSection';
    }
    public function getName()
    {
        return 'stubName';
    }
    public function methodToCache()
    {
        return new a(new cacheStub);
    }
}

class a
{
    private $tst;
    public function __construct($strategy)
    {
        $this->tst = $strategy;
    }
    public function z()
    {
        echo $this->tst->method();
    }
}

mock::generate('cacheStub');

class cacheTest extends unitTestCase
{
    private $cache;
    private $mock;

    public function setUp()
    {
        $this->mock = new mockcacheStub();
        $this->mock->setReturnValue('getSection', 'stubSection');
        $this->mock->setReturnValue('getName', 'stubName');

        $this->cache = new cache(systemConfig::$pathToTemp . '/cache');
    }

    public function tearDown()
    {
        $res = scandir($path = systemConfig::$pathToTemp . '/cache/stubSection/stubName/');
        foreach ($res as $val) {
            if (is_file($path . $val)) {
                //unlink($path . $val);
            }
        }
    }

    public function atestObjectMethod()
    {
        $this->mock->expectOnce('method', array($arg = time()));
        $this->mock->setReturnValue('method', $result = 'foo');

        $this->assertEqual($this->cache->call(array($this->mock, 'method'), array($arg)), $result);
        $this->assertEqual($this->cache->call(array($this->mock, 'method'), array($arg)), $result);
    }

    public function atestSetInvalid()
    {
        $arg = time();
        $this->mock->expectCallCount('method', 2);
        $this->mock->setReturnValueAt(0, 'method', $result = 'foo');
        $this->mock->setReturnValueAt(1, 'method', $result2 = 'bar');

        $this->assertEqual($this->cache->call(array($this->mock, 'method'), array($arg)), $result);

        $this->assertTrue($this->cache->setInvalid($this->mock));

        $this->assertEqual($this->cache->call(array($this->mock, 'method'), array($arg)), $result2);
    }
    
    public function testCache()
    {
        $q = new q();
        
        $a = $this->cache->call(array($q, 'methodToCache'));
        $a->z();
        
        $b = $this->cache->call(array($q, 'methodToCache'));
        $b->z();
    }
}

/*
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
        $id = systemConfig::$pathToTemp . '/test_cache.ini';
        $content = "[section1]\r\noption1 = value1\r\noption2 = value2\r\n";

        $file = new SplFileObject($id, "w");
        $file->fwrite($content);


        $this->assertFalse($this->cache->isCached($id));
        $result = parse_ini_file($id, 1);

        $this->cache->save($result, $id);

        $this->assertTrue($this->cache->isCached($id));

        $this->assertIdentical($this->cache->get($id), $result);

        touch($id, time() + 10);

        try {
            $this->assertFalse($this->cache->get($id), $result);
            $this->fail('no exception thrown?');
        } catch (Exception $e) {
            $this->assertPattern("/cache.*?expired/i", $e->getMessage());
            $this->pass();
        }
    }



}
*/
?>