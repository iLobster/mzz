<?php

fileLoader::load('news/newsFolderTableModule');

class newsFolderTableModuleTest extends unitTestCase
{
    private $newsFolder;

    public function setUp()
    {
        $this->db = DB::factory();
        $this->cleardb();

        $stmt = $this->db->prepare('INSERT INTO `news_tree` (`id`, `name`) VALUES (:id, :name)');

        $data = array('id' => 1, 'name' => '');
        $stmt->bindArray($data);
        $stmt->execute();

        $data = array('id' => 2, 'name' => 'somefolder');
        $stmt->bindArray($data);
        $stmt->execute();
        
        $data = array('id' => 3, 'name' => 'blabla');
        $stmt->bindArray($data);
        $stmt->execute();
    }

    public function cleardb()
    {
        $this->db->query('DELETE FROM `news_tree`');
    }

    public function testSelectFolderExists()
    {
        $this->newsFolder = new newsFolderTableModule('somefolder');
        $this->assertTrue($this->newsFolder->exists());
    }
    
    public function testSelectFolderNotExists()
    {
        $this->newsFolder = new newsFolderTableModule('not_exists_folder');
        $this->assertFalse($this->newsFolder->exists());
    }    

}

?>