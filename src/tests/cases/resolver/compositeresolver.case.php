<?php

fileLoader::load('cases/resolver/testCaseFileResolver');

mock::generate('testCaseFileResolver');

class compositeResolverTest extends unitTestCase
{
    public $compositeResolver;
    public $resolver1;
    public $resolver2;
    public function setUp()
    {
        $this->compositeResolver = new compositeResolver();
        $this->resolver1 = new mocktestCaseFileResolver();
        $this->resolver2 = new mocktestCaseFileResolver();

        $this->compositeResolver->addResolver($this->resolver1);
        $this->compositeResolver->addResolver($this->resolver2);
    }

    public function testBothResolves()
    {
        $this->resolver1->expectOnce('resolve', array('request'));
        $this->resolver1->setReturnValue('resolve', 'responsed_by_first');

        $this->resolver2->expectNever('resolve', array('request'));
        $this->resolver2->setReturnValue('resolve', 'responsed_by_second');

        $this->assertEqual($this->compositeResolver->resolve('request'), 'responsed_by_first');
    }

    public function testSecondResolves()
    {
        $this->resolver1->expectOnce('resolve', array('request'));
        $this->resolver1->setReturnValue('resolve', null);

        $this->resolver2->expectOnce('resolve', array('request'));
        $this->resolver2->setReturnValue('resolve', 'responsed_by_second');

        $this->assertEqual($this->compositeResolver->resolve('request'), 'responsed_by_second');
    }
}

?>