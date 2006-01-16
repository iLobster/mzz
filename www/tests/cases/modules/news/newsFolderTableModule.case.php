<?php

fileLoader::load('news/newsFolderTableModule');

class newsFolderTableModuleTest extends unitTestCase
{
    private $newsFolder;
    private $data = array();

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

        $this->data = $data;
    }

    public function tearDown()
    {
        $this->cleardb();
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

    public function testSelectSubfolders()
    {
        $this->newsFolder = new newsFolderTableModule('');
        $this->assertTrue($this->newsFolder->exists());
        $subfolders = $this->newsFolder->getFolders();

        $this->assertTrue(is_array($subfolders), 'Должен возвращаться массив папок');
        $this->assertEqual(sizeof($subfolders), 2);

        $folders = '';
        foreach ($subfolders as $key => $folder) {
            $this->assertIsA($folder, 'newsFolderTableModule');
            $this->assertEqual($this->data[$key + 2]['name'], $folder->get('name'));
        }
    }

}

?>