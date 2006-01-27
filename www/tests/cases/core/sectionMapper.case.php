<?php

fileLoader::load('core/sectionMapper');

fileLoader::load('request/httpRequest');
fileLoader::load('request/rewrite');

mock::generate('httpRequest');
mock::generate('rewrite');


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

    public function testSectionMapper()
    {
        $section = "test";
        $action = "foo";
        $this->assertEqual($this->mapper->getTemplateName($section, $action), "act.test.foo.tpl");

        $section = "test";
        $action = "bar";
        $this->assertEqual($this->mapper->getTemplateName($section, $action), "act.test.bar.tpl");

    }

    public function testSectionMapperFalse()
    {
        $section = "__not_exists__";
        $action = "__not_exists__";
        $this->assertFalse($this->mapper->getTemplateName($section, $action));

        $section = "test";
        $action = "__not_exists__";
        $this->assertFalse($this->mapper->getTemplateName($section, $action));
    }

}

?>