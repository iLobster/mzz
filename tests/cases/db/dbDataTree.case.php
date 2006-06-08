<?php
fileLoader::load('db/dbTreeNS');
fileLoader::load('modules/simple/simple.mapper');
fileLoader::load('cases/modules/simple/stubMapper.class');
fileLoader::load('cases/modules/simple/stubSimple.class');

class dbTreeDataTest extends unitTestCase
{
    private $db;
    private $tree;
    private $table;

    public function __construct()
    {
        $this->db = db::factory();
        $this->table = 'simple_simple_tree';
        $this->dataTable = 'simple_simple';

        $init = array ('data' => array('table' => $this->dataTable, 'id' =>'id'),
                       'tree' => array('table' => $this->table , 'id' =>'id'));

        $this->tree = new dbTreeNS($init);
        $this->mapper = new stubMapper($section = 'simple');
        //echo'<pre>';print_r($this->mapper); echo'</pre>';
        //echo'<pre>';print_r($this); echo'</pre>';
        $this->clearDb();
        //$this->fixture();
    }

    public function setUp()
    {
        //$this->clearDb();
        $this->fixture();
    }
    public function tearDown()
    {
         $this->clearDb();
        //$this->fixture();
    }

    private function clearDb()
    {
        $this->db->query('TRUNCATE TABLE `' . $this->table .'`');
        $this->db->query('TRUNCATE TABLE `' .  $this->dataTable .'`');

    }

    private function setFixture($idArray, $fixture = 'treeFixture')
    {   if(is_array($this->$fixture))
        foreach($idArray as $id) {
            $fixture[$id] = $this->$fixture[$id];
        }

        return $fixture;
    }

    private function fixture()
    {
        # заполнение фикстуры дерева
        $this->treeFixture = array('1' => array('lkey'=>1 ,'rkey' =>16,'level'=>1),
                       '2' => array('lkey'=>2 ,'rkey' =>7 ,'level'=>2),
                       '3' => array('lkey'=>8 ,'rkey' =>13,'level'=>2),
                       '4' => array('lkey'=>14,'rkey'=>15 ,'level'=>2),
                       '5' => array('lkey'=>3 ,'rkey'=>4  ,'level'=>3),
                       '6' => array('lkey'=>5 ,'rkey'=>6  ,'level'=>3),
                       '7' => array('lkey'=>9 ,'rkey'=>10 ,'level'=>3),
                       '8' => array('lkey'=>11,'rkey'=>12 ,'level'=>3)
                       );
        $valString = '';
        foreach($this->treeFixture as $id => $data) {
            $valString .= "('" . $id . "','" . $data['lkey'] . "','" . $data['rkey'] . "','" . $data['level'] . "'),";
        }
        $values[$this->table] = substr($valString, 0,  strlen($valString)-1);

        #заполнение фикстуры таблицы данных
        $valString = '';
        foreach($this->treeFixture as $id => $row) {
            $this->dataFixture[$id] = array('id' => $id, 'foo' =>'foo' . $id , 'bar' => 'bar' . $id);
            $valString .= "('" . $id . "','" . $this->dataFixture[$id]['foo'] . "','" . $this->dataFixture[$id]['bar'] . "'),";
        }
        $values[$this->dataTable] = substr($valString, 0,  strlen($valString)-1);

        #запись фикстур в базу
        foreach($values as $table => $val) {
            $stmt = $this->db->prepare(' INSERT INTO `' .$table. '` VALUES ' . $val);
            //$stmt->bindParam(':table', $table, PDO::PARAM_STR);
            $stmt->execute();

            }
    }

    public function testGetTree()
    {
        $tree = $this->tree->getTree($level = 2);
        foreach($tree as $id => $row) {
            $this->assertEqual($this->dataFixture[$id], $row);
        }
    }
}



?>