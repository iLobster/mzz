<?php

class skin
{
    private $id;

    private $db;

    private $name;

    private $title;

    public function __construct($id)
    {
        if (!is_array($id)) {
            $this->id = $id;

            $this->db = DB::factory();

            $stmt = $this->db->query('SELECT * FROM `sys_skins` WHERE `id` = ' . (int)$id);

            if (!$row = $stmt->fetch()) {
                $stmt = $this->db->query('SELECT * FROM `sys_skins` WHERE `id` = ' . (int)systemConfig::$defaultSkin);
                $row = $stmt->fetch();
            }
        } else {
            $this->id = $id['id'];
            $row  = $id;
        }

        $this->title = $row['title'];
        $this->name = $row['name'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public static function searchAll()
    {
        $db= DB::factory();
        $stmt = $db->query('SELECT * FROM `sys_skins`');

        $result = array();
        while ($row = $stmt->fetch()) {
            $result[$row['id']] = new skin($row);
        }

        return $result;
    }
}

?>