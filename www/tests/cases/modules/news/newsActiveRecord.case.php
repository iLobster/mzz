<?php

fileLoader::load('news/newsActiveRecord');
fileLoader::load('news/newsTableModule');
fileLoader::load('db/dbFactory');
fileLoader::load('core/registry');
$registry = Registry::instance();
$registry->setEntry('config', 'config');

mock::generate('newsTableModule');

class newsActiveRecordTest extends unitTestCase
{
    protected $db;
    public function setUp()
    {
        $this->db = Db::factory();

        $this->cleardb();

        $stmt = $this->db->prepare('INSERT INTO `news` (`id`, `title`, `text`) VALUES (?, ?, ?)');
        $stmt->bind_param('iss', $id, $title, $text);
        $id = '1'; $title = 'test_title_1'; $text = 'test_text_1';
        $stmt->execute();
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('DELETE FROM news');
    }

    public function testFirst()
    {
        $TM = new mocknewsTableModule();
        $id = 1;
        $stmt = $this->db->prepare('SELECT * FROM news WHERE id = ?');
        $stmt->bind_param('i', $id);
        $newsAR = new newsActiveRecord($stmt, $TM);
        $this->assertEqual($newsAR->get('id'), 1);
    }

    public function testDeleteNews()
    {
        $TM = new mocknewsTableModule();

        $id = 1;
        $stmt = $this->db->prepare('SELECT * FROM news WHERE id = ?');
        $stmt->bind_param('i', $id);
        $newsAR = new newsActiveRecord($stmt, $TM);
        $TM->expectOnce('delete', array(1));
        $TM->setReturnValue('getNews', $newsAR);

        $newsAR = $TM->getNews(1);
        $this->assertIsA($newsAR, 'newsActiveRecord');
        $newsAR->delete();
    }

}

?>