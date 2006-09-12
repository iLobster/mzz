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

fileLoader::load('db/dbTreeNS');
fileLoader::load('news/newsFolder');

class newsFolderMapper extends simpleMapper
{

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
    // protected $cacheable = array('searchByName', 'getFolders', 'getItems');

    /**
     * �������� ����� �������
     *
     * @var string
     */
    //protected $tablePostfix = '_folder';
    /**
     * �������� ����� �������
     *
     * @var string
     */
    protected $relationPostfix = 'folder_tree';

    /**
     * �����������
     *
     * @param string $section ������
     */
    public function __construct($section)
    {
        parent::__construct($section);
        $init = array ('data' => array('table' => $this->table, 'id' =>'parent'),
        'tree' => array('table' => $this->relationTable , 'id' =>'id'));

        $this->tree = new dbTreeNS($init, 'name');
    }

    /**
     * ��������� ����� ������� �� �����
     *
     * @param string $name ���
     * @return object|null
     */
    public function searchByName($name)
    {
        if (empty($name)) {
            $name = 'root';
        }
        return $this->searchOneByField('name', $name);
    }

    /**
     * ������� ������ newsFolder �� �������
     *
     * @param array $row
     * @return object
     */
    protected function createItemFromRow($row, $newsFolder)
    {
        if (empty($newsFolder)) {
            $map = $this->getMap();
            $newsFolder = new newsFolder($this, $map);
        }
        $row = $this->fill($row);
        $newsFolder->import($row);
        return $newsFolder;
    }

    /**
     * ���������� children-�����
     *
     * @return array
     */
    public function getFolders($id, $level = 1)
    {
        // ���������� ������ ����������� �������
        $rawFolders = $this->tree->getBranch($id, $level);
        foreach($rawFolders as $row) {
            $folders[] = $this->createItemFromRow($row);
        }

        return $folders;
    }

    /**
     * ������� ����� �� ������ ����
     *
     * @param string $path ����
     * @param string $deep ������� �������
     * @return array with nodes
     */
    public function getFolderByPath($path)
    {
        return $this->searchOneByField('path', $path);
    }

    /**
     * ������� �����(����������� �����) �� ������ ����
     *
     * @param  string     $path          ����
     * @param  string     $deep          ������� �������
     * @return array with nodes
     */
    public function getFoldersByPath($path, $deep = 1)
    {
        // ���������� ������ ����������� �������
        $rawFolders = $this->tree->getBranchByPath($path, $deep);
        foreach($rawFolders as $row) {
            $folders[] = $this->createItemFromRow($row);
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
        $newsMapper = new newsMapper($this->section());

        if (!empty($this->pager)) {
            $newsMapper->setPager($this->pager);
        }

        $result = $newsMapper->searchByFolder($id);

        return $result;
    }
    /*
    public function __sleep()
    {
    return array('name', 'section', 'tablePostfix', 'relationTable', 'cacheable', 'className', 'table', 'count', 'tree');
    }

    public function __wakeup()
    {
    }

    public function this()
    {
    return (!empty($this->cache)) ? $this->cache : $this;
    } */

    public function convertArgsToId($args)
    {
        $newsFolder = $this->getFolderByPath(implode('/', $args));
        return (int)$newsFolder->getObjId();
    }
}

?>