<?php

fileLoader::load('news/newsFolderTableModule');

class newsFolderTableModuleTest extends unitTestCase
{
    protected $tm;

    public function setUp()
    {
        $this->db = DB::factory();
        $this->cleardb();

        $stmt = $this->db->prepare('INSERT INTO `news_tree` (`id`, `name`) VALUES (:id, :name)');

        $data = array('id' => 1, 'name' => '');
        $stmt->bindArray($data);
        $stmt->execute();

        $data = array('id' => 2, 'name' => 'somefolder');
        $stmt->bindArray($data);
        $stmt->execute();
        
        $data = array('id' => 3, 'name' => 'blabla');
        $stmt->bindArray($data);
        $stmt->execute();

        $this->tm = new newsFolderTableModule();
    }

    public function cleardb()
    {
        $this->db->query('DELETE FROM `news_tree`');
    }

    public function testSelectFolder()
    {
        $this->assertTrue($this->tm->select('somefolder'));
    }

}

?>