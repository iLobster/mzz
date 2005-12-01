<?php
fileLoader::load('config/config');

class configTest extends unitTestCase
{
    public function setUp()
    {
    }

    public function tearDown()
    {
    }

    public function TestConfig()
    {
        $config = new config();
        $this->assertFalse($config->load("__false_config_file__"));
        $this->assertTrue($config->load("simpleconfig"));

        $this->assertEqual($config->getOption("section_1", "option_1_1"), "value_1_1");
        $this->assertEqual($config->getOption("section_1", "option_1_2"), "value_1_2");
        $this->assertEqual($config->getOption("section_2", "option_2_1"), "value_2_1");
        $this->assertEqual($config->getOption("section_2", "option_2_2"), "value_2_2");
        $this->assertEqual($config->getSection("section_2"), array('option_2_1' => 'value_2_1',
                                                                   'option_2_2' => 'value_2_2'));

        $this->assertEqual($config->getSection("section_1"), array('option_1_1' => 'value_1_1',
                                                                   'option_1_2' => 'value_1_2'));

    }


}

?>