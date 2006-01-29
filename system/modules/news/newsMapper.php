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
        /*
        $mapFileName = fileLoader::resolve($this->getName() . '/map.xml');
        if (!is_file($mapFileName)) {
        throw new mzzIoException($mapFileName);
        }
        $this->xml = simplexml_load_file($mapFileName);*/
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


    private function getName()
    {
        return 'news';
    }

    private function getSection()
    {
        return $this->section;
    }
}

?>