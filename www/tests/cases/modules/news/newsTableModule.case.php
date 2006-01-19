<?php

fileLoader::load('news/newsTableModule');

class newsTableModuleTest extends unitTestCase
{
    protected $newsTM;
    protected $db;

    public function setUp()
    {
        $this->db = DB::factory();
        $this->cleardb();

        $this->newsTM = new newsTableModule();

        $stmt = $this->db->prepare('INSERT INTO `news_news` (`id`, `title`, `text`) VALUES (?, ?, ?)');

        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $title, PDO::PARAM_STR);
        $stmt->bindParam(3, $text, PDO::PARAM_STR);
        $id = '1'; $title = 'test_title_1'; $text = 'test_text_1';
        $stmt->execute();
        $id = '2'; $title = 'test_title_2'; $text = 'test_text_2';
        $stmt->execute();
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('DELETE FROM `news_news`');
    }

    public function testGetNews()
    {
        $id = 1;
        $newsAR = $this->newsTM->searchById($id);
        $this->assertEqual($newsAR->get('id'), $id);
    }

    public function testGetNewsNotExist()
    {
        $id = 0;
        $newsAR = $this->newsTM->searchById($id);
        $this->assertNull($newsAR->get('id'));
    }

    public function testDeleteNews()
    {
        $id = 1;
        $query = 'SELECT COUNT(*) AS `total` FROM `news_news` WHERE `id` = ' . $id;
        $result = $this->db->query($query);
        $total = $result->fetch(PDO::FETCH_OBJ)->total;
        $result->closeCursor();
        $this->newsTM->delete($id);
        $result = $this->db->query($query);
        $total2 = $result->fetch(PDO::FETCH_OBJ)->total;
        $this->assertEqual($total - $total2, 1);
    }

    public function testSearchByFolder()
    {
        $folder_id = 1;

        $newsARarray = $this->newsTM->searchByFolder($folder_id);

        $query = 'SELECT * FROM `news_news` WHERE `folder_id` = ' . $folder_id;
        $result = $this->db->query($query);
        $i = 0;
        while ($data = $result->fetch()) {
            $this->assertEqual($newsARarray[$i]->extract(), $data);
            $i++;
        }
    }

    public function testUpdateNews()
    {
        $data =array('id' => 1, 'title' => 'new_test_title', 'text' => 'new_test_text');
        $this->newsTM->update($data);

        $query = 'SELECT COUNT(*) AS `count` FROM `news_news` WHERE `id` = :id AND `title` = :title AND `text`= :text';
        $stmt = $this->db->prepare($query);
        $stmt->bindArray($data);
        $stmt->execute();
        $result = $stmt->fetch();

        $this->assertEqual($result['count'], 1);
    }
}

?>
