<?php

fileLoader::load('news/newsTableModule');

class newsTableModuleTest extends unitTestCase
{
    protected $newsTM;
    protected $db;

    public function setUp()
    {
        $this->db = DB::factory();
        $this->cleardb();

        $this->newsTM = new newsTableModule();

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

    public function testGetNews()
    {
        $id = 1;
        $query = 'SELECT COUNT(*) as total FROM news WHERE id = ' . $id;
        $result = $this->db->query($query);
        $this->assertEqual($result->fetch_object()->total, 1);
        $this->newsTM->delete($id);
        $result = $this->db->query($query);
        $this->assertEqual($result->fetch_object()->total, 0);
    }

}

?>