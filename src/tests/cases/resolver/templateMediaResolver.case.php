<?php

fileLoader::load('resolver/templateMediaResolver');
mock::generate('fileResolver');

class templateMediaResolverTest extends UnitTestCase
{
    public $resolver;
    public $mock;

    public function setUp()
    {
        $this->mock = new mockfileResolver();
        $this->resolver = new templateMediaResolver($this->mock);
    }

    public function testSimpleCSSResolve()
    {
        $this->mock->expectOnce('resolve', array('css/news.css'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToWebRoot . '/css/news.css');

        $this->assertEqual(systemConfig::$pathToWebRoot . '/css/news.css', $this->resolver->resolve('news.css'));
    }

    public function testSimpleImageResolve()
    {
        $this->mock->expectOnce('resolve', array('images/news.jpg'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToWebRoot . '/images/news.jpg');

        $this->assertEqual(systemConfig::$pathToWebRoot . '/images/news.jpg', $this->resolver->resolve('news.jpg'));
    }

    public function testNestedJSResolve()
    {
        $this->mock->expectOnce('resolve', array('js/news/some.js'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToSystem . '/js/news/some.js');

        $this->assertEqual(systemConfig::$pathToSystem . '/js/news/some.js', $this->resolver->resolve('news/some.js'));
    }

    public function testDeepNestedMedia()
    {
        $this->mock->expectOnce('resolve', array('js/module/one/two/three/file.js'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToSystem . '/js/module/one/two/three/file.js');

        $this->assertEqual(systemConfig::$pathToSystem . '/js/module/one/two/three/file.js', $this->resolver->resolve('module/one/two/three/file.js'));
    }
}

?>