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
        $data = array(
        'name' => $newsFolder->getName(),
        'parent' => $newsFolder->getParent(),
        );

        $stmt = $this->db->autoPrepare($this->table, array_keys($data));

        $stmt->bindArray($data);
        if($stmt->execute()) {
            $id = $this->db->lastInsertID();
            $newsFolder->setId($id);
        }
    }


    public function update($newsFolder)
    {
        // 2 варианта - или мапить в конструкторе, или выделить метод как сейчас
        // если в конструкторе - то можем почитать файл лишний раз когда он не требуется
        // если отдельным методом (юзается например в self::createNewsFromRow() то следующая строчка - для того чтобы прочитать и записать в $this->map мапу..
        // так что нужно подумать
        $this->getMap();
        $field_names = array_keys($this->map);

        $stmt = $this->db->autoPrepare($this->table, $field_names, PDO_AUTOQUERY_UPDATE, "`id` = :id");

        foreach ($field_names as $fieldname) {
            $getprop = $this->map[$fieldname]['accessor'];
            // а тут нужно определять тип?
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
        $this->getMap();
        $newsFolder = new newsFolder($this, $this->map);
        foreach($this->map as $key => $field) {
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
        if (!$this->map) {
            $mapFileName = fileLoader::resolve($this->getName() . '/newsFolder.map.ini');
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