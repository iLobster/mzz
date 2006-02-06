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

        $data = array(
        'title' => $news->getTitle(),
        'text' => $news->getText(),
        'folder_id' => $news->getFolderId(),
        );

        $stmt = $this->db->autoPrepare($this->table, array_keys($data));

        $stmt->bindArray($data);
        if($stmt->execute()) {
            $id = $this->db->lastInsertID();
            $news->setId($id);
        }
    }

    public function update($news)
    {
        // $stmt = $this->db->prepare('UPDATE `' . $this->table . '` SET `title` = :title, `text` = :text, `folder_id` = :folder_id WHERE `id` = :id');
        // 2 �������� - ��� ������ � ������������, ��� �������� ����� ��� ������
        // ���� � ������������ - �� ����� �������� ���� ������ ��� ����� �� �� ���������
        // ���� ��������� ������� (������� �������� � self::createNewsFromRow() �� ��������� ������� - ��� ���� ����� ��������� � �������� � $this->map ����..
        // ��� ��� ����� ��������
        $this->getMap();
        $field_names = array_keys($this->map);

        $stmt = $this->db->autoPrepare($this->table, $field_names, PDO_AUTOQUERY_UPDATE, "`id` = :id");

        foreach ($field_names as $fieldname) {
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
        $this->getMap();
        $news = new news($this->map);

        foreach($this->map as $key => $field) {
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
        if (!$this->map) {
            $mapFileName = fileLoader::resolve($this->getName() . '/maps/news.map.ini');
            $this->map = parse_ini_file($mapFileName, true);
        }
        return $this->map;
    }
}

?>