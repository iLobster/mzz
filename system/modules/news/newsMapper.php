<?php

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

    public function save($news)
    {
        $stmt = $this->db->prepare("INSERT INTO  `" . $this->table . "` (`title`, `text`, `folder_id`) VALUES (:title, :text, :folder_id)");
        $data = array(
        'title' => $news->getTitle(),
        'text' => $news->getText(),
        'folder_id' => $news->getFolderId(),
        );
        $stmt->bindArray($data);
        if($stmt->execute()) {
            $id = $this->db->lastInsertID();
            $news->setId($id);
        }
    }

    public function add($title, $text, $folder_id)
    {
        $news = new news();
        $news->setTitle($title);
        $news->setText($text);
        $news->setFolderId($folder_id);
        $this->save($news);
        return $news;
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
        $news = new news($this);
        foreach($this->getMap() as $field) {
            $setprop = (string)$field->mutator;
            $value = $row[(string)$field->name];
            if ($setprop && $value) {
                call_user_func(array($news, $setprop), $value);
            }
        }
        return $news;
    }

    private function getMap()
    {
        if (!$this->map) {
            $mapFileName = fileLoader::resolve($this->getName() . '/map.xml');
            if (!is_file($mapFileName)) {
                throw new mzzIoException($mapFileName);
            }
            foreach(simplexml_load_file($mapFileName) as $field) {
                $this->map[(string)$field->name] = $field;
            }
        }
        return $this->map;
    }
}

?>