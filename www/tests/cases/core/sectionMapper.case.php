<?php
fileLoader::load('core/sectionMapper');

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

    public function TestSectionMapper()
    {
        $this->assertEqual($this->mapper->getTemplateName("test", "foo"), "act.test.foo.tpl");
        $this->assertEqual($this->mapper->getTemplateName("test", "bar"), "act.test.bar.tpl");
    }

    public function TestSectionMapperFalse()
    {
        $this->assertFalse($this->mapper->getTemplateName(null, null));
        $this->assertFalse($this->mapper->getTemplateName('test', '__not_exists__'));
    }

}

?>