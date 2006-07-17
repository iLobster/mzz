<?php

fileLoader::load('core/uidGenerator');

class uidGeneratorTest extends unitTestCase
{
    private $uidGenerator;
    private $db;

    public function setUp()
    {
        $this->db = DB::factory();
        $this->clearDB();
        $this->uidGenerator = new UIDGenerator();
    }

    public function tearDown()
    {
        $this->clearDB();
    }

    public function clearDB()
    {
        $this->db->query('TRUNCATE TABLE `sys_uid`');
    }

    public function testGenerate()
    {
        $this->assertEqual($this->uidGenerator->generate(), 1);
        $this->assertEqual($this->uidGenerator->generate(), 2);
        $this->assertEqual($this->uidGenerator->generate(), 3);
        $this->assertEqual($this->getCount(), 3);
    }

    public function testCleanEveriMillionRows()
    {
        $this->assertEqual($this->uidGenerator->generate(), 1);

        $this->assertEqual($this->getCount(), 1);

        $this->db->query('INSERT INTO `sys_uid` (`id`) VALUES (999998)');

        $this->assertEqual($this->getCount(), 2);

        $this->assertEqual($this->uidGenerator->generate(), 999999);

        $this->assertEqual($this->getCount(), 3);

        $this->assertEqual($this->uidGenerator->generate(), 1000000);

        $this->assertEqual($this->getCount(), 1);
    }

    private function getCount()
    {
        return $this->db->getOne('SELECT COUNT(*) AS `cnt` FROM `sys_uid`');
    }
}

?>