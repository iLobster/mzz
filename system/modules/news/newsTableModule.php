<?php

class newsTableModule
{
    private $db;

    public function __construct() {
        $this->db = DB::factory();
    }

    public function getNews($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM `news` WHERE `id` = ?');
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        return new newsActiveRecord($stmt, $this);
    }

    public function getList()
    {
        $result = array();
        //$stmt = $this->db->prepare('SELECT * FROM `news`');
        $stmt = $this->db->prepare('SELECT `id` FROM `news`');
        $stmt->execute(); $i = 0;
        while ($data = $stmt->fetch()) {
            //$result[$i] = new newsActiveRecord($stmt, $this);
            //$result[$i]->replaceData($data);
            $i++;
            $result[$i] = $this->getNews($data['id']);
            $result[$i]->get('id');
        }
        return $result;
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM `news` WHERE `id` = ?');
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>