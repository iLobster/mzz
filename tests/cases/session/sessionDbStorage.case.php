<?php
fileLoader::load('session/sessionDbStorage');

class sessionDbStorageTest extends unitTestCase
{

    private $db;
    private $storage;
    private $fixture;

    public function setUp()
    {
        $this->db = fDB::factory();
        $this->storage = new sessionDbStorage();
        $this->fixture = array('sid'  => 'jhd6dkj8wd9s',
                               'data' => serialize('bla-bla'));

    }

    public function tearDown()
    {
        $this->db->exec("DELETE FROM `sys_sessions` WHERE `sid`='" . $this->fixture['sid'] . "'");
    }

    public function testStorageOpen()
    {
        $this->assertEqual($this->storage->storageOpen(), true);
    }

    public function testStorageClose()
    {
        $this->assertEqual($this->storage->storageClose(), true);
    }

    public function testStorageRead()
    {
        $this->setSessionWithGc(0);

        $this->assertEqual($this->storage->storageRead($this->fixture['sid']), $this->fixture['data']);

    }

    public function testStorageWrite()
    {
        $this->storage->storageWrite($this->fixture['sid'], $this->fixture['data']);
        $this->assertEqual($this->storage->storageRead($this->fixture['sid']), $this->fixture['data']);

    }

    public function testStorageDestroy()
    {
        $this->storage->storageWrite($this->fixture['sid'], $this->fixture['data']);
        $this->storage->storageDestroy($this->fixture['sid']);

        $this->assertEqual($this->storage->storageRead($this->fixture['sid']), null);


    }


    public function testStorageGcTrue()
    {
        $this->setSessionWithGc(100-5);
        $this->storage->storageGc(100);

        $this->assertEqual($this->storage->storageRead($this->fixture['sid']), $this->fixture['data']);
    }

    public function testStorageGcFalse()
    {
        $this->setSessionWithGc(100+5);
        $this->storage->storageGc(100);

        $this->assertEqual($this->storage->storageRead($this->fixture['sid']), null);
    }

    private function setSessionWithGc($gc = 0)
    {
        $this->db->exec(' INSERT INTO `sys_sessions` (`sid`,`data`,`ts`)'.
                        " VALUES('" . $this->fixture['sid'] . "',".
                                "'" . $this->fixture['data']. "',".
                                "'" . (time() - $gc)        . "')");
    }

}



?>