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
        'folder_id' => array ('name' => 'folder_id', 'accessor' => 'getFolderId', 'mutator' => 'setFolderId'),
        'created' => array ('name' => 'created', 'accessor' => 'getCreated', 'mutator' => 'setCreated'),
        'updated' => array ('name' => 'updated', 'accessor' => 'getUpdated', 'mutator' => 'setUpdated'),
        'obj_id' => array ('name' => 'obj_id','accessor' => 'getObjId', 'mutator' => 'setObjId'),
        );

        $this->db = DB::factory();
        $this->cleardb();
    }

    public function setUp()
    {
        $this->mapper = new newsMapper('news');
        $this->mapper->setMap($this->map);
        $this->cleardb();
        $this->db->query('INSERT INTO `user_user` (`id`, `login`) VALUES (1, \'guest\')');
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
        $user = $userMapper->searchById(1);
        $user->setLogin($newlogin = 'NEWLOGIN');

        $news = new news($this->map);
        $news->setTitle('sometitle');
        $news->setEditor($user);
        $news->setText('sometext');
        $news->setFolderId(10);

        $this->assertNull($news->getId());

        $this->mapper->save($news);

        $this->assertEqual($news->getEditor()->getLogin(), $newlogin);
        $this->assertIdentical($news->getId(), '1');
    }

    public function testCreate()
    {
        $news = $this->mapper->create();
        $this->assertNull($news->getId());
        $this->assertNull($news->getTitle());
        $this->assertNull($news->getEditor());
        $this->assertNull($news->getText());
        $this->assertNull($news->getFolderId());

        $userMapper = new userMapper('user');
        $user = $userMapper->searchById($id = 1);
        $user->setLogin($newlogin = 'NEWLOGIN');

        $news->setTitle($title = 'sometitle');
        $news->setText($text = 'sometext');
        $news->setEditor($user);

        $this->assertEqual($user->getLogin(), 'guest');

        $this->mapper->save($news);

        $this->assertEqual($news->getTitle(), $title);
        $this->assertEqual($news->getText(), $text);
        $this->assertEqual($news->getEditor()->getId(), $id);
        $this->assertEqual($news->getEditor()->getLogin(), $newlogin);
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
        $this->assertEqual($news->getEditor()->getId(), 1);
        $this->assertEqual($news->getText(), 'text1');
        $this->assertIdentical($news->getFolderId(), '11');

        $userMapper = new userMapper('user');
        $user = $userMapper->searchById(1);
        $user->setLogin($newlogin = 'NEWLOGIN');

        $title = 'new_title';
        $editor = $user;
        $text = 'new_text';
        $folder_id = '44';

        $news->setTitle($title);
        $news->setEditor($editor);
        $news->setText($text);
        $news->setFolderId($folder_id);
        $this->mapper->save($news);

        $news2 = $this->mapper->searchById(1);
        $this->assertEqual($news2->getTitle(), $title);
        $this->assertIsA($news2->getEditor(), 'user');
        $this->assertEqual($news2->getEditor()->getId(), $editor->getId());
        $this->assertEqual($news2->getEditor()->getLogin(), $newlogin);
        $this->assertEqual($news2->getText(), $text);
        $this->assertIdentical($news2->getFolderId(), $folder_id);
    }

    public function testDelete()
    {
        $this->fixture($this->mapper, $this->map);

        $this->assertEqual(4, $this->countNews());

        $this->mapper->delete(1);

        $this->assertEqual(3, $this->countNews());
    }

    public function testConvertArgsToId()
    {
        $this->fixture($this->mapper, $this->map);

        $news = $this->mapper->searchById($id = 1);

        $this->assertEqual($this->mapper->convertArgsToId(array($id, 2, 3)), $news->getObjId());
    }


    private function countNews()
    {
        $query = 'SELECT COUNT(*) AS `total` FROM `news_news`';
        $total = $this->db->getOne($query);
        return $total;
    }

    /**
     * @todo заменить на обычные запросы
     */
    private function fixture($mapper, $map)
    {

        for($i = 0; $i < 4; $i++) {
            $folders = array(11, 11, 13, 13);
            $news = new news($map);
            $news->setTitle('title' . ($i + 1));
            $news->setEditor($i + 1);
            $news->setText('text' . ($i + 1));
            $news->setFolderId($folders[$i]);
            $mapper->save($news);
        }
    }
}

?>