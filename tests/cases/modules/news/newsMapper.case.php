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
        'editor' => array ( 'name' => 'editor', 'accessor' => 'getEditor', 'mutator' => 'setEditor', 'owns' => 'user.id', 'section' => 'user', 'module' => 'user'),
        'text' => array ('name' => 'text', 'accessor' => 'getText', 'mutator' => 'setText'),
        //'folder_id' => array ('name' => 'folder_id', 'accessor' => 'getFolderId', 'mutator' => 'setFolderId'),
        'created' => array ('name' => 'created', 'accessor' => 'getCreated', 'mutator' => 'setCreated'),
        'updated' => array ('name' => 'updated', 'accessor' => 'getUpdated', 'mutator' => 'setUpdated'),
        //'obj_id' => array('name' => 'obj_id', 'accessor' => 'getObjId', 'mutator' => 'setObjId'),
        );

        $this->db = DB::factory();
        $this->cleardb();
    }

    public function setUp()
    {
        $this->mapper = new newsMapper('news');
        $this->cleardb();
        $this->db->query("INSERT INTO `user_user` (`id`, `login`, `obj_id`) VALUES (1, 'guest', 1)");
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `news_news`');
        $this->db->query('TRUNCATE TABLE `user_user`');
    }

    public function testSave()
    {
        $userMapper = new userMapper('user');
        $user = $userMapper->searchById($editorId = '1');

        $news = new news($this->map);
        $news->setTitle($title = 'sometitle');
        $news->setEditor($user);
        $news->setText($text = 'sometext');
        //$news->setFolderId(10);

        $this->assertNull($news->getId());

        $this->mapper->save($news);

        $this->assertIdentical($news->getId(), '1');
        $this->assertIdentical($news->getText(), $text);
        $this->assertIdentical($news->getTitle(), $title);
        $this->assertIdentical($news->getEditor()->getId(), $editorId);
        $this->assertIdentical($news->getEditor()->getLogin(), 'guest');
    }

    public function testUpdate()
    {
        $this->db->query("INSERT INTO `news_news` (`id`, `obj_id`, `title`, `text`, `editor`) VALUES (1, 2, 'ttl1', 'txt1', 1), (2, 3, 'ttl2', 'txt2', 1)");

        $news = $this->mapper->searchById(1);

        $this->assertIdentical($news->getId(), '1');
        $this->assertIdentical($news->getTitle(), 'ttl1');

        $news->setTitle($newTitle = 'new_title');

        $this->assertIdentical($news->getTitle(), 'ttl1');

        $this->mapper->save($news);

        $this->assertIdentical($news->getTitle(), $newTitle);
        $this->assertIdentical($news->getEditor()->getId(), '1');
        $this->assertIdentical($news->getEditor()->getLogin(), 'guest');
    }

    public function testDelete()
    {
        $this->db->query("INSERT INTO `news_news` (`id`, `obj_id`, `title`, `text`, `editor`) VALUES (1, 2, 'ttl1', 'txt1', 1), (2, 3, 'ttl2', 'txt2', 1), (3, 4, 'ttl2', 'txt2', 1), (4, 5, 'ttl2', 'txt2', 1)");

        $this->assertEqual(4, $this->countNews());

        $this->mapper->delete(1);

        $this->assertEqual(3, $this->countNews());
    }

    private function countNews()
    {
        $query = 'SELECT COUNT(*) AS `total` FROM `news_news`';
        $total = $this->db->getOne($query);
        return $total;
    }
}

?>