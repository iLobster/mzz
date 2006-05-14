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

class pageMapper
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
        return 'page';
    }

    private function getSection()
    {
        return $this->section;
    }

    public function create()
    {
        return new page($this->getMap());
    }

    protected function insert($page)
    {
        $stmt = $this->db->prepare('INSERT INTO `' . $this->table . '` (`name`, `title`, `content`) VALUES (:name, :title, :content)');
        $stmt->bindParam(':name', $page->getName());
        $stmt->bindParam(':title', $page->getTitle());
        $stmt->bindParam(':content', $page->getContent());

        $id = $stmt->execute();
        $page->setId($id);

        /*
        $map = $this->getMap();
        $field_names = array_keys($map);

        foreach ($field_names as $fieldname) {
        $getprop = $map[$fieldname]['accessor'];
        $data[$fieldname] = $news->$getprop();
        }

        if (($id = $this->db->autoExecute($this->table, $data))) {
        $news->setId($id);
        }*/
    }

    protected function update($page)
    {
        $stmt = $this->db->prepare('UPDATE  `' . $this->table . '` SET `name` = :name, `title` = :title, `content` = :content WHERE `id` = :id');
        $stmt->bindParam(':id', $page->getId(), PDO::PARAM_INT);
        $stmt->bindParam(':name', $page->getName());
        $stmt->bindParam(':title', $page->getTitle());
        $stmt->bindParam(':content', $page->getContent());

        return $stmt->execute();

        /**$map = $this->getMap();
        $field_names = array_keys($map);

        foreach ($field_names as $fieldname) {
        $getprop = $map[$fieldname]['accessor'];
        $data[$fieldname] = $news->$getprop();
        }

        return $this->db->autoExecute($this->table, $data, PDO_AUTOQUERY_UPDATE, "`id` = :id");*/

    }

    public function delete($page)
    {
        $stmt = $this->db->prepare('DELETE FROM `' . $this->table . '` WHERE `name` = :name');
        $stmt->bindParam(':name', $page->getName());
        return $stmt->execute();
    }

    public function save($page)
    {
        //$news->disableDataspaceFilter();
        if ($page->getId()) {
            $this->update($page);
        } else {
            $this->insert($page);
        }
    }

    public function searchById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` WHERE `id` = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();

        if ($row) {
            return $this->createPageFromRow($row);
        } else {
            return false;
        }
    }

    public function searchByName($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` WHERE `name` = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        $row = $stmt->fetch();

        if ($row) {
            return $this->createPageFromRow($row);
        } else {
            return false;
        }
    }


    private function createPageFromRow($row)
    {
        $map = $this->getMap();

        /*$dateFilter = new dateFormatValueFilter();
        $fields = new changeableDataspaceFilter(new arrayDataspace(array()));
        $fields->addReadFilter('created', $dateFilter);
        $fields->addReadFilter('updated', $dateFilter);*/

        $page = new page($map);

        foreach ($map as $key => $field) {
            $setprop = $field['mutator'];
            $value = $row[$key];
            if ($setprop && $value) {
                call_user_func(array($page, $setprop), $value);
            }
        }
        return $page;
    }

    private function getMap()
    {
        if (empty($this->map)) {
            $mapFileName = fileLoader::resolve($this->getName() . '/maps/page.map.ini');
            $this->map = parse_ini_file($mapFileName, true);
        }
        return $this->map;
    }
}

?>