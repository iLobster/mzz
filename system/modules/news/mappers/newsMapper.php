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

class newsMapper extends simpleMapper
{
    protected $name = 'news';
    protected $className = 'news';
    protected $cacheable = array('searchById');

    public function create()
    {
        return new news($this->getMap());
    }

    public function searchById($id)
    {
        $stmt = $this->searchByField('id', $id);
        $row = $stmt->fetch();

        if ($row) {
            return $this->createNewsFromRow($row);
        } else {
            return false;
        }
    }

    public function searchByFolder($folder_id)
    {
        $stmt = $this->searchByField('folder_id', $folder_id);
        $result = array();

        while ($row = $stmt->fetch()) {
            $result[] = $this->createNewsFromRow($row);
        }

        return $result;
    }

    protected function createNewsFromRow($row)
    {
        $map = $this->getMap();
        $news = new news($map);
        $news->import($row);
        return $news;
    }

    protected function updateDataModify(&$fields)
    {
        $fields['updated'] = time();
    }

    protected function insertDataModify(&$fields)
    {
        $fields['created'] = time();
        $fields['updated'] = $fields['created'];
    }
}

?>