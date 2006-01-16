<?php

class newsFolderTableModule
{
    private $db;
    private $path;
    private $data;
    
    public function __construct($path)
    {
        $this->path = $path;
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
    
    public function exists()
    {
        $stmt = $this->db->prepare('SELECT * FROM `news_tree` WHERE `name` = :name');
        $stmt->bindParam(':name', $this->path, PDO::PARAM_STR);
        $stmt->execute();
        
        if ($result = $stmt->fetch()) {
            $this->set('id', $result['id']);
            return true;
        }
        return false;
    }
}

?>