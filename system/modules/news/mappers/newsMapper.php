<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

class newsMapper
{
    private $db;
    private $table;
    private $section;
    private $map = array();

    public function __construct($section)
    {
        $this->db = DB::factory();
        $this->section = $section;
        $this->table = $this->getName() . '_' .$this->getSection();
    }

    private function getName()
    {
        return 'news';
    }

    private function getSection()
    {
        return $this->section;
    }

    public function insert($news)
    {
        $map = $this->getMap();
        $field_names = array_keys($map);

        foreach ($field_names as $fieldname) {
            $getprop = $map[$fieldname]['accessor'];
            $data[$fieldname] = $news->$getprop();
        }

        if($this->db->autoExecute($this->table, $data)) {
            $id = $this->db->lastInsertID();
            $news->setId($id);
        }
    }

    public function update($news)
    {
        $map = $this->getMap();
        $field_names = array_keys($map);

        foreach ($field_names as $fieldname) {
            $getprop = $map[$fieldname]['accessor'];
            $data[$fieldname] = $news->$getprop();
        }

        return $this->db->autoExecute($this->table, $data, PDO_AUTOQUERY_UPDATE, "`id` = :id");

    }

    public function delete($news)
    {
        $stmt = $this->db->prepare('DELETE FROM `' . $this->table . '` WHERE `id` = :id');
        $stmt->bindParam(':id', $news->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function save($news)
    {
        if ($news->getId()) {
            $this->update($news);
        } else {
            $this->insert($news);
        }
    }

    public function searchById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();

        if ($row) {
            return $this->createNewsFromRow($row);
        } else {
            return false;
        }
    }

    public function searchByFolder($folder_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` WHERE folder_id = :folder_id");
        $stmt->bindParam(':folder_id', $folder_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = array();

        while ($row = $stmt->fetch()) {
            $result[] = $this->createNewsFromRow($row);
        }

        return $result;
    }

    private function createNewsFromRow($row)
    {
        $map = $this->getMap();
        $news = new news($map);

        foreach($map as $key => $field) {
            $setprop = $field['mutator'];
            $value = $row[$key];
            if ($setprop && $value) {
                call_user_func(array($news, $setprop), $value);
            }
        }
        return $news;
    }

    private function getMap()
    {
        if (empty($this->map)) {
            $mapFileName = fileLoader::resolve($this->getName() . '/maps/news.map.ini');
            $this->map = parse_ini_file($mapFileName, true);
        }
        return $this->map;
    }
}

?>