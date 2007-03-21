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
 * @version 0.2.3
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

        $this->init = array ('mapper' => $this, 'joinField' => 'parent', 'treeTable' => $section . '_' . $this->className . '_tree');
        $this->tree = new dbTreeNS($this->init, 'name');
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

    public function convertArgsToId($args)
    {
        if (isset($args['name']) && $newsFolder = $this->searchByPath($args['name'])) {
            return (int)$newsFolder->getObjId();
        }

        throw new mzzDONotFoundException();
    }
}

?>