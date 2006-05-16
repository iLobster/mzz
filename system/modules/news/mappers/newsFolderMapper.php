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

class newsFolderMapper extends simpleMapper
{
    protected $tablePostfix = '_tree';
    protected $name = 'news';

    protected function insert($newsFolder)
    {
        $fields = $newsFolder->export();

        if (sizeof($fields) > 0) {

            $field_names = '`' . implode('`, `', array_keys($fields)) . '`';
            $markers  = ':' . implode(', :', array_keys($fields));

            $stmt = $this->db->prepare('INSERT INTO `' . $this->table . '` (' . $field_names . ') VALUES (' . $markers . ')');

            $stmt->bindArray($fields);

            $id = $stmt->execute();

            $fields['id'] = $id;

            $newsFolder->import($fields);
        }
    }

    protected function update($newsFolder)
    {
        $fields = $newsFolder->export();
        if (sizeof($fields) > 0) {

            $query = '';
            foreach(array_keys($fields) as $val) {
                if($val == 'updated') {
                    $query .= '`' . $val . '` = : UNIX_TIMESTAMP(), ';
                } else {
                    $query .= '`' . $val . '` = :' . $val . ', ';
                }
            }
            $query = substr($query, 0, -2);
            $stmt = $this->db->prepare('UPDATE  `' . $this->table . '` SET ' . $query . ' WHERE `id` = :id');

            $stmt->bindArray($fields);
            $stmt->bindParam(':id', $newsFolder->getId(), PDO::PARAM_INT);


            $newsFolder->import($fields);

            return $stmt->execute();
        }

        return false;
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
        $newsFolder->import($row);
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