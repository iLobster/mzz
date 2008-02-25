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
        $config = new config('someSection', 'someModule');
        $this->assertEqual($config->get('someParam'), 'someValueOfParam');
        $this->assertEqual($config->getTitle('someParam'), 'параметр');

        $config = new config('someAnotherSection', 'someAnotherModule');
        $this->assertEqual($config->get('someAnotherParam'), 'someValueOfAnotherParam');
        $this->assertEqual($config->getTitle('someAnotherParam'), 'параметр2');
    }

    public function testConfigGetOnlyDefault()
    {
        $config = new config(null, 'someModule');
        $this->assertEqual($config->get('someParam'), 'defaultValueOfParam');
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

        $config = new config('someAnotherSection', 'someModule');
        $this->assertEqual($config->get('someParam'), 'defaultValueOfParam');
    }

    public function testSetValue()
    {
        $config = new config('someSection', 'someModule');
        $config->set(array('someParam' => $value = 'new value'));
        $this->assertEqual($config->get('someParam'), $value);
    }

    public function testCreateUpdateDeleteParam()
    {
        $config = new config('someSection', 'someModule');
        $config->create('name', 'value', 'title', 2);

        $this->assertEqual($config->get('name'), 'value');
        $this->assertEqual($config->getTitle('name'), 'title');

        $config->update('name', 'new_name', 'new_value', 'new_title');

        $config = new config('someSection', 'someModule');
        $this->assertEqual($config->get('new_name'), 'new_value');
        $this->assertEqual($config->getTitle('new_name'), 'new_title');

        $config->delete('new_name');

        $config = new config('someSection', 'someModule');
        $this->assertNull($config->get('new_name'));
    }

    public function fixture()
    {
        $this->db->exec("INSERT INTO `sys_modules` VALUES(1, 'someModule'), (2, 'someAnotherModule')");
        $this->db->exec("INSERT INTO `sys_sections` VALUES(1, 'someSection'), (2, 'someAnotherSection')");


        $this->db->exec("INSERT INTO `sys_cfg` VALUES(1, 0, 1), (2, 0, 2), (3, 1, 1), (4, 2, 2)");
        $this->db->exec("INSERT INTO `sys_cfg_vars` VALUES (0, 'someParam'), (0, 'someAnotherParam'), (0, 'someDefaultParam')");
        $this->db->exec("INSERT INTO `sys_cfg_titles` VALUES (0, 'параметр'), (0, 'параметр2'), (0, 'дефолтный_параметр')");

        $this->db->exec("INSERT INTO `sys_cfg_types` VALUES (0, 'char', 'Строка'), (0, 'int', 'Целое')");

        $this->db->exec("INSERT INTO `sys_cfg_values` VALUES (0, 1, 1, 1, 1, 'defaultValueOfParam'),
        (0, 3, 1, 1, 2, 'someValueOfParam'),
        (0, 2, 1, 1, 1, 'valueForAnotherSection'),
        (0, 2, 2, 2, 2, 'someDefaultValueOfAnotherParam'),
        (0, 4, 2, 2, 1, 'someValueOfAnotherParam'),
        (0, 1, 3, 3, 2, 'someValueOfDefaultParam')");
    }

    private function clearDb()
    {
        $this->db->query('TRUNCATE TABLE `sys_cfg`');
        $this->db->query('TRUNCATE TABLE `sys_cfg_vars`');
        $this->db->query('TRUNCATE TABLE `sys_cfg_titles`');
        $this->db->query('TRUNCATE TABLE `sys_cfg_values`');
        $this->db->query('TRUNCATE TABLE `sys_cfg_types`');
        $this->db->query('TRUNCATE TABLE `sys_sections`');
        $this->db->query('TRUNCATE TABLE `sys_modules`');
    }

}

?>