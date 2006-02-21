<?php

fileLoader::load('news/mappers/newsMapper');
fileLoader::load('news');

class newsMapperTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $map;

    public function __construct()
    {
        $this->map = array('id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId' ),
        'title' => array ( 'name' => 'title', 'accessor' => 'getTitle', 'mutator' => 'setTitle'),
        'text' => array ('name' => 'text', 'accessor' => 'getText', 'mutator' => 'setText'),
        'folder_id' => array ('name' => 'folder_id', 'accessor' => 'getFolderId', 'mutator' => 'setFolderId'),
        'created' => array ('name' => 'created', 'accessor' => 'getCreated', 'mutator' => 'setCreated'),
        'updated' => array ('name' => 'updated', 'accessor' => 'getUpdated', 'mutator' => 'setUpdated'),
        );

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

        $this->assertIdentical($news->getId(), '1');
    }

    public function testCreate()
    {
        $news = $this->mapper->create();
        $this->assertNull($news->getId());
        $this->assertNull($news->getTitle());
        $this->assertNull($news->getText());
        $this->assertNull($news->getFolderId());
    }

    public function testSearchById()
    {
        $this->fixture($this->mapper, $this->map);
        $this->assertIsA($news = $this->mapper->searchById(1), 'news');
        $this->assertIdentical($news->getId(), '1');
    }

    public function testSearchByFolderId()
    {
        $this->fixture($this->mapper, $this->map);

        $this->assertIsA($news_list = $this->mapper->searchByFolder(11), 'array');
        $this->assertEqual(2, sizeof($news_list));
    }

    public function testUpdate()
    {
        $this->fixture($this->mapper, $this->map);
        $news = $this->mapper->searchById(1);

        $this->assertEqual($news->getTitle(), 'title1');
        $this->assertEqual($news->getText(), 'text1');
        $this->assertIdentical($news->getFolderId(), '11');

        $title = 'new_title';
        $text = 'new_text';
        $folder_id = '44';

        $news->setTitle($title);
        $news->setText($text);
        $news->setFolderId($folder_id);
        $this->mapper->save($news);

        $news2 = $this->mapper->searchById(1);
        $this->assertEqual($news2->getTitle(), $title);
        $this->assertEqual($news2->getText(), $text);
        $this->assertIdentical($news2->getFolderId(), $folder_id);
    }

    public function testDelete()
    {
        $this->fixture($this->mapper, $this->map);

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

    private function fixture($mapper, $map)
    {
        for($i = 0; $i < 4; $i++) {
            $folders = array(11, 11, 13, 13);
            $news = new news($map);
            $news->setTitle('title' . ($i + 1));
            $news->setText('text' . ($i + 1));
            $news->setFolderId($folders[$i]);
            $mapper->save($news);
        }
    }
}

?>