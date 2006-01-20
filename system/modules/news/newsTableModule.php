<?php

class newsTableModule
{
    private $db;
    private $table;
    private $section;

    public function __construct($section)
    {
        $this->db = DB::factory();
        $this->section = $section;
        $this->table = $this->getName() . '_' .$this->getSection();
    }

    protected function getName()
    {
        return 'news';
    }

    private function getSection()
    {
        return $this->section;
    }

    public function searchById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM `' . $this->table . '` WHERE `id` = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return new newsActiveRecord($stmt, $this);
    }

    public function searchByFolder($id)
    {
        $result = array();
        $stmt = $this->db->prepare('SELECT * FROM `' . $this->table . '` WHERE `folder_id` = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $i = 0;
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[$i] = new newsActiveRecord($stmt, $this);
            $result[$i]->replaceData($data);
            $i++;
        }
        $stmt->closeCursor();
        return $result;
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM `' . $this->table . '` WHERE `id` = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update($data)
    {
        $stmt = $this->db->prepare('UPDATE `' . $this->table . '` SET `title` = :title, `text` = :text WHERE `id` = :id');
        $stmt->bindArray($data);
        return $stmt->execute();
    }
}

?>