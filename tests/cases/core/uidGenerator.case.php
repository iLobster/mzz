<?php


class objectIDGeneratorTest extends unitTestCase
{
    private $toolkit;
    private $db;

    public function setUp()
    {
        $this->db = DB::factory();
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

    private function getCount()
    {
        return $this->db->getOne('SELECT COUNT(*) AS `cnt` FROM `sys_obj_id`');
    }
}

?>