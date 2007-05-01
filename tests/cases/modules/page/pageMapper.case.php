<?php

fileLoader::load('page/mappers/pageMapper');
fileLoader::load('page');

class pageMapperTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $map;

    public function __construct()
    {
        $this->map = array(
        'id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId', 'once' => 'true' ),
        'name' => array ( 'name' => 'name', 'accessor' => 'getName', 'mutator' => 'setName'),
        'title' => array ( 'name' => 'title', 'accessor' => 'getTitle', 'mutator' => 'setTitle'),
        'content' => array ('name' => 'content', 'accessor' => 'getContent', 'mutator' => 'setContent'),
        'folder_id' => array ('name' => 'folder_id', 'accessor' => 'getFolder', 'mutator' => 'setFolder', 'owns' => 'pageFolder.id'),
        );

        $this->db = DB::factory();
        $this->cleardb();
    }

    public function setUp()
    {
        $this->mapper = new pageMapper('page');
        $this->db->query("INSERT INTO `user_user` (`login`) VALUES ('GUEST')");
        $this->db->query("INSERT INTO `sys_classes` (`name`, `module_id`) VALUES ('page', 1)");

        $this->db->query("INSERT INTO `page_pageFolder` (`id`, `path`, `parent`) VALUES (1, 'root', 1)");
        $this->db->query("INSERT INTO `page_pageFolder_tree` (`id`, `lkey`, `rkey`, `level`) VALUES (1, 1, 2, 1)");
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `page_page`');
        $this->db->query('TRUNCATE TABLE `page_pageFolder`');
        $this->db->query('TRUNCATE TABLE `page_pageFolder_tree`');
        $this->db->query('TRUNCATE TABLE `user_user`');
        $this->db->query('TRUNCATE TABLE `sys_classes`');
        $this->db->query('TRUNCATE TABLE `sys_classes_sections`');
        $this->db->query('TRUNCATE TABLE `sys_access_registry`');
    }

    public function testSave()
    {
        $page = new page($this->mapper, $this->map);
        $page->setName('somename');
        $page->setTitle('sometitle');
        $page->setContent('somecontent');

        $this->assertNull($page->getId());

        $this->mapper->save($page);

        $this->assertIdentical($page->getId(), '1');
    }

    public function testCreate()
    {
        $page = $this->mapper->create();
        $this->assertNull($page->getId());
        $this->assertNull($page->getName());
        $this->assertNull($page->getTitle());
        $this->assertNull($page->getContent());
    }

    public function testSearchById()
    {
        $this->fixture($this->mapper, $this->map);
        $this->assertIsA($page = $this->mapper->searchById(1), 'page');
        $this->assertIdentical($page->getId(), '1');
    }

    public function testSearchByName()
    {
        $this->fixture($this->mapper, $this->map);
        $this->assertIsA($page = $this->mapper->searchByName('name2'), 'page');
        $this->assertIdentical($page->getId(), '2');
    }

    public function testUpdate()
    {
        $this->fixture($this->mapper, $this->map);
        $page = $this->mapper->searchById(1);

        $this->assertEqual($page->getName(), 'name1');
        $this->assertEqual($page->getTitle(), 'title1');
        $this->assertEqual($page->getContent(), 'content1');

        $name = 'new_name';
        $title = 'new_title';

        $page->setName($name);
        $page->setTitle($title);
        $this->mapper->save($page);


        $page2 = $this->mapper->searchById(1);
        $this->assertEqual($page2->getName(), $name);
        $this->assertEqual($page2->getTitle(), $title);
    }

    public function testDelete()
    {
        $this->fixture($this->mapper, $this->map);

        $this->assertEqual(4, $this->countPages());

        $this->mapper->delete(1);

        $this->assertEqual(3, $this->countPages());
    }

    public function testConvertArgsToId()
    {
        $this->fixture($this->mapper, $this->map);

        $page = $this->mapper->searchByName($name = 'name2');
        $this->assertEqual($this->mapper->convertArgsToId(array('name' => $name)), $page->getObjId());
    }

    private function countPages()
    {
        $query = 'SELECT COUNT(*) AS `total` FROM `page_page`';
        $total = $this->db->getOne($query);
        return $total;
    }

    /**
     * @todo заменить на обычные запросы
     */
    private function fixture($mapper, $map)
    {
        $folderMapper = new pageFolderMapper('page');
        $folder = $folderMapper->searchByKey(1);

        for($i = 0; $i < 4; $i++) {
            $folders = array(11, 11, 13, 13);
            $page = new page($mapper, $map);
            $page->setName('name' . ($i + 1));
            $page->setTitle('title' . ($i + 1));
            $page->setContent('content' . ($i + 1));
            $page->setFolder($folder);
            $mapper->save($page);
        }
    }
}

?>