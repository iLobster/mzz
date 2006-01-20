<?php

fileLoader::load('news/newsFolderTableModule');

mock::generate('httpRequest');

class newsFolderTableModuleTest extends unitTestCase
{
    private $newsFolderTM;
    private $data = array();

    public function setUp()
    {
        $this->db = DB::factory();
        $this->cleardb();

        $stmt = $this->db->prepare('INSERT INTO `news_news_tree` (`id`, `name`, `parent`) VALUES (:id, :name, :parent)');

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

        $request = new mockhttpRequest();
        $request->expectOnce('getSection', array());
        $this->newsFolderTM = new newsFolderTableModule($request);
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('DELETE FROM `news_news_tree`');
        $this->db->query('DELETE FROM `news_news`');
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
        $folders = $this->newsFolderTM->getFolders(1);
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
        $stmt = $this->db->prepare('INSERT INTO `news_news` (`id`, `title`, `text`, `folder_id`) VALUES (:id, :title, :text, :folder_id)');
        $data[1] = array('id' => 1, 'title' => 'test_title_1', 'text' => 'test_text_1', 'folder_id' => 1);
        $stmt->bindArray($data[1]);
        $stmt->execute();

        $data[2] = array('id' => 2, 'title' => 'test_title_2', 'text' => 'test_text_2', 'folder_id' => 1);
        $stmt->bindArray($data[2]);
        $stmt->execute();

        $data[3] = array('id' => 3, 'title' => 'test_title_3', 'text' => 'test_text_3', 'folder_id' => 2);
        $stmt->bindArray($data[3]);
        $stmt->execute();

        $items = $this->newsFolderTM->getItems(1);

        $this->assertEqual(sizeof($items), 2);

        foreach ($items as $key => $item) {
            $this->assertIsA($item, 'newsActiveRecord');
            $this->assertEqual($item->extract(), $data[$key + 1]);
        }
    }

    public function testDeleteFolder()
    {
        $id = 2;

        $query = 'SELECT COUNT(*) AS `total` FROM `news_news_tree` WHERE `id` = ' . $id;
        $result = $this->db->query($query);
        $total = $result->fetch(PDO::FETCH_OBJ)->total;
        $result->closeCursor();

        $this->assertTrue($this->newsFolderTM->delete($id));

        $result = $this->db->query($query);
        $total2 = $result->fetch(PDO::FETCH_OBJ)->total;
        $this->assertEqual($total - $total2, 1);
    }

    public function testUpdateFolder()
    {
        $data = array('id' => 2, 'name' => 'new_folder_name', 'parent' => 3);
        $this->assertTrue($this->newsFolderTM->update($data));

        $query = 'SELECT COUNT(*) AS `count` FROM `news_news_tree` WHERE `id` = :id AND `name` = :name AND `parent`= :parent';
        $stmt = $this->db->prepare($query);
        $stmt->bindArray($data);
        $stmt->execute();
        $result = $stmt->fetch();

        $this->assertEqual($result['count'], 1);
    }
}

?>