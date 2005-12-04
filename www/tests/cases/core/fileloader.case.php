<?php

fileLoader::load('core/fileloader');
fileLoader::load('cases/resolver/testcasefileresolver');

mock::generate('testCaseFileResolver');

class fileLoaderTest extends unitTestCase
{
    public $resolver;
    public function setUp()
    {
        $this->resolver = new mockTestCaseFileResolver();
        $this->resolver->expectOnce('resolve', array('core/someclassStub'));
        $this->resolver->setReturnValue('resolve', './cases/core/someclassStub.php');
        fileLoader::setResolver($this->resolver);
    }
    
    public function tearDown()
    {
        fileLoader::restoreResolver();
    }
    
    public function testResolving()
    {
        $this->assertEqual(realpath(fileLoader::resolve('core/someclassStub')), realpath('./cases/core/someclassStub.php'));
    }

    public function testLoading()
    {
        $this->assertFalse(
        class_exists('someclassStub'),
        'класс someclassStub не должен быть загружен'
        );
        
        $this->assertTrue(
        fileLoader::load('core/someclassStub'),
        'класс someclassStub не загружен'
        );

        $this->assertTrue(
        fileLoader::load('core/someclassStub'),
        'второй раз тоже должно быть всё хорошо'
        );
    }
}

?>