<?php

fileLoader::load('resolver/templateMediaResolver');
mock::generate('sysFileResolver');

class templateMediaResolverTest extends UnitTestCase
{
    public $resolver;
    public $mock;

    public function setUp()
    {
        $this->mock = new mocksysFileResolver();
        $this->resolver = new templateMediaResolver($this->mock);
    }

    public function testSimpleCSSResolve()
    {
        $this->mock->expectOnce('resolve', array('templates/css/news.css'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToApplication . '/templates/css/news.css');

        $this->assertEqual(systemConfig::$pathToApplication . '/templates/css/news.css', $this->resolver->resolve('news.css'));
    }

    public function testSimpleImageResolve()
    {
        $this->mock->expectOnce('resolve', array('templates/images/news.jpg'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToApplication . '/templates/images/news.jpg');

        $this->assertEqual(systemConfig::$pathToApplication . '/templates/images/news.jpg', $this->resolver->resolve('news.jpg'));
    }

    public function testNestedJSResolve()
    {
        $this->mock->expectOnce('resolve', array('templates/js/news/some.js'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToSystem . '/templates/js/news/some.js');

        $this->assertEqual(systemConfig::$pathToSystem . '/templates/js/news/some.js', $this->resolver->resolve('news/some.js'));
    }

    public function testDeepNestedMedia()
    {
        $this->mock->expectOnce('resolve', array('templates/js/module/one/two/three/file.js'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToSystem . '/templates/js/module/one/two/three/file.js');

        $this->assertEqual(systemConfig::$pathToSystem . '/templates/js/module/one/two/three/file.js', $this->resolver->resolve('module/one/two/three/file.js'));
    }
}

?>