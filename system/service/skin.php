<?php

class skin
{
    private $id;

    private $db;

    private $name;

    public function __construct($id)
    {
        $this->id = $id;

        $this->db = DB::factory();

        $stmt = $this->db->query('SELECT `name` FROM `sys_skins` WHERE `id` = ' . (int)$id);

        if (!$row = $stmt->fetch()) {
            $stmt = $this->db->query('SELECT `name` FROM `sys_skins` WHERE `id` = ' . (int)systemConfig::$defaultSkin);
            $row = $stmt->fetch();
        }

        $this->name = $row['name'];
    }

    public function getName()
    {
        return $this->name;
    }
}

?>