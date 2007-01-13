<?php

fileLoader::load('cases/core/testCoreCaseFileResolver');

mock::generate('testCoreCaseFileResolver');

class fileLoaderTest extends unitTestCase
{
    public $resolver;
    public function setUp()
    {
        $this->resolver = new mocktestCoreCaseFileResolver();
        $this->resolver->expectOnce('resolve', array('core/someclassStub'));
        $this->resolver->setReturnValue('resolve', TEST_PATH . '/cases/core/someclassStub.php');
        fileLoader::setResolver($this->resolver);
    }

    public function tearDown()
    {
        fileLoader::restoreResolver();
    }

    public function testResolving()
    {
        $this->assertEqual(fileLoader::resolve('core/someclassStub'),  TEST_PATH . '/cases/core/someclassStub.php');
    }

    public function testLoading()
    {
        $this->assertFalse(
        class_exists('someclassStub'),
        '����� someclassStub �� ������ ���� ��������'
        );

        $this->assertTrue(
        fileLoader::load('core/someclassStub'),
        '����� someclassStub �� ��������'
        );

        $this->assertTrue(
        fileLoader::load('core/someclassStub'),
        '������ ��� ���� ������ ���� �� ������'
        );
    }
}

?>