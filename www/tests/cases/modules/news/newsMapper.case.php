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

    public function fixture($mapper)
    {
        $mapper->add('tit1e1', 'text1', 11);
        $mapper->add('tit1e2', 'text2', 12);
        $mapper->add('tit1e3', 'text3', 13);
        $mapper->add('tit1e4', 'text4', 14);
    }
}

?>