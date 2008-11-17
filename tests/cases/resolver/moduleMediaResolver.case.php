<?php

fileLoader::load('resolver/moduleMediaResolver');
mock::generate('sysFileResolver');

class moduleMediaResolverTest extends UnitTestCase
{
    public $resolver;
    public $mock;

    public function setUp()
    {
        $this->mock = new mocksysFileResolver();
        $this->resolver = new moduleMediaResolver($this->mock);
    }

    public function testSimpleCSSResolve()
    {
        $this->mock->expectOnce('resolve', array('modules/news/templates/css/news.css'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToSystem . 'modules/news/templates/css/news.css');

        $this->assertEqual(realpath(systemConfig::$pathToSystem . 'modules/news/templates/css/news.css'), realpath($this->resolver->resolve('news.css')));
    }

    public function testSimpleImageResolve()
    {
        $this->mock->expectOnce('resolve', array('modules/news/templates/img/news.jpg'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToSystem . 'modules/news/templates/img/news.jpg');

        $this->assertEqual(realpath(systemConfig::$pathToSystem . 'modules/news/templates/img/news.jpg'), realpath($this->resolver->resolve('news.jpg')));
    }

    public function testNestedJSResolve()
    {
        $this->mock->expectOnce('resolve', array('modules/news/templates/js/some.js'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToSystem . 'modules/news/templates/js/some.js');

        $this->assertEqual(realpath(systemConfig::$pathToSystem . 'modules/news/templates/js/some.js'), realpath($this->resolver->resolve('news/some.js')));
    }

    public function testUnexpectedFormat()
    {
        try {
            $this->resolver->resolve('more/than/one/slash.css');
            $this->fail('Ожидается исключительная ситуация');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern('#more/than/one#', $e->getMessage());
            $this->pass();
        }
    }

}

?>