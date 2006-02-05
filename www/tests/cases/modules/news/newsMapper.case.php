<?php

fileLoader::load('news/newsMapper');
fileLoader::load('news');

class newsMapperTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $map;

    public function __construct()
    {
        $this->map = array( 'id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId' ),
        'title' => array ( 'name' => 'title', 'accessor' => 'getTitle', 'mutator' => 'setTitle'),
        'text' => array ('name' => 'text', 'accessor' => 'getText', 'mutator' => 'setText'),
        'folder_id' => array ('name' => 'folder_id', 'accessor' => 'getFolderId', 'mutator' => 'setFolderId'));

        $this->db = DB::factory();
        $this->cleardb();
    }

    public function setUp()
    {
        $this->mapper = new newsMapper('news');
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `news_news`');
        //$this->db->query('ALTER TABLE `news_news`, auto_increment = 1');
    }

    public function testSave()
    {
        $news = new news($this->map);
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

        $total = $this->countNews();

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
        $this->assertEqual($news->getText(), 'text1');
        $this->assertEqual($news->getFolderId(), 11);

        $title = 'new_title';
        $text = 'new_text';
        $folder_id = 44;

        $news->setTitle($title);
        $news->setText($text);
        $news->setFolderId($folder_id);
        $this->mapper->update($news);

        $news2 = $this->mapper->searchById(1);
        $this->assertEqual($news2->getTitle(), $title);
        $this->assertEqual($news2->getText(), $text);
        $this->assertEqual($news2->getFolderId(), $folder_id);
    }

    public function testDelete()
    {
        $this->fixture($this->mapper);

        $this->assertEqual(4, $this->countNews());

        $news = $this->mapper->searchById(1);
        $this->mapper->delete($news);

        $this->assertEqual(3, $this->countNews());
    }

    private function countNews()
    {
        $query = 'SELECT COUNT(*) AS `total` FROM `news_news`';
        $total = $this->db->getOne($query);
        return $total;
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