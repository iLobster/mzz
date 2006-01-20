<?php

class newsFolderTableModule
{
    private $db;
    private $data;
    private $table;
    private $section;

    public function __construct($section)
    {
        $this->db = DB::factory();
        $this->section = $section;
        $this->table = $this->getName() . '_' .$this->getSection() . '_tree';
    }

    protected function getName()
    {
        return 'news';
    }

    private function getSection()
    {
        return $this->section;
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

    public function searchByName($name = "")
    {
        //$name = '/' . $name;
        $stmt = $this->db->prepare('SELECT * FROM `' . $this->table . '` WHERE `name` = :name');
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);

        return new newsFolderActiveRecord($stmt, $this);
    }

    public function getFolders($id)
    {
        $stmt = $this->db->prepare('SELECT `name` FROM `' . $this->table . '` WHERE `parent` = :id');
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
        $newsTM = new newsTableModule($this->getSection());
        return $newsTM->searchByFolder($id);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM `' . $this->table . '` WHERE `id` = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update($data)
    {
        $stmt = $this->db->prepare('UPDATE `' . $this->table . '` SET `name` = :name, `parent` = :parent WHERE `id` = :id');
        $stmt->bindArray($data);
        return $stmt->execute();
    }
}

?>