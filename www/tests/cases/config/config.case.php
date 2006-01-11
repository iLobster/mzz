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
        $config = new config(fileLoader::resolve('configs/simpleconfig.ini'));
        $this->assertEqual($config->getOption("section_1", "option_1_1"), "value_1_1");
        $this->assertEqual($config->getOption("section_1", "option_1_2"), "value_1_2");
        $this->assertEqual($config->getOption("section_2", "option_2_1"), "value_2_1");
        $this->assertEqual($config->getOption("section_2", "option_2_2"), "value_2_2");
        $this->assertEqual($config->getSection("section_2"), array('option_2_1' => 'value_2_1',
                                                                   'option_2_2' => 'value_2_2'));

        $this->assertEqual($config->getSection("section_1"), array('option_1_1' => 'value_1_1',
                                                                   'option_1_2' => 'value_1_2'));
    }

    public function TestConfigNotExists()
    {
        try {
            $config = new config("__false_config_file__");
            $this->assertFalse(true, 'no exception thrown?');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/unable parse/i", $e->getMessage());
            $this->assertFalse(false);
        }
    }


    public function TestConfigInvalidAgrs()
    {
        $config = new config(fileLoader::resolve('configs/simpleconfig.ini'));
        try {
            $config->getOption("section_1", "_invalid_option_");
            $this->assertFalse(true, 'no exception thrown?');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/can't.*?config-option/i", $e->getMessage());
            $this->assertFalse(false);
        }

        try {
            $config->getSection("_invalid_section_");
            $this->assertFalse(true, 'no exception thrown?');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/can't.*?config-section/i", $e->getMessage());
            $this->assertFalse(false);
        }

    }


}

?>