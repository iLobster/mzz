<?php

class newsFolderTableModule
{
    private $db;
    private $data;
    private $processed = false;

    public function __construct()
    {
        $this->db = DB::factory();
    }

    public function get($key)
    {
        if (sizeof($this->data) === 0) {
            $this->process();
        }

        return (isset($this->data[$name])) ? $this->data[$name] : null;
    }

    private function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function searchByName($name)
    {
        $stmt = $this->db->prepare('SELECT * FROM `news_tree` WHERE `name` = :name');
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);

        return new newsFolderActiveRecord($stmt, $this);
    }

    public function getFolders($id)
    {
        $stmt = $this->db->prepare('SELECT `name` FROM `news_tree` WHERE `parent` = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();

        $folders = array();
        while ($data = $stmt->fetch()) {
            $folders[] = $this->searchByName($data['name']);
        }

        return $folders;
    }

    public function getItems($id)
    {

    }
}

?>