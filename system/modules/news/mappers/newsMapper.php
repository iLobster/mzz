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

    public function create()
    {
        return new news($this->getMap());
    }

    protected function insert($news)
    {
        $stmt = $this->db->prepare('INSERT INTO `' . $this->table . '` (`title`, `editor`, `text`, `folder_id`, `created`, `updated`) VALUES (:title, :editor, :text, :folder_id, UNIX_TIMESTAMP(), UNIX_TIMESTAMP())');
        $stmt->bindParam(':title', $news->getTitle());
        $stmt->bindParam(':editor', $news->getEditor());
        $stmt->bindParam(':text', $news->getText());
        $stmt->bindParam(':folder_id', $news->getFolderId(), PDO::PARAM_INT);

        $id = $stmt->execute();
        $news->setId($id);

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

    protected function update($news)
    {
        $stmt = $this->db->prepare('UPDATE  `' . $this->table . '` SET `title`= :title, `editor` = :editor, `text`= :text, `folder_id` = :folder_id,  `updated`= UNIX_TIMESTAMP() WHERE `id` = :id');
        $stmt->bindParam(':id', $news->getId(), PDO::PARAM_INT);
        $stmt->bindParam(':title', $news->getTitle());
        $stmt->bindParam(':editor', $news->getEditor());
        $stmt->bindParam(':text', $news->getText());
        $stmt->bindParam(':folder_id', $news->getFolderId());
        $stmt->bindParam(':created', $news->getCreated(), PDO::PARAM_INT);

        return $stmt->execute();

        /**$map = $this->getMap();
        $field_names = array_keys($map);

        foreach ($field_names as $fieldname) {
        $getprop = $map[$fieldname]['accessor'];
        $data[$fieldname] = $news->$getprop();
        }

        return $this->db->autoExecute($this->table, $data, PDO_AUTOQUERY_UPDATE, "`id` = :id");*/

    }

    public function delete($news)
    {
        $stmt = $this->db->prepare('DELETE FROM `' . $this->table . '` WHERE `id` = :id');
        $stmt->bindParam(':id', $news->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function save($news)
    {
        //$news->disableDataspaceFilter();
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

        /*$dateFilter = new dateFormatValueFilter();
        $fields = new changeableDataspaceFilter(new arrayDataspace(array()));
        $fields->addReadFilter('created', $dateFilter);
        $fields->addReadFilter('updated', $dateFilter);*/

        $news = new news($map);

        foreach ($map as $key => $field) {
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