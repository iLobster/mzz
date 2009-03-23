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
        $config = new config('someModule');
        $this->assertEqual($config->get('someParam'), 'someValueOfParam');
        $this->assertEqual($config->getTitle('someParam'), 'параметр');

        $config = new config('someAnotherModule');
        $this->assertEqual($config->get('someAnotherParam'), 'someValueOfAnotherParam');
        $this->assertEqual($config->getTitle('someAnotherParam'), 'параметр2');
    }

    public function testConfigGetFalse()
    {
        $config = new config('someModule');
        $this->assertFalse($config->get('non_exists'));
    }

    public function testSetValue()
    {
        $config = new config('someModule');
        $config->set(array('someParam' => $value = 'new value'));
        $this->assertEqual($config->get('someParam'), $value);
    }

    public function testCreateUpdateDeleteParam()
    {
        $config = new config('someModule');
        $config->create('name', 'value', 'title', 2);

        $this->assertEqual($config->get('name'), 'value');
        $this->assertEqual($config->getTitle('name'), 'title');

        $config->update('name', 'new_name', 'new_value', 'new_title');

        $config = new config('someModule');
        $this->assertEqual($config->get('new_name'), 'new_value');
        $this->assertEqual($config->getTitle('new_name'), 'new_title');

        $config->delete('new_name');

        $config = new config('someModule');
        $this->assertNull($config->get('new_name'));
    }

    public function fixture()
    {
        $this->db->exec("INSERT INTO `sys_modules` VALUES(1, 'someModule'), (2, 'someAnotherModule')");

        $this->db->exec("INSERT INTO `sys_cfg_vars` VALUES (0, 'someParam'), (0, 'someAnotherParam'), (0, 'someDefaultParam')");
        $this->db->exec("INSERT INTO `sys_cfg_titles` VALUES (0, 'параметр'), (0, 'параметр2'), (0, 'дефолтный_параметр')");

        $this->db->exec("INSERT INTO `sys_cfg_types` VALUES (0, 'char', 'Строка'), (0, 'int', 'Целое')");

        $this->db->exec("INSERT INTO `sys_cfg_values` VALUES (0, 1, 1, 1, 1, 'someValueOfParam'),
        (0, 2, 1, 1, 1, 'valueForAnotherSection'),
        (0, 2, 2, 2, 1, 'someValueOfAnotherParam')");
    }

    private function clearDb()
    {
        $this->db->query('TRUNCATE TABLE `sys_cfg_vars`');
        $this->db->query('TRUNCATE TABLE `sys_cfg_titles`');
        $this->db->query('TRUNCATE TABLE `sys_cfg_values`');
        $this->db->query('TRUNCATE TABLE `sys_cfg_types`');
        $this->db->query('TRUNCATE TABLE `sys_modules`');
    }

}

?>