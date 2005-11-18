<?php

require_once '../../system/core/fileloader.php';
//require_once '../../system/resolver/fileresolvert.php';
require_once './cases/resolver/testcasefileresolver.php';

mock::generate('testCaseFileResolver');

class fileLoaderTest extends unitTestCase
{
    public $resolver;
    public function setUp()
    {
        $this->resolver = new mockTestCaseFileResolver();
        fileLoader::setResolver($this->resolver);
    }
    public function testResolving()
    {
        $this->resolver->expectOnce('resolve', array('core/someclassStub'));
        $this->resolver->setReturnValue('resolve', './cases/core/someclassStub.php');
        $this->assertEqual(realpath(fileLoader::resolve('core/someclassStub')), realpath('./cases/core/someclassStub.php'));
    }

    public function testLoading()
    {
        $this->assertFalse(
        class_exists('someclassStub'),
        'класс someclassStub не должен быть загружен'
        );
        $this->assertTrue(
        fileLoader::load('someclassStub'),
        'класс someclassStub не загружен'
        );
    }
}

?>