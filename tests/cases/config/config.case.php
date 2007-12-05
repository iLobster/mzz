<?php

fileLoader::load('config/config');

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
        $config = new oldconfig('someSection', 'someModule');
        $this->assertEqual($config->get('someParam'), 'someValueOfParam');
        $this->assertEqual($config->getTitle('someParam'), 'параметр');

        $config = new oldconfig('someAnotherSection', 'someAnotherModule');
        $this->assertEqual($config->get('someAnotherParam'), 'someValueOfAnotherParam');
        $this->assertEqual($config->getTitle('someAnotherParam'), 'параметр2');
    }

    public function testConfigGetOnlyDefault()
    {
        $config = new oldconfig(null, 'someModule');
        $this->assertEqual($config->get('someParam'), 'defaultValueOfParam');
    }

    public function testConfigGetDefault()
    {
        $config = new oldconfig('someSection', 'someModule');
        $this->assertEqual($config->get('someDefaultParam'), 'someValueOfDefaultParam');
    }

    public function testConfigGetFalse()
    {
        $config = new oldconfig('someSection', 'someModule');
        $this->assertFalse($config->get('non_exists'));

        $config = new oldconfig('someAnotherSection', 'someModule');
        $this->assertEqual($config->get('someParam'), 'defaultValueOfParam');
    }

    public function testSetValue()
    {
        $config = new oldconfig('someSection', 'someModule');
        $config->set(array('someParam' => $value = 'new value'));
        $this->assertEqual($config->get('someParam'), $value);
    }

    public function testCreateUpdateDeleteParam()
    {
        $config = new oldconfig('someSection', 'someModule');
        $config->create('name', 'value', 'title');

        $this->assertEqual($config->get('name'), 'value');
        $this->assertEqual($config->getTitle('name'), 'title');

        $config->update('name', 'new_name', 'new_value', 'new_title');

        $config = new oldconfig('someSection', 'someModule');
        $this->assertEqual($config->get('new_name'), 'new_value');
        $this->assertEqual($config->getTitle('new_name'), 'new_title');

        $config->delete('new_name');

        $config = new oldconfig('someSection', 'someModule');
        $this->assertNull($config->get('new_name'));
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

        $this->db->exec("INSERT INTO `sys_cfg_vars` VALUES (0, 'someParam')");
        $this->db->exec("INSERT INTO `sys_cfg_vars` VALUES (0, 'someAnotherParam')");
        $this->db->exec("INSERT INTO `sys_cfg_vars` VALUES (0, 'someDefaultParam')");

        $this->db->exec("INSERT INTO `sys_cfg_titles` VALUES (0, 'параметр')");
        $this->db->exec("INSERT INTO `sys_cfg_titles` VALUES (0, 'параметр2')");
        $this->db->exec("INSERT INTO `sys_cfg_titles` VALUES (0, 'дефолтный_параметр')");

        $this->db->exec("INSERT INTO `sys_cfg_values` VALUES (0, 1, 1, 1, 'defaultValueOfParam')");
        $this->db->exec("INSERT INTO `sys_cfg_values` VALUES (0, 3, 1, 1, 'someValueOfParam')");

        $this->db->exec("INSERT INTO `sys_cfg_values` VALUES (0, 2, 1, 1, 'valueForAnotherSection')");
        $this->db->exec("INSERT INTO `sys_cfg_values` VALUES (0, 2, 2, 2, 'someDefaultValueOfAnotherParam')");
        $this->db->exec("INSERT INTO `sys_cfg_values` VALUES (0, 4, 2, 2, 'someValueOfAnotherParam')");

        $this->db->exec("INSERT INTO `sys_cfg_values` VALUES (0, 1, 3, 3, 'someValueOfDefaultParam')");
    }

    private function clearDb()
    {
        $this->db->query('TRUNCATE TABLE `sys_cfg`');
        $this->db->query('TRUNCATE TABLE `sys_cfg_vars`');
        $this->db->query('TRUNCATE TABLE `sys_cfg_titles`');
        $this->db->query('TRUNCATE TABLE `sys_cfg_values`');
        $this->db->query('TRUNCATE TABLE `sys_sections`');
        $this->db->query('TRUNCATE TABLE `sys_modules`');
    }

}

?>