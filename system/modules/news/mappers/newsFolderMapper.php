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
    protected $className = 'newsFolder';
    protected $cacheable = array('searchByName', 'getFolders', 'getItems');

    public function searchByName($name)
    {
        $stmt = $this->searchByField('name', $name);
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
        $newsFolder = new newsFolder($this->this(), $map);
        $newsFolder->import($row);
        return $newsFolder;
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
        $news = new newsMapper($this->section());
        return $news->searchByFolder($id);
    }

    public function __sleep()
    {
        return array('name', 'section', 'tablePostfix', 'cacheable', 'className', 'table');
    }
    public function __wakeup()
    {
    }

    public function this()
    {
        return (!empty($this->cache)) ? $this->cache : $this;
    }
}

?>
