<?php
fileLoader::load('core/sectionMapper');

fileLoader::load('request/httpRequest');
//fileLoader::load('request/requestParser');
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
        //$this->toolkit->setToolkit($this->oldToolkit);
    }

    /*public function TestSectionMapper()
    {
    $this->assertEqual($this->mapper->getTemplateName("test", "foo"), "act.test.foo.tpl");
    $this->assertEqual($this->mapper->getTemplateName("test", "bar"), "act.test.bar.tpl");
    }

    public function TestSectionMapperFalse()
    {
    $this->assertFalse($this->mapper->getTemplateName(null, null));
    $this->assertFalse($this->mapper->getTemplateName('test', '__not_exists__'));
    }*/

    public function testSectionMapper()
    {

        $request = new mockhttpRequest();
        $request->expectOnce('getSection', array());
        $request->setReturnValue('getSection', 'test');
        $request->expectOnce('getAction', array());
        $request->setReturnValue('getAction', 'foo');
        $old_request = $this->toolkit->setRequest($request);

        //var_dump($toolkit);
        //$this->oldToolkit = $this->toolkit->setToolkit(new testToolkit());
        $this->assertEqual($this->mapper->getTemplateName(), "act.test.foo.tpl");

        $this->toolkit->setRequest($old_request);

    }

    public function testMappingFalseRewriteTrue()
    {// йюй ондлемхрэ рскйхр мю мнбши???
        // $this->toolkit->setRequest($mockrequest) && $this->toolkit->setRewrite($mockrewrite)

        //   $this->oldToolkit = $this->toolkit->setToolkit(new testToolkitNotExist());

        $request = new mockhttpRequest();
        $request->expectOnce('getSection', array());
        $request->setReturnValue('getSection', 'test');
        $request->expectOnce('getAction', array());
        $request->setReturnValue('getAction', 'abc');
        $request->expectOnce('get', array('path'));
        $request->setReturnValue('get', 'test.abc');
        $old_request = $this->toolkit->setRequest($request);

        $rewrite = new mockrewrite();
        $rewrite->expectOnce('process', array('test.abc'));
        $rewrite->setReturnValue('process', 'test.foo');
        $old_rewrite = $this->toolkit->setRewrite($rewrite);

        $this->assertEqual($this->mapper->getTemplateName(), "act.test.foo.tpl");

        $this->toolkit->setRequest($old_request);
        $this->toolkit->setRewrite($old_rewrite);
    }

    public function testMappingFalseRewriteFalse()
    {
        $request = new mockhttpRequest();
        $request->expectOnce('getSection', array());
        $request->setReturnValue('getSection', 'test');
        $request->expectOnce('getAction', array());
        $request->setReturnValue('getAction', 'abc');
        $request->expectOnce('get', array('path'));
        $request->setReturnValue('get', 'test.abc');
        $old_request = $this->toolkit->setRequest($request);

        $rewrite = new mockrewrite();
        $rewrite->expectOnce('process', array('test.abc'));
        $rewrite->setReturnValue('process', false);
        $old_rewrite = $this->toolkit->setRewrite($rewrite);

        $this->assertFalse($this->mapper->getTemplateName());

        $this->toolkit->setRequest($old_request);
        $this->toolkit->setRewrite($old_rewrite);
    }

}

?>