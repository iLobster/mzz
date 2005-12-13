<?php

class newsTableModule
{
    private $db;

    public function __construct() {
        $this->db = DB::factory();
    }

    public function getNews($id) {
        $stmt = $this->db->prepare('SELECT * FROM `news` WHERE `id` = ?');
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        return new newsActiveRecord($stmt, $this);
    }

    public function getList()
    {
        $stmt = $this->db->prepare('SELECT * FROM `news`');
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM `news` WHERE `id` = ?');
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>