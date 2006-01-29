<?php
/*
fileLoader::load('news/newsActiveRecord');
fileLoader::load('news/newsTableModule');

mock::generate('newsTableModule');*/

class newsActiveRecordTest extends unitTestCase
{/*
    protected $db;
    protected $TM;
    public function setUp()
    {
        $this->db = Db::factory();

        $this->cleardb();

        $stmt = $this->db->prepare('INSERT INTO `news_news` (`id`, `title`, `text`, `folder_id`) VALUES (?, ?, ?, ?)');
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $title, PDO::PARAM_STR);
        $stmt->bindParam(3, $text, PDO::PARAM_STR);
        $stmt->bindParam(4, $folder_id, PDO::PARAM_INT);
        $id = '1'; $title = 'test_title_1'; $text = 'test_text_1'; $folder_id = 1;
        $stmt->execute();

        $this->TM = new mocknewsTableModule();
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('DELETE FROM `news_news`');
    }

    public function testGetOne()
    {
        $id = 1;
        $stmt = $this->db->prepare('SELECT * FROM `news_news` WHERE `id` = ?');
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $newsAR = new newsActiveRecord($stmt, $this->TM);
        $this->assertEqual($newsAR->get('id'), 1);
    }

    public function testDeleteNews()
    {
        $id = 1;
        $stmt = $this->db->prepare('SELECT * FROM `news_news` WHERE `id` = ?');
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $newsAR = new newsActiveRecord($stmt, $this->TM);
        $this->TM->expectOnce('delete', array((string)$id));

        $this->assertIsA($newsAR, 'newsActiveRecord');
        $newsAR->delete();
    }

    public function testExtract()
    {
        $id = 1;
        $stmt = $this->db->prepare('SELECT * FROM `news_news` WHERE `id` = ?');
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $newsAR = new newsActiveRecord($stmt, $this->TM);
        $this->assertEqual($newsAR->extract(), array('id' => 1, 'title' => 'test_title_1', 'text' => 'test_text_1', 'folder_id' => '1'));
    }

    public function testReplaceData()
    {
        $stmt = $this->db->prepare('SELECT * FROM `news_news`');
        $data = array('id' => 5, 'title' => 'test_title_5', 'text' => 'test_text_5');
        $newsAR = new newsActiveRecord($stmt, $this->TM);
        $newsAR->replaceData($data);

        $this->assertEqual($newsAR->get('id'), 5);
        $this->assertEqual($newsAR->get('title'), 'test_title_5');
    }

    public function testUpdateNews()
    {
        $data =array('id' => 1, 'title' => 'new_test_title', 'text' => 'new_test_text');
        $this->TM->expectOnce('update', array($data));

        $stmtStub = new PDOStatement();
        $newsAR = new newsActiveRecord($stmtStub, $this->TM);
        $newsAR->update($data);
    }
    public function testCreateNews()
    {
        $data =array('title' => 'new_test_title', 'text' => 'new_test_text', 'folder_id' => 'folder_id');
        $this->TM->expectOnce('create', array($data));
        $this->TM->setReturnValue('create', true);

        $stmtStub = new PDOStatement();
        $newsAR = new newsActiveRecord($stmtStub, $this->TM);
        $this->assertTrue($newsAR->create($data));
    }*/
}

?>