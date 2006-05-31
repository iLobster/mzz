<?php
fileLoader::load('config/config');
/**
 * @todo сменить создание класса на получение объекта конфига из тулкита ?
 *
 */
class configTest extends unitTestCase
{
    private $db;

    public function __construct()
    {
        $this->db = db::factory();
    }

    public function setUp()
    {
        $this->clearDb();
        $this->fixture();
    }

    public function tearDown()
    {
        $this->clearDb();
    }

    public function testConfigGet()
    {
        $config = new config('someSection', 'someModule');
        $this->assertEqual($config->get("someParam"), "someValueOfParam");

        $config = new config('someAnotherSection', 'someAnotherModule');
        $this->assertEqual($config->get("someAnotherParam"), "someValueOfAnotherParam");
    }

    public function testConfigGetDefault()
    {
        $config = new config('someSection', 'someModule');
        $this->assertEqual($config->get("someDefaultParam"), "someValueOfDefaultParam");
    }

    public function testConfigGetFalse()
    {
        $config = new config('someSection', 'someModule');
        $this->assertFalse($config->get("non_exists"));
    }

    public function fixture()
    {
        $this->db->exec("INSERT INTO `sys_cfg` VALUES(1, '', 'someModule')");
        $this->db->exec("INSERT INTO `sys_cfg` VALUES(2, '', 'someAnotherModule')");
        $this->db->exec("INSERT INTO `sys_cfg` VALUES(3, 'someSection', 'someModule')");
        $this->db->exec("INSERT INTO `sys_cfg` VALUES(4, 'someAnotherSection', 'someAnotherModule')");

        $this->db->exec("INSERT INTO `sys_cfg_values` VALUES(0, 1, 'someParam', 'defaultValueOfParam')");
        $this->db->exec("INSERT INTO `sys_cfg_values` VALUES(0, 3, 'someParam', 'someValueOfParam')");

        $this->db->exec("INSERT INTO `sys_cfg_values` VALUES(0, 2, 'someAnotherParam', 'someDefaultValueOfAnotherParam')");
        $this->db->exec("INSERT INTO `sys_cfg_values` VALUES(0, 4, 'someAnotherParam', 'someValueOfAnotherParam')");

        $this->db->exec("INSERT INTO `sys_cfg_values` VALUES(0, 1, 'someDefaultParam', 'someValueOfDefaultParam')");
    }

    private function clearDb()
    {
        $this->db->query('TRUNCATE TABLE `sys_cfg`');
        $this->db->query('TRUNCATE TABLE `sys_cfg_values`');
    }

}

/*
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
        $this->filepath = systemConfig::$pathToTemp . '/simple_config.xml';
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
*/
?>