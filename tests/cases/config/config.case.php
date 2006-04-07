<?php
fileLoader::load('config/config');

class configTest extends unitTestCase
{
    private $filepath;

    public function __construct()
    {
        $this->fixtureXmlConfig();
    }

    public function fixtureXmlConfig()
    {
        $xml = "[section_1]\n option_1_1 = value_1_1 \n option_1_2 = value_1_2 \n [section_2] \n option_2_1 = value_2_1 \n option_2_2 = value_2_2";
        $this->filepath = systemConfig::$pathToTemp . 'simple_config.xml';
        file_put_contents($this->filepath, $xml);
    }

    public function setUp()
    {
    }

    public function tearDown()
    {
    }

    public function TestConfig()
    {
        $config = new config($this->filepath);
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
            $this->fail('no exception thrown?');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/unable parse/i", $e->getMessage());
            $this->pass();
        }
    }


    public function TestConfigInvalidAgrs()
    {
        $config = new config($this->filepath);
        try {
            $config->getOption("section_1", "_invalid_option_");
            $this->fail('no exception thrown?');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/can't.*?config-option/i", $e->getMessage());
            $this->pass();
        }

        try {
            $config->getSection("_invalid_section_");
            $this->fail('no exception thrown?');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/can't.*?config-section/i", $e->getMessage());
            $this->pass();
        }

    }

    public function __destruct()
    {
        unlink($this->filepath);
    }

}

?>