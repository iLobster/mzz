<?php

fileLoader::load('news/mappers/newsFolderMapper');
fileLoader::load('news/newsFolder');
fileLoader::load('news');
fileLoader::load('db/dbTreeNS');

class newsFolderMapperTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $map;

    public function __construct()
    {
        $this->db = DB::factory();
        $this->cleardb();
        $init = array ('data' => array('table' => 'news_news_folder', 'id' =>'parent'),
                       'tree' => array('table' => 'news_news_folder_tree' , 'id' =>'id'));

        $this->tree = new dbTreeNS($init, 'name');

    }

    public function setUp()
    {
        $this->map = array(
        'id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId'),
        'name' => array ('name' => 'name', 'accessor' => 'getName', 'mutator' => 'setName'),
        'parent' => array ('name' => 'parent', 'accessor' => 'getParent', 'mutator' => 'setParent'),
        'path' => array ('name' => 'path', 'accessor' => 'getPath', 'mutator' => 'setPath')
        );

        $this->mapNews = array(
        'id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId' ),
        'title' => array ( 'name' => 'title', 'accessor' => 'getTitle', 'mutator' => 'setTitle'),
        'editor' => array ( 'name' => 'editor', 'accessor' => 'getEditor', 'mutator' => 'setEditor'),
        'text' => array ('name' => 'text', 'accessor' => 'getText', 'mutator' => 'setText'),
        'folder_id' => array ('name' => 'folder_id', 'accessor' => 'getFolderId', 'mutator' => 'setFolderId'),
        'created' => array ('name' => 'created', 'accessor' => 'getCreated', 'mutator' => 'setCreated'),
        'updated' => array ('name' => 'updated', 'accessor' => 'getUpdated', 'mutator' => 'setUpdated'),
        );
        $this->mapper = new newsFolderMapper('news');
        //echo'<pre>';print_r($this->mapper); echo'</pre>';
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `news_news_folder`');
        $this->db->query('TRUNCATE TABLE `news_news_folder_tree`');
    }

    public function testSave()
    {
        $newsFolder = new newsFolder($this->mapper, $this->map);
        $newsFolder->setName('somename');
        $newsFolder->setParent(2);

        $this->assertNull($newsFolder->getId());

        $this->mapper->save($newsFolder);

        $this->assertIdentical($newsFolder->getId(), '1');
    }

    public function testGetItems()
    {
        $this->fixture($this->mapper, $this->map);
        $newsMapper = new newsMapper('news');

        $data[] = array('title', 'editor', 'text', '1');
        $data[] = array('title2', 'editor2', 'text2', '1');
        $data[] = array('title3', 'editor3', 'text3', '2');
        foreach ($data as $record) {
            $news = new news($this->mapNews);
            $news->setTitle($record[0]);
            $news->setEditor($record[1]);
            $news->setText($record[2]);
            $news->setFolderId($record[3]);
            $newsMapper->save($news);
        }

        $news = $this->mapper->getItems(1);

        $this->assertEqual(count($news), 2);

        foreach ($news as $key => $item) {
            $this->assertIsA($item, 'news');
            $this->assertEqual($item->getTitle(), $data[$key][0]);
            $this->assertIdentical($item->getFolderId(), $data[$key][3]);
        }
    }

    public function testGetFolders()
    {
        $this->fixture($this->mapper, $this->map);

        $newsSubFolders = $this->mapper->getFolders(1);

        $this->assertEqual(count($newsSubFolders), 4);

        foreach ($newsSubFolders as $item) {
            $this->assertIsA($item, 'newsFolder');
            //$this->assertIdentical($item->getParent(), '1');
        }
    }

    public function testGetFoldersByPath()
    {
        $this->fixture($this->mapper, $this->map);
        $fixturePath = '/name1/name2/';

        $newsSubFolders = $this->mapper->getFoldersByPath($fixturePath);
        //echo"<pre>";print_r($newsSubFolders); echo"</pre>";

        $this->assertEqual(count($newsSubFolders), 2);

        foreach ($newsSubFolders as $item) {
            $this->assertIsA($item, 'newsFolder');
            $this->assertEqual($item->getId(), $this->fixtureNewsFolder[$item->getId()]->getId());
            $this->assertEqual($item->getName(), $this->fixtureNewsFolder[$item->getId()]->getName());
            $this->assertEqual($item->getParent(), $this->fixtureNewsFolder[$item->getId()]->getParent());
        }
    }

    public function testSearchByName()
    {
        $this->fixture($this->mapper, $this->map);
        $this->assertIsA($newsFolder = $this->mapper->searchByName('name1'), 'newsFolder');
        $this->assertIdentical($newsFolder->getId(), '1');
    }

    public function testUpdate()
    {
        $this->fixture($this->mapper, $this->map);
        $newsFolder = $this->mapper->searchByName('name1');

        $this->assertEqual($newsFolder->getName(), 'name1');
        $this->assertIdentical($newsFolder->getId(), '1');

        $name = 'new_name';
        $newsFolder->setName($name);
        $this->mapper->save($newsFolder);

        $newsFolder2 = $this->mapper->searchByName('new_name');
        $this->assertEqual($newsFolder2->getName(), $name);
        $this->assertIdentical($newsFolder2->getId(), '1');
    }

    public function testDelete()
    {
        $this->fixture($this->mapper, $this->map);

        $this->assertEqual(8, $this->countNewsFolder());

        $this->mapper->delete(1);

        $this->assertEqual(7, $this->countNewsFolder());
    }

    private function countNewsFolder()
    {
        $query = 'SELECT COUNT(*) AS `total` FROM `news_news_folder`';
        $total = $this->db->getOne($query);
        return $total;
    }



    private function fixture($mapper, $map)
    {

        $nodeParentsFixture = array(1 => 0, 2 => 1, 3 => 1, 4 => 1, 5 => 2, 6 => 2, 7 => 3, 8 => 3);

        for($i = 1; $i <= 8; $i++) {
            if($i == 1) {
                $node = $this->tree->insertRootNode();
            } else {
                $node = $this->tree->insertNode($nodeParentsFixture[$i]);
            }

            $newsFolder = new newsFolder($mapper, $map);
            $newsFolder->setName('name' . ($i));
            $newsFolder->setParent($node['id']);
            $mapper->save($newsFolder);

            //  ����� ���
            $newsFolder->setPath($this->tree->createPathFromTreeByID($node['id']));
            $mapper->save($newsFolder);
            // ��� �� ���
            //$this->tree->updatePath($newsFolder->getId(), $node['id']);

            $this->fixtureNewsFolder[$node['id']] = $newsFolder;
            //echo"<pre>";print_r($this->fixtureNewsFolder); echo"</pre>";


        }
    }

}

?>