<?php

fileLoader::load('orm/mapper');
fileLoader::load('orm/lazy');
fileLoader::load('orm/plugins/identityMapPlugin');

class lazyMapper extends mapper
{
    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'options' => array(
                'pk')));
}

mock::generate('lazyMapper');

mock::generatePartial('lazyMapper', 'partialMockLazyMapper', array(
    'plugin', 'pk'));

mock::generate('identityMapPlugin');

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
        $mock->expectOnce('searchAllByField', array(
            'key',
            'value'));
        $mock->setReturnValue('searchAllByField', $result = new collection(array(), $mock));

        $lazy = new lazy(array(
            $mock,
            'key',
            'value'));
        $result = $lazy->load();

        $this->assertIsA($result, 'collection');
    }

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

    public function testLazyCallIdentityMap()
    {
        $mapper = new partialMockLazyMapper();
        $mapper->setReturnValue('pk', 'id');
        $mapper->plugins('identityMap');

        $im = new mockidentityMapPlugin();
        $im->expectOnce('delay', array('id', 666));

        $mapper->expectOnce('plugin', array('identityMap'));
        $mapper->setReturnValue('plugin', $im, 'identityMap');

        $lazy = new lazy(array($mapper, 'id', 666));
    }
}

?>