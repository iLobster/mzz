<?php

fileLoader::load('orm/mapper');
fileLoader::load('orm/lazy');

class lazyMapper extends mapper
{

}

mock::generate('lazyMapper');

class lazyFoo
{
    public function bar()
    {

    }
}

mock::generate('lazyFoo');

class lazyTest extends unitTestCase
{
    public function testLazyMapperLoad()
    {
        $mock = new mocklazyMapper();
        $mock->expectOnce('searchAllByField', array('key', 'value'));
        $mock->setReturnValue('searchAllByField', $result = new collection(array(), $mock));

        $lazy = new lazy(array($mock, 'key', 'value'));
        $result = $lazy->load();

        $this->assertIsA($result, 'collection');
    }

    public function testLazyCallbackLoad()
    {
        $mock = new mocklazyFoo();
        $mock->expectOnce('bar', array(666));
        $mock->setReturnValue('bar', 'value');

        $lazy = new lazy(array($mock, 'bar', array(666)));
        $this->assertEqual($lazy->load(), 'value');
    }
}

?>