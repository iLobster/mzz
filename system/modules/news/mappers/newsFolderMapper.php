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

fileLoader::load('cache');

class newsFolderMapper extends simpleMapper
{
    protected $tablePostfix = '_tree';
    protected $name = 'news';
    protected $className = 'newsFolder';
    protected $cacheable = array('searchByName');

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
        //$cache = new cache(systemConfig::$pathToTemp . '/cache');
        $news = new newsMapper($this->getSection());
        return $news->searchByFolder($id);
        //return $cache->call(array($news, 'searchByFolder'), array($id));
    }

    public function __sleep()
    {
        //$this->db = null;
        return array('name', 'section', 'tablePostfix', 'cacheable', 'className', 'table');
    }
    public function __wakeup()
    {
        //$this->db = DB::factory();
    }
}

?>
