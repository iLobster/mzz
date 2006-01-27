<?php
fileLoader::load('core/sectionMapper');

fileLoader::load('request/httpRequest');
fileLoader::load('request/rewrite');

mock::generate('httpRequest');
mock::generate('rewrite');


class sectionMapperTest extends unitTestCase
{
    private $mapper;
    private $oldToolkit;
    private $toolkit;
    public function setUp()
    {
        $this->mapper = new sectionMapper(fileLoader::resolve('configs/map.xml'));
        $this->toolkit = systemToolkit::getInstance();

    }

    public function tearDown()
    {

    }

    public function testSectionMapper()
    {

        $request = new mockhttpRequest();
        $request->expectOnce('getSection', array());
        $request->setReturnValue('getSection', 'test');
        $request->expectOnce('getAction', array());
        $request->setReturnValue('getAction', 'foo');
        $old_request = $this->toolkit->setRequest($request);

        $this->assertEqual($this->mapper->getTemplateName(), "act.test.foo.tpl");

        $this->toolkit->setRequest($old_request);

    }

    public function testMappingFalseRewriteTrue()
    {
        $request = new mockhttpRequest();
        $request->expectCallCount('getSection', 2);
        $request->setReturnValue('getSection', 'test');
        $request->expectCallCount('getAction', 2);
        $request->setReturnValueAt(0, 'getAction', 'abc');
        $request->setReturnValueAt(1, 'getAction', 'foo');
        $request->expectOnce('get', array('path'));
        $request->setReturnValue('get', 'test.abc');
        $request->expectOnce('parse', array('test.foo'));

        $old_request = $this->toolkit->setRequest($request);

        $rewrite = new mockrewrite();
        $rewrite->expectOnce('loadRules', array('test'));
        $rewrite->expectOnce('process', array('test.abc'));
        $rewrite->setReturnValue('process', 'test.foo');
        $old_rewrite = $this->toolkit->setRewrite($rewrite);

        $this->assertEqual($this->mapper->getTemplateName(), "act.test.foo.tpl");

        $request->tally();

        $this->toolkit->setRequest($old_request);
        $this->toolkit->setRewrite($old_rewrite);
    }

    public function testMappingFalseRewriteFalse()
    {
        $request = new mockhttpRequest();
        $request->expectCallCount('getSection', 2);
        $request->setReturnValueAt(0, 'getSection', 'test');
        $request->setReturnValueAt(1, 'getSection', false);
        $request->expectCallCount('getAction', 2);
        $request->setReturnValueAt(0, 'getAction', 'abc');
        $request->setReturnValueAt(1, 'getAction', false);
        $request->expectOnce('get', array('path'));
        $request->setReturnValue('get', 'test.abc');
        $request->expectOnce('parse', array(false));

        $old_request = $this->toolkit->setRequest($request);

        $rewrite = new mockrewrite();
        $rewrite->expectOnce('process', array('test.abc'));
        $rewrite->setReturnValue('process', false);
        $old_rewrite = $this->toolkit->setRewrite($rewrite);

        $this->assertFalse($this->mapper->getTemplateName());

        $request->tally();

        $this->toolkit->setRequest($old_request);
        $this->toolkit->setRewrite($old_rewrite);
    }
}

?>