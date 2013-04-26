<?php

fileLoader::load('orm/mapper');
fileLoader::load('orm/lazy');
fileLoader::load('orm/plugins/identityMapPlugin');

class lazyFoo
{
    public function bar()
    {

    }
}

mock::generate('lazyFoo');

class lazyTest extends unitTestCase
{
    public function testLazyCallbackLoad()
    {
        $mock = new mocklazyFoo();
        $mock->expectOnce('bar', array(
            666));
        $mock->setReturnValue('bar', 'value');

        $lazy = new lazy(array(
            $mock,
            'bar',
            array(
                666)));
        $this->assertEqual($lazy->load(), 'value');
    }
}

?>