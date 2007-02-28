<?php

fileLoader::load('news/mappers/newsFolderMapper');
fileLoader::load('news/newsFolder');
fileLoader::load('news/mappers/newsMapper');
fileLoader::load('news');
fileLoader::load('db/dbTreeNS');

class newsFolderMapperTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $map;
    private $target;

    public function __construct()
    {
        $this->db = DB::factory();
        $this->cleardb();
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
        'folder_id' => array ('name' => 'folder_id', 'accessor' => 'getFolder', 'mutator' => 'setFolder', 'owns' => 'newsFolder.id'),
        'created' => array ('name' => 'created', 'accessor' => 'getCreated', 'mutator' => 'setCreated'),
        'updated' => array ('name' => 'updated', 'accessor' => 'getUpdated', 'mutator' => 'setUpdated'),
        );


        $this->mapper = new newsFolderMapper('news');

        $init = array ('mapper' => $this->mapper, 'joinField' => 'parent', 'treeTable' => 'news_newsFolder_tree');

        $this->tree = new dbTreeNS($init, 'name');

        $this->cleardb();

        $this->db->query("INSERT INTO `user_user` (`login`) VALUES ('GUEST')");
        $this->db->query("INSERT INTO `sys_classes` (`name`, `module_id`) VALUES ('news', 1), ('newsFolder', 1)");

        $this->db->query("INSERT INTO `news_newsFolder` (`id`, `name`, `parent`, `path`) VALUES (1, 'name1', 1, 'name1')");
        $this->db->query("INSERT INTO `news_newsFolder_tree` (`id`, `lkey`, `rkey`, `level`) VALUES (1, 1, 2, 1)");
        $this->target = $this->mapper->searchOneByField('id', 1);
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `news_news`');
        $this->db->query('TRUNCATE TABLE `news_newsFolder`');
        $this->db->query('TRUNCATE TABLE `news_newsFolder_tree`');
        $this->db->query('TRUNCATE TABLE `user_user`');
        $this->db->query('TRUNCATE TABLE `sys_classes`');
        $this->db->query('TRUNCATE TABLE `sys_classes_sections`');
        $this->db->query('TRUNCATE TABLE `sys_access_registry`');
    }

    public function testSave()
    {
        $newsFolder = new newsFolder($this->mapper, $this->map);
        $newsFolder->setName('somename');
        // $newsFolder->setParent(2);

        $this->assertNull($newsFolder->getId());

        $this->mapper->save($newsFolder, $this->target);

        $this->assertIdentical($newsFolder->getId(), '2');
    }

    public function testGetItems()
    {
        $this->fixture($this->mapper, $this->map);
        $newsMapper = new newsMapper('news');

        $newsFolderMapper = new newsFolderMapper('news');

        $data[1] = array('title', 1, 'text', '1');
        $data[2] = array('title2', 2, 'text2', '1');
        $data[3] = array('title3', 2, 'text3', '2');

        foreach ($data as $record) {
            $folder = $newsFolderMapper->searchOneByField('id', $record[3]);

            $news = new news($this->mapNews);
            $news->setTitle($record[0]);
            $news->setEditor($record[1]);
            $news->setText($record[2]);
            $news->setFolder($folder);
            $newsMapper->save($news);
        }

        $news = $this->mapper->getItems(1);

        $this->assertEqual(count($news), 2);

        foreach ($news as $key => $item) {
            $this->assertIsA($item, 'news');
            $this->assertEqual($item->getTitle(), $data[$key][0]);
            $this->assertIdentical($item->getFolder()->getId(), $data[$key][3]);
        }
    }

    public function testGetFolders()
    {
        $this->fixture($this->mapper, $this->map);

        $newsSubFolders = $this->mapper->getFolders(1, 9999);

        $this->assertEqual(count($newsSubFolders), 8);

        foreach ($newsSubFolders as $item) {
            $this->assertIsA($item, 'newsFolder');
            //$this->assertIdentical($item->getParent(), '1'); (todo????)
        }
    }

    public function testGetFoldersByPath()
    {
        $this->fixture($this->mapper, $this->map);
        $fixturePath = '/name1/name2/';

        $newsSubFolders = $this->mapper->getFoldersByPath($fixturePath);

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

    public function testCreateSubfolder()
    {
        $this->fixture($this->mapper, $this->map);

        $parentFolder = $this->mapper->searchById(3);
        $newFolder = new newsFolder($this->mapper, $this->map);
        $newFolder->setName('new');

        $newFolder = $this->mapper->createSubfolder($newFolder, $parentFolder);

        $this->assertEqual($newFolder->getName(), 'new');
        $this->assertEqual($newFolder->getParent(), 9);
        $this->assertEqual($newFolder->getLevel(), 3);
    }

    public function testDelete()
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();
        $request->save();
        $request->setSection('news');

        $this->fixture($this->mapper, $this->map);

        $this->assertEqual(8, $this->countNewsFolder());

        $this->mapper->remove(2);

        $this->assertEqual(5, $this->countNewsFolder());

        $request->restore();
    }

    private function countNewsFolder()
    {
        $query = 'SELECT COUNT(*) AS `total` FROM `news_newsFolder`';
        return $this->db->getOne($query);
    }

    public function testConvertArgsToId()
    {
        $this->fixture($this->mapper, $this->map);

        $newsFolder = $this->mapper->searchByPath($name = 'name1/name2');

        $this->assertEqual($this->mapper->convertArgsToId(array('name' => $name)), $newsFolder->getObjId());
    }

    private function fixture($mapper, $map)
    {
        $nodeParentsFixture = array(1 => 0, 2 => 1, 3 => 1, 4 => 1, 5 => 2, 6 => 2, 7 => 3, 8 => 3);

        for($i = 2; $i <= 8; $i++) {

            $newsFolder = new newsFolder($mapper, $map);
            $newsFolder->setName('name' . $i);
            //$newsFolder = $this->tree->insertNode($nodeParentsFixture[$i], $newsFolder);

            $target = $this->mapper->searchOneByField('id', $nodeParentsFixture[$i]);

            $this->mapper->save($newsFolder, $target);
            $this->fixtureNewsFolder[$newsFolder->getId()] = $newsFolder;
        }
    }
}

?>