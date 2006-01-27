<?php
fileLoader::load('core/sectionMapper');

fileLoader::load('request/httpRequest');
//fileLoader::load('request/requestParser');
fileLoader::load('request/rewrite');

mock::generate('httpRequest');
mock::generate('rewrite');

class testToolkit extends toolkit
{
    public function getRequest()
    {
        $request = new mockhttpRequest();
        $request->expectOnce('getSection', array());
        $request->setReturnValue('getSection', 'test');
        $request->expectOnce('getAction', array());
        $request->setReturnValue('getAction', 'foo');
        return $request;
    }
}


class testToolkitNotExist extends toolkit
{
    public function getRequest()
    {
        $request = new mockhttpRequest();
        $request->expectOnce('getSection', array());
        $request->setReturnValue('getSection', 'test');
        $request->expectOnce('getAction', array());
        $request->setReturnValue('getAction', 'abc');
        $request->expectOnce('get', array('path'));
        $request->setReturnValue('get', 'test.foo');
        return $request;
    }
    public function getRewrite()
    {
        $rewrite = new mockrewrite();
        $rewrite->expectOnce('process', array('test.abc'));
        $rewrite->setReturnValue('process', 'test.foo');
        return $rewrite;
    }
}



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
        $this->toolkit->setToolkit($this->oldToolkit);
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
        //var_dump($toolkit);
        $this->oldToolkit = $this->toolkit->setToolkit(new testToolkit());
        $this->assertEqual($this->mapper->getTemplateName(), "act.test.foo.tpl");

    }

    public function testMappingFalse()
    {// йюй ондлемхрэ рскйхр мю мнбши???
     // $this->toolkit->setRequest($mockrequest) && $this->toolkit->setRewrite($mockrewrite)

        $this->oldToolkit = $this->toolkit->setToolkit(new testToolkitNotExist());
        $this->assertTrue($this->mapper->getTemplateName(), "act.test.foo.tpl");
    }

}

?>