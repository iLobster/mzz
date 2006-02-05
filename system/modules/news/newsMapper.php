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

    public function insert($news)
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

    public function update($news)
    {
        $stmt = $this->db->prepare('UPDATE `' . $this->table . '` SET `title` = :title, `text` = :text, `folder_id` = :folder_id WHERE `id` = :id');
        // 2 �������� - ��� ������ � ������������, ��� �������� ����� ��� ������
        // ���� � ������������ - �� ����� �������� ���� ������ ��� ����� �� �� ���������
        // ���� ��������� ������� (������� �������� � self::createNewsFromRow() �� ��������� ������� - ��� ���� ����� ��������� � �������� � $this->map ����..
        // ��� ��� ����� ��������
        $this->getMap();
        foreach (array('id', 'title', 'text', 'folder_id') as $fieldname) {
            $getprop = $this->map[$fieldname]['accessor'];
            // � ��� ����� ���������� ���?
            $stmt->bindParam(':' . $fieldname, $news->$getprop());
        }
        $stmt->execute();

    }

    public function delete($news)
    {
        $stmt = $this->db->prepare('DELETE FROM `' . $this->table . '` WHERE `id` = :id');
        $stmt->bindParam(':id', $news->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function save($news) {
        if ($news->getId()) {
            $this->update($news);
        } else {
            $this->insert($news);
        }
    }

    public function add($title, $text, $folder_id)
    {
        $news = new news($this->getMap());
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
        $news = new news($this->getMap());
        foreach($this->getMap() as $field) {
            $setprop = $field['mutator'];
            $value = $row[$field['name']];
            if ($setprop && $value) {
                call_user_func(array($news, $setprop), $value);
            }
        }
        return $news;
    }

    private function getMap()
    {
        if (!$this->map) {
            $mapFileName = fileLoader::resolve($this->getName() . '/news.map.ini');
            $this->map = parse_ini_file($mapFileName, true);
        }
        return $this->map;
    }
}

?>