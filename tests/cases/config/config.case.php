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
        $this->assertEqual($config->get('someParam'), 'someValueOfParam');

        $config = new config('someAnotherSection', 'someAnotherModule');
        $this->assertEqual($config->get('someAnotherParam'), 'someValueOfAnotherParam');
    }

    public function testConfigGetDefault()
    {
        $config = new config('someSection', 'someModule');
        $this->assertEqual($config->get('someDefaultParam'), 'someValueOfDefaultParam');
    }

    public function testConfigGetFalse()
    {
        $config = new config('someSection', 'someModule');
        $this->assertFalse($config->get('non_exists'));
    }

    public function testSetValue()
    {
        $config = new config('someSection', 'someModule');
        $config->set(array('someParam' => $value = 'new value'));
        $this->assertEqual($config->get('someParam'), $value);

        $this->db->exec("INSERT INTO `sys_cfg_values` VALUES (0, 1, 'any_name', '')");
        $config->set($name = 'any_name', $value = 'any new value');
        $this->assertEqual($config->get($name), $value);
    }

    public function fixture()
    {

        $this->db->exec("INSERT INTO `sys_modules` VALUES(1, 'someModule')");
        $this->db->exec("INSERT INTO `sys_modules` VALUES(2, 'someAnotherModule')");
        $this->db->exec("INSERT INTO `sys_sections` VALUES(1, 'someSection')");
        $this->db->exec("INSERT INTO `sys_sections` VALUES(2, 'someAnotherSection')");


        $this->db->exec("INSERT INTO `sys_cfg` VALUES(1, 0, 1)");
        $this->db->exec("INSERT INTO `sys_cfg` VALUES(2, 0, 2)");
        $this->db->exec("INSERT INTO `sys_cfg` VALUES(3, 1, 1)");
        $this->db->exec("INSERT INTO `sys_cfg` VALUES(4, 2, 2)");

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
        $this->db->query('TRUNCATE TABLE `sys_sections`');
        $this->db->query('TRUNCATE TABLE `sys_modules`');
    }

}

?>