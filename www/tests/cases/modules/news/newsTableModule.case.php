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

        $stmt = $this->db->prepare('INSERT INTO `news` (`id`, `title`, `text`) VALUES (?, ?, ?)');

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
        $this->db->query('DELETE FROM `news`');
    }

    public function testGetNews()
    {
        $id = 1;
        $newsAR = $this->newsTM->getNews($id);
        $this->assertEqual($newsAR->get('id'), $id);
    }

    public function testGetNewsNotExist()
    {
        $id = 0;
        $newsAR = $this->newsTM->getNews($id);
        $this->assertNull($newsAR->get('id'));
    }

    public function testDeleteNews()
    {
        $id = 1;
        $query = 'SELECT COUNT(*) AS `total` FROM `news` WHERE `id` = ' . $id;
        $result = $this->db->query($query);
        $this->assertEqual($result->fetch(PDO::FETCH_OBJ)->total, 1);
        $result->closeCursor();
        $this->newsTM->delete($id);
        $result = $this->db->query($query);
        $this->assertEqual($result->fetch(PDO::FETCH_OBJ)->total, 0);
    }

    public function testGetList()
    {
        $newsARarray = $this->newsTM->getList();

        $query = 'SELECT * FROM `news`';
        $result = $this->db->query($query);
        $i = 0;
        while ($data = $result->fetch()) {
            //$this->assertEqual($newsARarray[$i]->extract(), $data);
            $this->assertEqual($newsARarray[$i]->get('id'), $data['id']);
            $i++;
        }
    }

}

?>