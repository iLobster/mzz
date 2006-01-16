<?php

class newsFolderTableModule
{
    private $db;
    private $data;
    
    public function __construct()
    {
        $this->db = DB::factory();
    }
    
    public function get($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }
    
    private function set($key, $value)
    {
        $this->data[$key] = $value;
    }
    
    public function select($name)
    {
        $stmt = $this->db->prepare('SELECT * FROM `news_tree` WHERE `name` = :name');
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        
        if ($result = $stmt->fetch()) {
            $this->set('id', $result['id']);
            return true;
        }
        return false;
    }
}

?>