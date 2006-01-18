<?php

fileLoader::load('news/newsFolderTableModule');

class newsFolderTableModuleTest extends unitTestCase
{
    private $newsFolderTM;
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

        $this->newsFolderTM = new newsFolderTableModule();
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('DELETE FROM `news_tree`');
    }

    public function testSearchByName()
    {
        $path = 'somefolder';
        $newsFolder = $this->newsFolderTM->searchByName($path);

        $this->assertIsA($newsFolder, 'newsFolderActiveRecord');
        $this->assertTrue($newsFolder->exists());
        $this->assertTrue($newsFolder->get('name'), $path);
    }

    public function testGetSubfolders()
    {
        $path = '';
        $newsFolder = $this->newsFolderTM->searchByName($path);
        $this->assertTrue($newsFolder->exists());

        $folders = $newsFolder->getFolders();
        $this->assertTrue(is_array($folders), 'Должен возвращаться массив папок');
        $this->assertEqual(sizeof($folders), 2);

        foreach ($folders as $key => $folder) {
            $id = $key + 2;
            $this->assertIsA($folder, 'newsFolderActiveRecord');
            $this->assertEqual($folder->get('name'), $this->data[$id]['name']);
        }

    }

    public function testGetItems()
    {
        $path = '';
        $newsFolder = $this->newsFolderTM->searchByName($path);
        $this->assertTrue($newsFolder->exists());

        $items = $newsFolder->getItems();
        var_dump($items);
    }
}

?>