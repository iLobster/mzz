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
 * catalogueFolderMapper: ������
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1.1
 */

class catalogueFolderMapper extends simpleMapperForTree
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'catalogue';

    /**
     * ��� ������ DataObject
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

    public function getFoldersByPath($path, $deep = 1)
    {
        // ���������� ������ ����������� �������
        return $this->tree->getBranchByPath($path, $deep);
    }

    /**
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
     *
     * @return integer
     */
    public function convertArgsToId($args)
    {
        return 1;
    }
}

?>