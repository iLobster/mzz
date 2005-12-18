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

        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $title, PDO::PARAM_STR);
        $stmt->bindParam(3, $text, PDO::PARAM_STR);
        $id = '1'; $title = 'test_title_1'; $text = 'test_text_1';
        $stmt->execute();
        $id = '2'; $title = 'test_title_2'; $text = 'test_text_2';
        $stmt->execute();
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('DELETE FROM `news`');
    }

    public function testGetNews()
    {
        $id = 1;
        $newsAR = $this->newsTM->getNews($id);
        $this->assertEqual($newsAR->get('id'), $id);
    }

    public function testGetNewsNotExist()
    {
        $id = 0;
        $newsAR = $this->newsTM->getNews($id);
        $this->assertNull($newsAR->get('id'));
    }

    public function testDeleteNews()
    {
        $id = 1;
        $query = 'SELECT COUNT(*) AS `total` FROM `news` WHERE `id` = ' . $id;
        $result = $this->db->query($query);
        $total = $result->fetch(PDO::FETCH_OBJ)->total;
        $result->closeCursor();
        $this->newsTM->delete($id);
        $result = $this->db->query($query);
        $this->assertEqual($total - 1, 0);
    }

    public function testGetList()
    {
        $newsARarray = $this->newsTM->getList();

        $query = 'SELECT * FROM `news`';
        $result = $this->db->query($query);
        $i = 0;
        while ($data = $result->fetch()) {
            $this->assertEqual($newsARarray[$i]->extract(), $data);
            $i++;
        }
    }

    public function testUpdateNews()
    {
        $data =array('id' => 1, 'title' => 'new_test_title', 'text' => 'new_test_text');
        $this->newsTM->update($data);

        $query = 'SELECT COUNT(*) AS `count` FROM `news` WHERE `id` = :id AND `title` = :title AND `text`= :text';
        $stmt = $this->db->prepare($query);
        $stmt->bindArray($data);
        $stmt->execute();
        $result = $stmt->fetch();

        $this->assertEqual($result['count'], 1);

 $arr =  array('var' => '1st');
$query = 'SELECT :var AS `a`';
$stmt = $this->db->prepare($query);
//$stmt->bindArray($arr);
$stmt->bindParam(':var', $arr['var']);
$stmt->execute();
print_r($stmt->fetch());
//$arr = array('var' => '2nd');
 $arr['var'] =  '2st';
 $arr =  array('var' => '1st');
$stmt->execute();
print_r($stmt->fetch());
    }
}

?>