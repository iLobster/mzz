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

    public function getFolders($newsFolder)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` WHERE `parent` = :parent");
        $stmt->bindParam(':parent', $newsFolder->getId(), PDO::PARAM_INT);
        $stmt->execute();
        $folders = array();

        while ($row = $stmt->fetch()) {
            $folders[] = $this->createNewsFolderFromRow($row);
        }

        return $folders;
    }

    public function getItems($newsFolder)
    {
        $news = new newsMapper('news');
        return $news->searchByFolder($newsFolder->getId());
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
        // 2 варианта - или мапить в конструкторе, или выделить метод как сейчас
        // если в конструкторе - то можем почитать файл лишний раз когда он не требуется
        // если отдельным методом (юзается например в self::createNewsFromRow() то следующая строчка - для того чтобы прочитать и записать в $this->map мапу..
        // так что нужно подумать
        $this->getMap();
        foreach (array('id', 'name', 'parent') as $fieldname) {
            $field = $this->map[$fieldname];
            $getprop = (string)$field->accessor;
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

    public function add($name, $parent)
    {
        $newsFolder = new newsFolder();
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
        $newsFolder = new newsFolder();
        foreach($this->getMap() as $field) {
            $setprop = (string)$field->mutator;
            $value = $row[(string)$field->name];
            if ($setprop && $value) {
                call_user_func(array($newsFolder, $setprop), $value);
            }
        }
        return $newsFolder;
    }

    private function getMap()
    {
        if (!$this->map) {
            $mapFileName = fileLoader::resolve($this->getName() . '/newsFolder.map.xml');
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