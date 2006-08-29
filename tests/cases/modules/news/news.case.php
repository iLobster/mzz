<?php

fileLoader::load('news');
fileLoader::load('news/mappers/newsMapper');

Mock::generate('newsMapper');

class newsTest extends unitTestCase
{
    private $news;
    private $db;

    public function setUp()
    {
        $map = array(
        'id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId', 'once' => 'true' ),
        'title' => array ( 'name' => 'title', 'accessor' => 'getTitle', 'mutator' => 'setTitle'),
        'editor' => array ( 'name' => 'editor', 'accessor' => 'getEditor', 'mutator' => 'setEditor'),
        'text' => array ('name' => 'text', 'accessor' => 'getText', 'mutator' => 'setText'),
        'folder_id' => array ('name' => 'folder_id', 'accessor' => 'getFolderId', 'mutator' => 'setFolderId'),
        'created' => array ('name' => 'created', 'accessor' => 'getCreated', 'mutator' => 'setCreated', 'once' => 'true' ),
        'updated' => array ('name' => 'updated', 'accessor' => 'getUpdated', 'mutator' => 'setUpdated', 'once' => 'true' ),
        );

        $this->db = DB::factory();
        $this->news = new news($map);
        $this->mapper = new newsMapper('news');
        $this->cleardb();
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


}


?>