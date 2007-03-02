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

fileLoader::load('page/pageFolder');
fileLoader::load('simple/simpleMapperForTree');
fileLoader::load('db/dbTreeNS');

/**
 * pageFolderMapper: ������
 *
 * @package modules
 * @subpackage page
 * @version 0.1.3
 */

class pageFolderMapper extends simpleMapperForTree
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'page';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'pageFolder';

    protected $itemName = 'page';

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
     * ���������� �������� ������, ������� ����������� ������������� ������
     *
     * @return object
     */
    public function create()
    {
        $map = $this->getMap();
        return new pageFolder($this, $map);
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
     * ���������� �������, ����������� � ������ �����
     *
     * @return array
     */
    public function getItems($id)
    {
        $page = systemToolkit::getInstance()->getMapper('page', 'page', $this->section());

        if (!empty($this->pager)) {
            $page->setPager($this->pager);
        }

        $result = $page->searchByFolder($id);

        return $result;
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

    public function searchByParentId($id)
    {
        return $this->searchOneByField('parent', $id);
    }

    /**
     * ����� ������ �������� � ��������
     *
     * @param string $name
     * @return page|null
     */
    public function searchChild($name)
    {
        $toolkit = systemToolkit::getInstance();
        $pageMapper = $toolkit->getMapper('page', 'page');

        if (strpos($name, '/') === false) {
            $name = 'root/' . $name;
        }

        $folder = substr($name, 0, strrpos($name, '/'));
        $pagename = substr(strrchr($name, '/'), 1);

        $pageFolder = $this->searchByPath($folder);

        $criteria = new criteria();
        $criteria->add('name', $pagename)->add('folder_id', $pageFolder->getId());
        $page = $pageMapper->searchOneByCriteria($criteria);

        return $page;
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

    public function getTreeParent($id)
    {
        return $this->tree->getParentNode($id);
    }

    public function move($folder, $destFolder)
    {
        return $this->tree->moveNode($folder, $destFolder);
    }

    /**
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
     *
     * @return integer
     */
    public function convertArgsToId($args)
    {
        if (!isset($args['name'])) {
            $args['name'] = 'root';
        }

        $pageFolder = $this->searchByPath($args['name']);
        if ($pageFolder) {
            return (int)$pageFolder->getObjId();
        }

        throw new mzzDONotFoundException();
    }
}

?>