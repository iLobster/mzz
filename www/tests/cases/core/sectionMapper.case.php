<?php
fileLoader::load('core/sectionMapper');

fileLoader::load('request/httpRequest');
//fileLoader::load('request/requestParser');
//fileLoader::load('request/rewrite');

mock::generate('httpRequest');

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



class sectionMapperTest extends unitTestCase
{
    private $mapper;
    public function setUp()
    {
        $this->mapper = new sectionMapper(fileLoader::resolve('configs/map.xml'));
    }

    public function tearDown()
    {
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

    public function testNew()
    {
        $toolkit = systemToolkit::getInstance();
        $toolkit->setToolkit(new testToolkit());
        //var_dump($toolkit);
        $this->assertEqual($this->mapper->getTemplateName(), "act.test.foo.tpl");
    }

}

?>