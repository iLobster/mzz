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
        if (!isset($this->data[$key]) && !$this->processed) {
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
        if ($this->exists()) {
            $stmt = $this->db->prepare('SELECT * FROM `news_tree` WHERE `id` = :id');
            $stmt->bindParam(':id', $this->get('id'), PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetch();
            foreach ($data as $key => $val) {
                $this->set($key, $val);
            }
        }
        $this->processed = true;
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

    public function getItems()
    {

    }
}

?>