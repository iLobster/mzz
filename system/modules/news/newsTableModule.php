<?php

class newsTableModule
{
    private $db;

    public function __construct() {
        $this->db = DB::factory();
    }

    public function getNews($id) {
        $stmt = $this->db->prepare('SELECT * FROM news WHERE id = ' . $id);
        return new newsActiveRecord($stmt, $this);
    }

    public function delete($id)
    {
        return $this->db->query('DELETE FROM news WHERE id = ' . $id);
    }
}

?>