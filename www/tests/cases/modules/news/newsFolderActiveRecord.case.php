<?php

fileLoader::load('news/newsFolderActiveRecord');
fileLoader::load('news/newsFolderTableModule');

mock::generate('newsFolderTableModule');

class newsFolderActiveRecordTest extends unitTestCase
{
    protected $db;
    protected $TM;
    protected $newsFolderAR;
    protected $name;

    public function setUp()
    {
        $this->db = DB::factory();

        $this->cleardb();

        $stmt = $this->db->prepare('INSERT INTO `news_tree` (`id`, `name`, `parent`) VALUES (:id, :name, :parent)');

        $data[1] = array('id' => 1, 'name' => '', 'parent' => 0);
        $stmt->bindArray($data[1]);
        $stmt->execute();

        $data[2] = array('id' => 2, 'name' => 'somefolder', 'parent' => 1);
        $stmt->bindArray($data[2]);
        $stmt->execute();

        $data[3] = array('id' => 3, 'name' => 'blabla', 'parent' => 1);
        $stmt->bindArray($data[3]);
        $stmt->execute();

        $this->TM = new mocknewsFolderTableModule();

        $stmt = $this->db->prepare('SELECT * FROM `news_tree` WHERE `name` = :name');
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $this->newsFolderAR = new newsFolderActiveRecord($stmt, $this->TM);
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('DELETE FROM `news_tree`');
    }

    public function testGetFolder()
    {
        $this->name = 'somefolder';

        $this->assertEqual($this->newsFolderAR->get('name'), $this->name);
        $this->assertTrue($this->newsFolderAR->exists());
    }

    public function testGetFolderNoExists()
    {
        $this->name = 'not_exists_folder';

        $this->assertNull($this->newsFolderAR->get('name'));
        $this->assertFalse($this->newsFolderAR->exists());
    }

    public function testGetSubfolders()
    {
        $this->name = '';

        $this->assertEqual($this->newsFolderAR->get('name'), $this->name);
        $this->assertTrue($this->newsFolderAR->exists());

        $this->TM->expectOnce('getFolders', array((string)1));
        $return = array('subfolder1', 'subfolder2');
        $this->TM->setReturnValue('getFolders', $return);

        $this->assertIdentical($this->newsFolderAR->getFolders(), $return);
    }

    public function testGetItems()
    {
        $this->name = '';

        $this->TM->expectOnce('getItems', array((string)1));
        $return = array('item1', 'item2');
        $this->TM->setReturnValue('getItems', $return);

        $this->assertIdentical($this->newsFolderAR->getItems(), $return);
    }
}

?>