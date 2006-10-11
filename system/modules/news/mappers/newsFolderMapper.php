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
 * @package modules
 * @subpackage news
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
     * �����������
     *
     * @param string $section ������
     */
    public function __construct($section)
    {
        parent::__construct($section);
        $init = array ('data' => array('table' => $this->table, 'id' =>'parent'),
        'tree' => array('table' => $section . '_' . $this->className . '_tree' , 'id' =>'id'));

        $this->tree = new dbTreeNS($init, 'name');
    }

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
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
     * ���������� �������� ������, ������� ����������� ������������� ������
     *
     * @return object
     */
    public function create()
    {
        $map = $this->getMap();
        return new newsFolder($this, $map);
    }

    /**
     * ���������� children-�����
     *
     * @return array
     */
    public function getFolders($id, $level = 1)
    {
        $folders = array();
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
    public function searchByPath($path)
    {
        return $this->searchOneByField('path', $path);
    }

    public function delete($id)
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        $newsMapper = $toolkit->getMapper('news', 'news', $request->getSection());
        $newsFolderMapper = $toolkit->getMapper('news', 'newsFolder', $request->getSection());

        $folder = $newsFolderMapper->searchById($id);

        $news = $newsMapper->searchByFolder($folder->getId());
        foreach ($news as $val) {
            $newsMapper->delete($val->getId());
        }

        $folders = $newsFolderMapper->getFolders($folder->getId());
        foreach ($folders as $subfolder) {
            if ($id != $subfolder->getId()) {
                $newsFolderMapper->delete($subfolder->getId());
            }

        }

        $this->tree->removeNode($folder->getParent());
        parent::delete($id);
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
        $folders = array();
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
        $news = new newsMapper($this->section());

        if (!empty($this->pager)) {
            $news->setPager($this->pager);
        }

        $result = $news->searchByFolder($id);

        return $result;
    }

    public function convertArgsToId($args)
    {
        $newsFolder = $this->searchByPath(implode('/', $args));
        return (int)$newsFolder->getObjId();
    }

    public function createSubfolder(newsFolder $folder, newsFolder $targetFolder)
    {
        $id = $targetFolder->getParent();
        $node = $this->tree->insertNode($id);
        $parent = $node['id'];
        $folder->setParent($parent);
    }
}

?>