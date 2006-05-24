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
 * page: ������ ��� �������
 *
 * @package page
 * @version 0.1.1
 */

class pageMapper extends simpleMapper
{
    protected $name = 'page';
    protected $className = 'page';
    protected $cacheable = array('searchByName');

    public function create()
    {
        return new page($this->getMap());
    }

    public function searchById($id)
    {
        $stmt = $this->searchByField('id', $id);
        $row = $stmt->fetch();

        if ($row) {
            return $this->createPageFromRow($row);
        } else {
            return false;
        }
    }

    public function searchByName($name)
    {
        $stmt = $this->searchByField('name', $name);
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
        $page = new page($map);
        $page->import($row);
        return $page;
    }

    public function __sleep()
    {
        return array('name', 'section', 'tablePostfix', 'cacheable', 'className', 'table');
    }
    public function __wakeup()
    {
    }
}

?>