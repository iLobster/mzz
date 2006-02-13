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

class newsFolderMapper
{
    private $db;
    private $table;
    private $section;
    private $map = array();

    public function __construct($section)
    {
        $this->db = DB::factory();
        $this->section = $section;
        $this->table = $this->getName() . '_' .$this->getSection() . '_tree';;
    }

    private function getName()
    {
        return 'news';
    }

    private function getSection()
    {
        return $this->section;
    }

    protected function insert($newsFolder)
    {
        $map = $this->getMap();
        $field_names = array_keys($map);

        foreach ($field_names as $fieldname) {
            $getprop = $map[$fieldname]['accessor'];
            $data[$fieldname] = $newsFolder->$getprop();
        }

        if($this->db->autoExecute($this->table, $data)) {
            $id = $this->db->lastInsertID();
            $newsFolder->setId($id);
        }
    }

    protected function update($newsFolder)
    {
        $map = $this->getMap();
        $field_names = array_keys($map);

        foreach ($field_names as $fieldname) {
            $getprop = $map[$fieldname]['accessor'];
            $data[$fieldname] = $newsFolder->$getprop();
        }

        return $this->db->autoExecute($this->table, $data, PDO_AUTOQUERY_UPDATE, "`id` = :id");
    }

    public function delete($newsFolder)
    {
        $stmt = $this->db->prepare('DELETE FROM `' . $this->table . '` WHERE `id` = :id');
        $stmt->bindParam(':id', $newsFolder->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function save($newsFolder)
    {
        if ($newsFolder->getId()) {
            $this->update($newsFolder);
        } else {
            $this->insert($newsFolder);
        }
    }

    public function searchByName($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` WHERE `name` = :name");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch();

        if ($row) {
            return $this->createNewsFolderFromRow($row);
        } else {
            return false;
        }
    }


    private function createNewsFolderFromRow($row)
    {
        $map = $this->getMap();
        $newsFolder = new newsFolder($this, $map);
        foreach($map as $key => $field) {
            $setprop = $field['mutator'];
            $value = $row[$key];
            if ($setprop && $value) {
                call_user_func(array($newsFolder, $setprop), $value);
            }
        }
        return $newsFolder;
    }

    private function getMap()
    {
        if (empty($this->map)) {
            $mapFileName = fileLoader::resolve($this->getName() . '/maps/newsFolder.map.ini');
            $this->map = parse_ini_file($mapFileName, true);
        }
        return $this->map;
    }

    public function getFolders($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` WHERE `parent` = :parent");
        $stmt->bindParam(':parent', $id, PDO::PARAM_INT);
        $stmt->execute();
        $folders = array();

        while ($row = $stmt->fetch()) {
            $folders[] = $this->createNewsFolderFromRow($row);
        }

        return $folders;
    }

    public function getItems($id)
    {
        $news = new newsMapper($this->getSection());
        return $news->searchByFolder($id);
    }
}

?>