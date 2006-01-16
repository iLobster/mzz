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
        if ($key == 'id') {
            $this->exists();
        }
        if (sizeof($this->data) <= 1 && $key != 'id') {
            $this->process();
        }
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    private function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function process()
    {
        $stmt = $this->db->prepare('SELECT * FROM `news_tree` WHERE `id` = :id');
        $stmt->bindParam(':id', $this->get('id'), PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch();
        foreach ($data as $key => $val) {
            $this->set($key, $val);
        }
    }

    public function exists()
    {
        $stmt = $this->db->prepare('SELECT id FROM `news_tree` WHERE `name` = :name');
        $stmt->bindParam(':name', $this->path, PDO::PARAM_STR);
        $stmt->execute();

        if ($result = $stmt->fetch()) {
            $this->set('id', $result['id']);
            return true;
        }
        return false;
    }

    public function getFolders()
    {
        if ($this->exists()) {
            $id = $this->get('id');
            $stmt = $this->db->prepare('SELECT * FROM `news_tree` WHERE `parent` = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $c = __CLASS__;

            $result = array();

            while ($folder = $stmt->fetch()) {
                $result[] = new $c($folder['name']);
            }

            return $result;
        }
        return null;
    }
}

?>