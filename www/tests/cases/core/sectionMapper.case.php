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
        $mapper = new sectionMapper("news","list");
        $this->assertEqual($mapper->getTemplateName(), "act.news.list.tpl");
        $mapper = new sectionMapper("news","view");
        $this->assertEqual($mapper->getTemplateName(), "act.news.view.tpl");
    }

    public function TestSectionMapperFalse()
    {
        $mapper = new sectionMapper(null,null);
        $this->assertFalse($mapper->getTemplateName());
    }

}

?>