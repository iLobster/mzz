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
    protected $cacheable = array('searchByName', 'getFolders', 'getItems');

    /**
     * �������� ����� �������
     *
     * @var string
     */
    protected $tablePostfix = '_folder';
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

        $this->tree = new dbTreeNS($init);
        //echo'<pre>';print_r($this); echo'</pre>';
    }

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
        $newsFolder->count = $this->getCount();
        return $newsFolder;
    }

    /**
     * ���������� children-�����
     *
     * @return array
     */
    public function getFolders($id)
    {
        // ���������� ������ ����������� �������
        $rawFolders = $this->tree->getBranch($id, 1);
        //echo'<pre>';var_dump($id); echo'</pre>';
        foreach($rawFolders as $row) {
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
        $result = $news->searchByFolder($id);
        
        //$this->count = $news->getCount();
        
        return array($result, $news->getCount());
    }

    /**
     * Magic method __sleep
     *
     * @return array
     */
    public function __sleep()
    {
        return array('name', 'section', 'tablePostfix', 'relationTable', 'cacheable', 'className', 'table', 'count');
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