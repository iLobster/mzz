<?php

fileLoader::load('news/newsFolderMapper');
fileLoader::load('news/newsFolder');
fileLoader::load('news');

class newsFolderMapperTest extends unitTestCase
{
    private $mapper;
    private $db;

    public function __construct()
    {
        $this->db = DB::factory();
        $this->cleardb();
    }

    public function setUp()
    {
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
        $newsFolder = new newsFolder();
        $newsFolder->setName('somename');
        $newsFolder->setParent(2);

        $this->assertNull($newsFolder->getId());

        $this->mapper->save($newsFolder);

        $this->assertEqual($newsFolder->getId(), 1);
    }

    public function testGetItems()
    {
        $this->fixture($this->mapper);
        $newsMapper = new newsMapper('news');

        $data[] = array('title', 'text', 1);
        $data[] = array('title2', 'text2', 1);
        $data[] = array('title3', 'text3', 2);
        foreach ($data as $record) {
            $newsMapper->add($record[0], $record[1], $record[2]);
        }


        $newsFolder = $this->mapper->searchByName('name1');
        $news = $this->mapper->getItems($newsFolder);

        $this->assertEqual(count($news), 2);

        foreach ($news as $key => $item) {
            $this->assertIsA($item, 'news');
            $this->assertEqual($item->getTitle(), $data[$key][0]);
            $this->assertEqual($item->getFolderId(), $data[$key][2]);
        }

    }

    public function testGetFolders()
    {
        $this->fixture($this->mapper);
        $newsMapper = new newsMapper('news');


        $newsFolder = $this->mapper->searchByName('name1');
        $newsSubFolders = $this->mapper->getFolders($newsFolder);

        $this->assertEqual(count($newsSubFolders), 2);

        foreach ($newsSubFolders as $item) {
            $this->assertIsA($item, 'newsFolder');
            $this->assertEqual($item->getParent(), '1');
        }

    }

    public function testSearchByName()
    {
        $this->fixture($this->mapper);
        $this->assertIsA($newsFolder = $this->mapper->searchByName('name1'), 'newsFolder');
        $this->assertEqual($newsFolder->getId(), 1);
    }

    public function testAdd()
    {
        $name = 'name'; $parent = 3;
        $newsFolder = $this->mapper->add($name, $parent);

        $total = $this->countNewsFolder();

        $this->assertEqual($total, 1);
        $this->assertEqual($newsFolder->getId(), 1);
        $this->assertEqual($newsFolder->getName(), $name);
        $this->assertEqual($newsFolder->getParent(), $parent);
    }

    public function testUpdate()
    {
        $this->fixture($this->mapper);
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
        $this->fixture($this->mapper);

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

    private function fixture($mapper)
    {
        $mapper->add('name1', 0);
        $mapper->add('name2', 1);
        $mapper->add('name3', 1);
        $mapper->add('name4', 2);
    }
}

?>