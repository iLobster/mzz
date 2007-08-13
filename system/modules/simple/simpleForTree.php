<?php
/**
 * $URL: http://svn.web/repository/mzz/system/modules/simple/simpleForTree.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: simpleForTree.php 996 2007-08-12 21:23:54Z zerkms $
 */

/**
 * simpleForTree: ������� �� ��� ������ � ������������ �����������
 *
 * @package system
 * @version 0.2
 */
class simpleForTree extends simple
{
    /**
     * ���� �� ���������� ����� �� ������
     *
     * @var arrayDataspace
     */
    protected $treeFields;

    /**
     * �����������.
     *
     * @param array $map ������, ���������� ���������� � �����
     */
    public function __construct($mapper, Array $map)
    {
        parent::__construct($mapper, $map);
        $this->treeFields = new arrayDataspace();
    }

    /**
     * ��������� ������, �� ������� ��������� �������.
     *
     * @return integer
     */
    public function getTreeLevel()
    {
        if (!$this->treeFields->exists('id')) {
            $this->mapper->loadTreeData($this);
        }
        return $this->treeFields->get('level');
    }

    /**
     * ��������� id ���� � ������
     *
     * @return integer
     */
    public function getTreeKey()
    {
        if (!$this->treeFields->exists('id')) {
            $this->mapper->loadTreeData($this);
        }
        return $this->treeFields->get('id');
    }

    /**
     * ��������� id ������
     *
     * @return integer
     */
    public function getTreeId()
    {
        if (!$this->treeFields->exists('tree_id')) {
            $this->mapper->loadTreeData($this);
        }
        return $this->treeFields->get('tree_id');
    }

    /**
     * ��������� ������ �������� ����
     *
     * @return simpleForTree
     */
    public function getTreeParent()
    {
        return $this->mapper->getTreeParent($this);
    }

    /**
     * ����� ��� �������������� ������ �� ������
     *
     * @param array $data
     */
    public function importTreeFields(Array $data)
    {
        $this->treeFields->import($data);
    }

    /**
     * ��������������� ������ �� ������
     *
     * @return array
     */
    public function exportTreeFields()
    {
        return $this->treeFields->export();
    }

    /**
     * ��������� ���� �� ����
     *
     * @param boolean $simple �������� � ����������� (��� ��������� ��������) ��� ������ �������
     * @return string
     */
    public function getPath($simple = true)
    {
        $path = $this->__call('getPath', array());

        if ($simple) {
            $rootName = substr($path, 0, strpos($path, '/'));

            if ($rootName && strpos($path, $rootName) === 0 && strlen($path) > strlen($rootName)) {
                $path = substr($path, strlen($rootName) + 1);
            }
        }

        return $path;
    }

    /**
     * ���������� �������, ����������� � ������ �����
     *
     * @return array
     */
    public function getItems()
    {
        if (!$this->fields->exists('items')) {
            $this->fields->set('items', $this->mapper->getItems($this->getId()));
        }
        return $this->fields->get('items');
    }

    /**
     * ���������� children-�����
     *
     * @return array
     */
    public function getFolders($level = 1)
    {
        if (!$this->fields->exists('folders')) {
            $folders = $this->mapper->getFolders($this, $level);
            array_shift($folders);
            $this->fields->set('folders', $folders);
        }
        return $this->fields->get('folders');
    }
}

?>