<?php
fileLoader::load('core/sectionMapper');

class sectionMapperTest extends unitTestCase
{
    private $mapper;
    private $filepath;

    public function __construct()
    {
        $this->fixtureXmlConfig();
    }

    public function setUp()
    {
        $this->mapper = new sectionMapper($this->filepath);
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

    public function fixtureXmlConfig()
    {
        $xml = '<?xml version="1.0" standalone="yes"?>
        <mapps>
          <test>
            <action name="bar">test.bar</action>
            <action name="foo">test.foo</action>
          </test>
        </mapps>';
        $this->filepath = systemConfig::$pathToTemp . '/map.xml';
        file_put_contents($this->filepath, $xml);
    }

    public function __destruct()
    {
        unlink($this->filepath);
    }

}

?>