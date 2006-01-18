<?php

class newsTableModule
{
    private $db;

    public function __construct()
    {
        $this->db = DB::factory();
    }

    public function searchById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM `news` WHERE `id` = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return new newsActiveRecord($stmt, $this);
    }

    public function searchByFolder($id)
    {
        $result = array();
        $stmt = $this->db->prepare('SELECT * FROM `news` WHERE `folder_id` = :id');
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
        $stmt = $this->db->prepare('DELETE FROM `news` WHERE `id` = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update($data)
    {
        $stmt = $this->db->prepare('UPDATE `news` SET `title` = :title, `text` = :text WHERE `id` = :id');
        $stmt->bindArray($data);
        return $stmt->execute();
    }
}

?>