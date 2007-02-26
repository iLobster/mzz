<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('db/dbTreeNS');
fileLoader::load('news/newsFolder');
fileLoader::load('simple/simpleMapperForTree');

/**
 * newsFolderMapper: ������ ��� ����� ��������
 *
 * @package modules
 * @subpackage news
 * @version 0.2.2
 */

class newsFolderMapper extends simpleMapperForTree
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

    protected $itemName = 'news';

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

    public function searchByParentId($id)
    {
        return $this->searchOneByField('parent', $id);
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
        return $this->tree->getBranchContainingNode($id, $level);
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
        return $this->tree->getNodeByPath($path);
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
        $news = systemToolkit::getInstance()->getMapper($this->name, $this->itemName, $this->section());

        if (!empty($this->pager)) {
            $news->setPager($this->pager);
        }

        $result = $news->searchByFolder($id);

        return $result;
    }

    public function getTreeExceptNode($folder)
    {
        $tree = $this->tree->getTree();

        $subfolders = $this->tree->getBranch($folder);

        foreach (array_keys($subfolders) as $val) {
            unset($tree[$val]);
        }

        return $tree;
    }

    /**
     * �������� ��������
     *
     * @param  newsFolder     $folder          ����� ��� ����������
     * @param  newsFolder     $targetFolder    ����� ����������, � ������� ���������
     * @return newsFolder
     */
    /*public function createSubfolder(newsFolder $folder, newsFolder $targetFolder)
    {
        $idParent = $targetFolder->getParent();
        return $this->tree->insertNode($idParent, $folder);
    }*/

    public function getTreeParent($id)
    {
        return $this->tree->getParentNode($id);
    }

    public function move($folder, $destFolder)
    {
        return $this->tree->moveNode($folder, $destFolder);
    }

    public function convertArgsToId($args)
    {
        $newsFolder = $this->searchByPath($args['name']);
        if ($newsFolder) {
            return (int)$newsFolder->getObjId();
        }

        throw new mzzDONotFoundException();
    }
}

?>