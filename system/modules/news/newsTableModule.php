<?php

class newsTableModule
{
    private $db;

    public function __construct() {
        $this->db = DB::factory();
    }

    public function getNews($id) {
        //$id = 0;
        $stmt = $this->db->prepare('SELECT * FROM news WHERE id = ?');
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        return new newsActiveRecord($stmt, $this);
    }

    public function getList()
    {
//$stmt = $this->db->prepare();
    }

    public function delete($id)
    {
        return $this->db->query('DELETE FROM news WHERE id = ' . $id);
    }
}

?>