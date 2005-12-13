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
    protected $TM;
    public function setUp()
    {
        $this->db = Db::factory();

        $this->cleardb();

        $stmt = $this->db->prepare('INSERT INTO `news` (`id`, `title`, `text`) VALUES (?, ?, ?)');
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $title, PDO::PARAM_STR);
        $stmt->bindParam(3, $text, PDO::PARAM_STR);
        $id = '1'; $title = 'test_title_1'; $text = 'test_text_1';
        $stmt->execute();

        $this->TM = new mocknewsTableModule();
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('DELETE FROM news');
    }

    public function testGetOne()
    {
        $id = 1;
        $stmt = $this->db->prepare('SELECT * FROM `news` WHERE `id` = ?');
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $newsAR = new newsActiveRecord($stmt, $this->TM);
        $this->assertEqual($newsAR->get('id'), 1);
    }

    public function testDeleteNews()
    {
        $id = 1;
        $stmt = $this->db->prepare('SELECT * FROM `news` WHERE `id` = ?');
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $newsAR = new newsActiveRecord($stmt, $this->TM);
        $this->TM->expectOnce('delete', array('1'));

        $this->assertIsA($newsAR, 'newsActiveRecord');
        $newsAR->delete();
    }

    public function testExtract()
    {
        $id = 1;
        $stmt = $this->db->prepare('SELECT * FROM `news` WHERE `id` = ?');
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $newsAR = new newsActiveRecord($stmt, $this->TM);
        $this->assertEqual($newsAR->extract(), array('id' => 1, 'title' => 'test_title_1', 'text' => 'test_text_1'));
    }

    public function testReplaceData()
    {
        $stmt = $this->db->prepare('SELECT * FROM `news`');
        $data = array('id' => 5, 'title' => 'test_title_5', 'text' => 'test_text_5');
        $newsAR = new newsActiveRecord($stmt, $this->TM);
        $newsAR->replaceData($data);

        $this->assertEqual($newsAR->get('id'), 5);
        $this->assertEqual($newsAR->get('title'), 'test_title_5');
    }

}

?>