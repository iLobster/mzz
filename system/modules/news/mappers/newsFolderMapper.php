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
 * newsFolderMapper: ������ ��� ����� ��������
 *
 * @package news
 * @version 0.2
 */

class newsFolderMapper extends simpleMapper
{
    /**
     * �������� ����� �������
     *
     * @var string
     */
    protected $tablePostfix = '_tree';

    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'news';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'newsFolder';

    /**
     * ������ ���������� �������
     *
     * @var array
     */
    protected $cacheable = array('searchByName', 'getFolders', 'getItems');

    /**
     * ��������� ����� ������� �� �����
     *
     * @param string $name ���
     * @return object|false
     */
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

    /**
     * ������� ������ newsFolder �� �������
     *
     * @param array $row
     * @return object
     */
    private function createNewsFolderFromRow($row)
    {
        $map = $this->getMap();
        $newsFolder = new newsFolder($this->this(), $map);
        $newsFolder->import($row);
        return $newsFolder;
    }

    /**
     * ���������� children-�����
     *
     * @return array
     */
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

    /**
     * ���������� �������, ����������� � ������ �����
     *
     * @return array
     */
    public function getItems($id)
    {
        $news = new newsMapper($this->section());
        return $news->searchByFolder($id);
    }

    /**
     * Magic method __sleep
     *
     * @return array
     */
    public function __sleep()
    {
        return array('name', 'section', 'tablePostfix', 'cacheable', 'className', 'table');
    }

    /**
     * Magic method __wakeup
     *
     */
    public function __wakeup()
    {
    }

    /**
     * ���������� ������ �� ������ ������ ��� �� ������ ������ cache
     *
     * @return object
     */
    public function this()
    {
        return (!empty($this->cache)) ? $this->cache : $this;
    }
}

?>
