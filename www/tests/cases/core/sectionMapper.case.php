<?php
fileLoader::load('core/sectionMapper');

class sectionMapperTest extends unitTestCase
{
    public function setUp()
    {
    }

    public function tearDown()
    {
    }

    public function TestSectionMapper()
    {
        $mapper = new sectionMapper("test","foo");
        $this->assertEqual($mapper->getTemplateName(), "act.test.foo.tpl");
        $mapper = new sectionMapper("test","bar");
        $this->assertEqual($mapper->getTemplateName(), "act.test.bar.tpl");
    }

    public function TestSectionMapperFalse()
    {
        $mapper = new sectionMapper(null,null);
        $this->assertFalse($mapper->getTemplateName());

        $mapper = new sectionMapper('test', null);
        $this->assertFalse($mapper->getTemplateName());

        $mapper = new sectionMapper('test', '__not_exists__');
        $this->assertFalse($mapper->getTemplateName());
    }

}

?>