<?php

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

    public function insert($newsFolder)
    {
        $stmt = $this->db->prepare("INSERT INTO  `" . $this->table . "` (`name`, `parent`) VALUES (:name, :parent)");
        $data = array(
        'name' => $newsFolder->getName(),
        'parent' => $newsFolder->getParent(),
        );
        $stmt->bindArray($data);
        if($stmt->execute()) {
            $id = $this->db->lastInsertID();
            $newsFolder->setId($id);
        }
    }


    public function update($newsFolder)
    {
        $stmt = $this->db->prepare('UPDATE `' . $this->table . '` SET `name` = :name, `parent` = :parent WHERE `id` = :id');
        // 2 �������� - ��� ������ � ������������, ��� �������� ����� ��� ������
        // ���� � ������������ - �� ����� �������� ���� ������ ��� ����� �� �� ���������
        // ���� ��������� ������� (������� �������� � self::createNewsFromRow() �� ��������� ������� - ��� ���� ����� ��������� � �������� � $this->map ����..
        // ��� ��� ����� ��������
        $this->getMap();
        foreach (array('id', 'name', 'parent') as $fieldname) {
            $getprop = $this->map[$fieldname]['accessor'];
            // � ��� ����� ���������� ���?
            $stmt->bindParam(':' . $fieldname, $newsFolder->$getprop());
        }
        $stmt->execute();

    }

    public function delete($newsFolder)
    {
        $stmt = $this->db->prepare('DELETE FROM `' . $this->table . '` WHERE `id` = :id');
        $stmt->bindParam(':id', $newsFolder->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function save($newsFolder) {
        if ($newsFolder->getId()) {
            $this->update($newsFolder);
        } else {
            $this->insert($newsFolder);
        }
    }

    public function add($name, $parent)
    {
        $newsFolder = new newsFolder($this);
        $newsFolder->setName($name);
        $newsFolder->setParent($parent);
        $this->save($newsFolder);
        return $newsFolder;
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
        $newsFolder = new newsFolder($this);
        foreach($this->getMap() as $field) {
            $setprop = $field['mutator'];
            $value = $row[$field['name']];
            if ($setprop && $value) {
                call_user_func(array($newsFolder, $setprop), $value);
            }
        }
        return $newsFolder;
    }

    private function getMap()
    {
        if (!$this->map) {
            $mapFileName = fileLoader::resolve($this->getName() . '/newsFolder.map.ini');
            $this->map = parse_ini_file($mapFileName, true);
        }
        return $this->map;
    }

    public function getFolders($newsFolder)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` WHERE `parent` = :parent");
        $stmt->bindParam(':parent', $newsFolder->getId(), PDO::PARAM_INT);
        $stmt->execute();
        $folders = array();

        while ($row = $stmt->fetch()) {
            $folders[] = $this->createNewsFolderFromRow($row);
        }

        $newsFolder->setFolders($folders);
    }

    public function getItems($newsFolder)
    {
        $news = new newsMapper($this->getSection());
        $newsFolder->setItems($news->searchByFolder($newsFolder->getId()));
    }
}

?>