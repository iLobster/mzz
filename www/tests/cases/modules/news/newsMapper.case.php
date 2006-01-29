<?php

fileLoader::load('news/newsMapper');
fileLoader::load('news');

class newsMapperTest extends unitTestCase
{
    private $mapper;
    private $db;

    public function setUp()
    {
        $this->db = DB::factory();
        $this->cleardb();
        $this->mapper = new newsMapper('news');
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('DELETE FROM `news_news`');
        $this->db->query('ALTER TABLE `news_news`, auto_increment = 1');
    }

    public function testSave()
    {
        $news = new news();
        $news->setTitle('sometitle');
        $news->setText('sometext');
        $news->setFolderId(10);

        $this->assertNull($news->getId());

        $this->mapper->save($news);

        $this->assertEqual($news->getId(), 1);
    }

    public function testSearchById()
    {
        $this->fixture($this->mapper);
        $this->assertIsA($news = $this->mapper->searchById(1), 'news');
        $this->assertEqual($news->getId(), 1);
    }

    public function testAdd()
    {
        $title = 'title'; $text = 'text'; $folder_id = 2;
        $news = $this->mapper->add($title, $text, $folder_id);

        $query = 'SELECT COUNT(*) AS `total` FROM `news_news`';
        $result = $this->db->query($query);
        $total = $result->fetch(PDO::FETCH_OBJ)->total;
        $result->closeCursor();

        $this->assertEqual($total, 1);
        $this->assertEqual($news->getId(), 1);
        $this->assertEqual($news->getTitle(), $title);
        $this->assertEqual($news->getText(), $text);
        $this->assertEqual($news->getFolderId(), $folder_id);
    }

    public function testSearchByFolderId()
    {
        $this->fixture($this->mapper);

        $this->assertIsA($news_list = $this->mapper->searchByFolder(11), 'array');
        $this->assertEqual(2, sizeof($news_list));
    }

    public function testUpdate()
    {
        $this->fixture($this->mapper);
        $news = $this->mapper->searchById(1);

        $this->assertEqual($news->getTitle(), 'title1');

        $title = 'new_title';
        $news->setTitle($title);
        $this->mapper->update($news);

        $news2 = $this->mapper->searchById(1);
        $this->assertEqual($news2->getTitle(), $title);

    }

    private function fixture($mapper)
    {
        $mapper->add('title1', 'text1', 11);
        $mapper->add('title2', 'text2', 11);
        $mapper->add('title3', 'text3', 13);
        $mapper->add('title4', 'text4', 13);
    }
}

?>