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
        try {
            $config->load("__false_config_file__");
            $this->assertFalse(true, 'no exception thrown?');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/unable parse/i", $e->getMessage());
            $this->assertFalse(false);
        }

        try {
            $config->update();
            $this->assertFalse(true, 'no exception thrown?');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/no.*?found.*?config/i", $e->getMessage());
            $this->assertFalse(false);
        }

        $this->assertTrue($config->load("simpleconfig"));

        try {
            $config->getOption("_invalid_section_", "_invalid_option_");
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