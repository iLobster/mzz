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

/**
 * page: маппер для страниц
 *
 * @package page
 * @version 0.1.1
 */

class pageMapper extends simpleMapper
{
    protected $name = 'page';
    protected $className = 'page';

    public function create()
    {
        return new page($this, $this->getMap());
    }

    public function searchById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` WHERE `id` = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();

        if ($row) {
            return $this->createPageFromRow($row);
        } else {
            return false;
        }
    }

    public function searchByName($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` WHERE `name` = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        $row = $stmt->fetch();

        if ($row) {
            return $this->createPageFromRow($row);
        } else {
            return false;
        }
    }


    protected function createPageFromRow($row)
    {
        $map = $this->getMap();
        $page = new page($this, $map);
        $page->import($row);
        return $page;
    }

}

?>