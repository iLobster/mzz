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
fileLoader::load('catalogue/catalogueFolder');

/**
 * catalogueFolderMapper: маппер
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueFolderMapper extends simpleMapperForTree
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'catalogue';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'catalogueFolder';

    protected $itemName = 'catalogue';

    public function __construct($section)
    {
        parent::__construct($section);

        $init = array ('mapper' => $this, 'joinField' => 'parent', 'treeTable' => $section . '_' . $this->className . '_tree');
        $this->tree = new dbTreeNS($init, 'name');
    }

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function searchByParentId($id)
    {
        return $this->searchOneByField('parent', $id);
    }

    public function searchByName($name)
    {
        if (empty($name)) {
            $name = 'root';
        }
        return $this->searchOneByField('name', $name);
    }

    public function create()
    {
        $map = $this->getMap();
        return new catalogueFolder($this, $map);
    }

    public function getFolders($id, $level = 1)
    {
        return $this->tree->getBranchContainingNode($id, $level);
    }

    public function searchByPath($path)
    {
        return $this->tree->getNodeByPath($path);
    }

    public function getFoldersByPath($path, $deep = 1)
    {
        // выбирается только нижележащий уровень
        return $this->tree->getBranchByPath($path, $deep);
    }

    public function getTree($level = 0)
    {
        return $this->tree->getTree($level);
    }

    public function getItems($id)
    {
        $catalogue = systemToolkit::getInstance()->getMapper($this->name, $this->itemName, $this->section());

        if (!empty($this->pager)) {
            $catalogue->setPager($this->pager);
        }

        $result = $catalogue->searchByFolder($id);

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

    public function getTreeParent($id)
    {
        return $this->tree->getParentNode($id);
    }

    public function move($folder, $destFolder)
    {
        return $this->tree->moveNode($folder, $destFolder);
    }

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return integer
     */
    public function convertArgsToId($args)
    {
        return 1;
    }
}

?>