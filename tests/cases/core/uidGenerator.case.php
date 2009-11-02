<?php


class objectIDGeneratorTest extends unitTestCase
{
    private $toolkit;
    private $db;

    public function setUp()
    {
        $this->db = fDB::factory();
        $this->clearDB();
        $this->toolkit = systemToolkit::getInstance();
    }

    public function tearDown()
    {
        $this->clearDB();
    }

    public function clearDB()
    {
        $this->db->query('TRUNCATE TABLE `sys_obj_id`');
        $this->db->query('TRUNCATE TABLE `sys_obj_id_named`');
    }

    public function testGenerate()
    {
        $this->assertEqual($this->toolkit->getObjectId(), 1);
        $this->assertEqual($this->toolkit->getObjectId(), 2);
        $this->assertEqual($this->toolkit->getObjectId(), 3);
        $this->assertEqual($this->getCount(), 3);
    }

    public function testCleanEveriMillionRows()
    {
        $this->assertEqual($this->toolkit->getObjectId(), 1);

        $this->assertEqual($this->getCount(), 1);

        $this->db->query('INSERT INTO `sys_obj_id` (`id`) VALUES (999998)');

        $this->assertEqual($this->getCount(), 2);

        $this->assertEqual($this->toolkit->getObjectId(), 999999);

        $this->assertEqual($this->getCount(), 3);

        $this->assertEqual($this->toolkit->getObjectId(), 1000000);

        $this->assertEqual($this->getCount(), 1);

        $this->assertEqual($this->toolkit->getObjectId(), 1000001);
    }

    public function testGetNamedObjects()
    {
        $this->assertEqual($this->toolkit->getObjectId('sample_name'), $obj_id = $this->db->getOne('SELECT MAX(`id`) FROM `sys_obj_id`'));
        $this->assertEqual($this->toolkit->getObjectId('sample_name'), $obj_id);
    }

    private function getCount()
    {
        return $this->db->getOne('SELECT COUNT(*) AS `cnt` FROM `sys_obj_id`');
    }
}

?>