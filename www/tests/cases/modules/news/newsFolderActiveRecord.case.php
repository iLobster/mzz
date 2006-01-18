<?php

fileLoader::load('news/newsFolderActiveRecord');
fileLoader::load('news/newsFolderTableModule');

mock::generate('newsFolderTableModule');

class newsFolderActiveRecordTest extends unitTestCase
{
    protected $db;
    protected $TM;

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
        $name = 'somefolder';
        $stmt = $this->db->prepare('SELECT * FROM `news_tree` WHERE `name` = :name');
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $newsFolderAR = new newsFolderActiveRecord($stmt, $this->TM);

        $this->assertEqual($newsFolderAR->get('name'), $name);
        $this->assertTrue($newsFolderAR->exists());
    }

    public function testGetFolderNoExists()
    {
        $name = 'not_exists_folder';
        $stmt = $this->db->prepare('SELECT * FROM `news_tree` WHERE `name` = :name');
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $newsFolderAR = new newsFolderActiveRecord($stmt, $this->TM);

        $this->assertNull($newsFolderAR->get('name'));
        $this->assertFalse($newsFolderAR->exists());
    }

    public function testGetSubfolders()
    {
        $name = '';
        $stmt = $this->db->prepare('SELECT * FROM `news_tree` WHERE `name` = :name');
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $newsFolderAR = new newsFolderActiveRecord($stmt, $this->TM);

        $this->assertEqual($newsFolderAR->get('name'), $name);
        $this->assertTrue($newsFolderAR->exists());

        $this->TM->expectOnce('getFolders', array());
        $return = array('subfolder1', 'subfolder2');
        $this->TM->setReturnValue('getFolders', $return);

        $this->assertIdentical($newsFolderAR->getFolders(), $return);
    }
}

?>