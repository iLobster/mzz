<?php
fileLoader::load('cache');

class cacheStub
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
    public function setCache()
    {
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
        $this->mock->setReturnValue('section', 'stubSection');
        $this->mock->setReturnValue('name', 'stubName');
        $this->mock->setReturnValue('isCacheable', true, array('method'));
        $this->mock->setReturnValue('isCacheable', false, array('*'));

        $this->cache = new cache($this->mock, systemConfig::$pathToTemp . '/cache');
    }

    public function tearDown()
    {
        $res = scandir($path = systemConfig::$pathToTemp . '/cache/stubSection/stubName/');
        foreach ($res as $val) {
            if (is_file($path . $val)) {
                unlink($path . $val);
            }
        }
    }

    public function testObjectMethod()
    {
        $this->mock->expectOnce('method', array());
        $this->mock->setReturnValue('method', $result = 'foo');


        $this->assertTrue($this->cache->setInvalid());
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
}

?>