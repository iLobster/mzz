<?php
fileLoader::load('cache');

class cacheStub implements iCacheable
{
    public function isCacheable($method)
    {
        $arr = array('method');
        return in_array($method, $arr);
    }
    public function section()
    {
    }
    public function name()
    {
    }
    public function method()
    {
    }
    public function notCache()
    {
    }
    public function injectCache($cache)
    {
    }
}

mock::generate('cacheStub');

class cacheTest extends unitTestCase
{
    private $cache;
    private $mock;
    private $db;

    public function setUp()
    {
        $this->mock = new mockcacheStub();
        $this->mock->setReturnValue('section', 'stubSection');
        $this->mock->setReturnValue('name', 'stubName');
        $this->mock->setReturnValue('isCacheable', true, array('method'));
        $this->mock->setReturnValue('isCacheable', false, array('*'));
        $this->db = db::factory();

        $this->clearDb();
        $this->db->exec("INSERT INTO `sys_cfg` VALUES(1, '', 'common')");
        $this->db->exec("INSERT INTO `sys_cfg_values` VALUES(1, 1, 'cache', 'true')");

        $this->cache = new cache($this->mock, systemConfig::$pathToTemp . '/cache');
    }

    public function tearDown()
    {
        if(is_dir(systemConfig::$pathToTemp . '/cache/stubSection/stubName/')) {
            $res = scandir($path = systemConfig::$pathToTemp . '/cache/stubSection/stubName/');
            foreach ($res as $val) {
                if (is_file($path . $val)) {
                    unlink($path . $val);
                }
            }
            rmdir(systemConfig::$pathToTemp . '/cache/stubSection/stubName');
            rmdir(systemConfig::$pathToTemp . '/cache/stubSection');
        }
        $this->clearDb();
    }

    public function testObjectMethod()
    {
        $this->mock->expectOnce('method', array());
        $this->mock->setReturnValue('method', $result = 'foo');

        $this->assertEqual($this->cache->method(), $result);
        $this->assertEqual($this->cache->method(), $result);
    }

    public function testSetInvalid()
    {
        $arg = 'q';
        $this->mock->expectCallCount('method', 2);
        $this->mock->setReturnValueAt(0, 'method', $result = 'result1');
        $this->mock->setReturnValueAt(1, 'method', $result2 = 'result2');

        $this->assertEqual($this->cache->method($arg), $result);

        $this->assertTrue($this->cache->setInvalid());

        $this->assertEqual($this->cache->method($arg), $result2);
    }

    public function testNotCacheable()
    {
        $this->mock->expectCallCount('notCache', 2);
        $this->mock->setReturnValueAt(0, 'notCache', $result = 'result1');
        $this->mock->setReturnValueAt(1, 'notCache', $result2 = 'result2'); 

        $this->assertEqual($this->cache->notCache(), $result);
        $this->assertEqual($this->cache->notCache(), $result2);
    }

    private function clearDb()
    {
        $this->db->query('TRUNCATE TABLE `sys_cfg`');
        $this->db->query('TRUNCATE TABLE `sys_cfg_values`');
    }
}

?>