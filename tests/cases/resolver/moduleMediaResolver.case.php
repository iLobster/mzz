<?php

fileLoader::load('resolver/moduleMediaResolver');
fileLoader::load('resolver/extensionBasedModuleMediaResolver');
mock::generate('fileResolver');

class moduleMediaResolverTest extends UnitTestCase
{
    public $resolver;
    public $resolverExt;
    public $mock;

    public function setUp()
    {
        $this->mock = new mockfileResolver();
        $this->resolver = new moduleMediaResolver($this->mock);
        $this->resolverExt = new extensionBasedModuleMediaResolver($this->mock);
    }

    public function testSimpleCSSResolve()
    {
        $this->mock->expectOnce('resolve', array('modules/news/templates/css/news.css'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToSystem . 'modules/news/templates/css/news.css');

        $this->assertEqual(systemConfig::$pathToSystem . 'modules/news/templates/css/news.css', $this->resolverExt->resolve('news.css'));
    }

    public function testSimpleImageResolve()
    {
        $this->mock->expectOnce('resolve', array('modules/news/templates/images/news.jpg'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToSystem . 'modules/news/templates/images/news.jpg');

        $this->assertEqual(systemConfig::$pathToSystem . 'modules/news/templates/images/news.jpg', $this->resolverExt->resolve('news.jpg'));
    }

    public function testNestedJSResolve()
    {
        $this->mock->expectOnce('resolve', array('modules/news/templates/js/some.js'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToSystem . 'modules/news/templates/js/some.js');

        $this->assertEqual(systemConfig::$pathToSystem . 'modules/news/templates/js/some.js', $this->resolverExt->resolve('news/some.js'));
    }

    public function testNestedJSResolveByExtIndependentResolver()
    {
        $this->mock->expectOnce('resolve', array('modules/news/templates/some.js'));
        $this->mock->setReturnValue('resolve', systemConfig::$pathToSystem . 'modules/news/templates/some.js');

        $this->assertEqual(systemConfig::$pathToSystem . 'modules/news/templates/some.js', $this->resolver->resolve('news/some.js'));
    }

    public function testSimpleExtIndependentResolver()
    {
        $this->mock->expectOnce('resolve', array(null));
        $this->mock->setReturnValue('resolve', null);

        $this->assertEqual(null, $this->resolver->resolve('file.js'));
    }
}

?>