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

        $init = array ('mapper' => $this, 'joinField' => 'parent', 'treeTable' => $section . '_' . $this->className . '_tree');
        $this->tree = new dbTreeNS($init, 'name');
    }

    /**
     * ����� newsFolder �� id
     *
     * @param integer $id
     * @return newsFolder
     */
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
        return $this->tree->getBranchContainingNode($id); //, $level);
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

    /**
     * �������� ����� ������ � ��������� �� ������ id
     * �� delete ������ ��� delete ������������ � tree ��� �������� ������
     *
     * @param string $id ������������� <b>���� ������</b> (parent) ���������� ��������
     * @return void
     */
    public function remove($id)
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        $newsMapper = $toolkit->getMapper('news', 'news', $request->getSection());
        $newsFolderMapper = $toolkit->getMapper('news', 'newsFolder', $request->getSection());

        // @toDo ��� �� �� ���
        foreach($this->tree->getBranch($id) as $folder) {
            $folderNews = $folder->getItems();
            foreach($folderNews as $news) {
                $newsMapper->delete($news->getId());
            }
        }

        $this->tree->removeNode($id);
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
        return $this->tree->getBranchByPath($path, $deep);

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
        $newsFolder = $this->searchByPath($args['name']);
        return (int)$newsFolder->getObjId();
    }

    // DEPRECATED ������������ $tree->insertNode()

    /*    public function createSubfolder(newsFolder $folder, newsFolder $targetFolder)
    {
    $id = $targetFolder->getParent();
    $node = $this->tree->insertNode($id);
    $parent = $node['id'];
    $folder->setParent($parent);
    }*/
}

?>