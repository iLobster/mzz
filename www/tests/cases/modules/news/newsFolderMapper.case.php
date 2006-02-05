<?php

fileLoader::load('news/newsFolderMapper');
fileLoader::load('news/newsFolder');
fileLoader::load('news');

class newsFolderMapperTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $map;
    public function __construct()
    {
        $this->db = DB::factory();
        $this->cleardb();
    }

    public function setUp()
    {
        $this->map = array('id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId'),
        'name' => array ('name' => 'name', 'accessor' => 'getName', 'mutator' => 'setName'),
        'parent' => array ('name' => 'parent', 'accessor' => 'getParent', 'mutator' => 'setParent')
        );

        $this->mapNews = array('id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId' ),
        'title' => array ( 'name' => 'title', 'accessor' => 'getTitle', 'mutator' => 'setTitle'),
        'text' => array ('name' => 'text', 'accessor' => 'getText', 'mutator' => 'setText'),
        'folder_id' => array ('name' => 'folder_id', 'accessor' => 'getFolderId', 'mutator' => 'setFolderId')
        );
        $this->mapper = new newsFolderMapper('news');
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `news_news_tree`');
    }

    public function testSave()
    {
        $newsFolder = new newsFolder($this->mapper, $this->map);
        $newsFolder->setName('somename');
        $newsFolder->setParent(2);

        $this->assertNull($newsFolder->getId());

        $this->mapper->save($newsFolder);

        $this->assertEqual($newsFolder->getId(), 1);
    }

    public function testGetItems()
    {
        $this->fixture($this->mapper, $this->map);
        $newsMapper = new newsMapper('news');

        $data[] = array('title', 'text', 1);
        $data[] = array('title2', 'text2', 1);
        $data[] = array('title3', 'text3', 2);
        foreach ($data as $record) {
            $news = new news($this->mapNews);
            $news->setTitle($record[0]);
            $news->setText($record[1]);
            $news->setFolderId($record[2]);
            $newsMapper->save($news);
        }


        $newsFolder = $this->mapper->searchByName('name1');
        $news = $newsFolder->getItems($this->mapper);

        $this->assertEqual(count($news), 2);

        foreach ($news as $key => $item) {
            $this->assertIsA($item, 'news');
            $this->assertEqual($item->getTitle(), $data[$key][0]);
            $this->assertEqual($item->getFolderId(), $data[$key][2]);
        }

    }

    public function testGetFolders()
    {
        $this->fixture($this->mapper, $this->map);
        $newsMapper = new newsMapper('news');


        $newsFolder = $this->mapper->searchByName('name1');
        $newsSubFolders = $newsFolder->getFolders();

        $this->assertEqual(count($newsSubFolders), 2);

        foreach ($newsSubFolders as $item) {
            $this->assertIsA($item, 'newsFolder');
            $this->assertEqual($item->getParent(), '1');
        }

    }

    public function testSearchByName()
    {
        $this->fixture($this->mapper, $this->map);
        $this->assertIsA($newsFolder = $this->mapper->searchByName('name1'), 'newsFolder');
        $this->assertEqual($newsFolder->getId(), 1);
    }

    public function testUpdate()
    {
        $this->fixture($this->mapper, $this->map);
        $newsFolder = $this->mapper->searchByName('name1');

        $this->assertEqual($newsFolder->getName(), 'name1');
        $this->assertEqual($newsFolder->getId(), 1);

        $name = 'new_name';
        $newsFolder->setName($name);
        $this->mapper->update($newsFolder);

        $newsFolder2 = $this->mapper->searchByName('new_name');
        $this->assertEqual($newsFolder2->getName(), $name);
        $this->assertEqual($newsFolder2->getId(), 1);
    }

    public function testDelete()
    {
        $this->fixture($this->mapper, $this->map);

        $this->assertEqual(4, $this->countNewsFolder());

        $newsFolder = $this->mapper->searchByName('name1');
        $this->mapper->delete($newsFolder);

        $this->assertEqual(3, $this->countNewsFolder());
    }

    private function countNewsFolder()
    {
        $query = 'SELECT COUNT(*) AS `total` FROM `news_news_tree`';
        $total = $this->db->getOne($query);
        return $total;
    }

    private function fixture($mapper, $map)
    {
        for($i = 0; $i < 4; $i++) {
            $parents = array(0, 1, 1, 2);
            $newsFolder = new newsFolder($mapper, $map);
            $newsFolder->setName('name' . ($i + 1));
            $newsFolder->setParent((string)$parents[$i]);
            $mapper->save($newsFolder);
        }
    }
}

?>