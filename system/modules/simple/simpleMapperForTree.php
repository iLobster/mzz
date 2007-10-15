<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('db/dbTreeNS');
fileLoader::load('simple/simpleForTree');

/**
 * simpleMapperForTree: ������ ��� ������ � ������������ �����������
 *
 * @package system
 * @version 0.2.1
 */

abstract class simpleMapperForTree extends simpleMapper
{
    /**
     * ������ ��� �������� ��������� ������ � ������ (�� ���������� �� � ������)
     *
     * @var array
     */
    protected $treeTmp = array();

    /**
     * ��������� ������ (��� �������, ��� ���� �� �������� ���������� ����������, ��� ���� ��� �������� ����, ��� ����)
     *
     * @var array
     */
    protected $treeParams = array();

    /**
     * �����������
     *
     * @param string $section ��� �������
     */
    public function __construct($section)
    {
        parent::__construct($section);
        $this->treeParams = array_merge(self::getTreeParams(), $this->getTreeParams());
        $this->tree = new dbTreeNS($this->treeParams, $this);
    }

    /**
     * ��������� id ������ (� ������ ���� � �������� �������� ��������� ����������� �������� ������������)
     *
     * @param integer $tree_id
     */
    public function setTree($tree_id)
    {
        $this->tree->setTree($tree_id);
    }

    /**
     * ��������� ���������� ������
     *
     * @return array
     */
    protected function getTreeParams()
    {
        return array('nameField' => 'name', 'pathField' => 'path', 'joinField' => 'parent', 'tableName' => $this->table . '_tree', 'treeIdField' => 'tree_id');
    }

    /**
     * ��������� ��������� �������� ������
     *
     * @return simpleForTree
     */
    public function getRoot()
    {
        $criteria = new criteria();
        $criteria->add('tree.lkey', 1);
        return $this->searchOneByCriteria($criteria);
    }

    /**
     * ����� ���� �� ����
     *
     * @param string $path
     * @return simpleForTree
     */
    public function searchByPath($path)
    {
        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }

        $root = $this->getRoot();
        $accessor = $this->map[$this->treeParams['nameField']]['accessor'];
        $rootName = $root->$accessor();

        if (strpos($path, $rootName) !== 0) {
            $path = $rootName . '/' . $path;
        }

        if (substr($path, -1) == '/') {
            $path = substr($path, 0, -1);
        }

        return $this->searchOneByField($this->treeParams['pathField'], $path);
    }

    /**
     * ����� ���� �� ��������
     *
     * @param criteria $criteria
     * @return simpleForTree
     */
    protected function searchByCriteria(criteria $criteria)
    {
        $this->tree->addSelect($criteria);
        $this->tree->addJoin($criteria);
        return parent::searchByCriteria($criteria);
    }

    /**
     * ��������� �����������
     *
     * @param simpleForTree $id ������� ����
     * @param integer $level ������� �������
     * @return array
     */
    public function getFolders(simpleForTree $id, $level = 1)
    {
        return $this->getBranch($id, $level);
    }

    /**
     * ��������� ����� ������, ������� � �������� ����
     *
     * @param simpleForTree $target ������� ���� ������
     * @param integer $level ����� ���������� �������
     * @return array ������ ��������� ���������
     */
    public function getBranch(simpleForTree $target, $level = 0)
    {
        $criteria = new criteria();
        $this->tree->addSelect($criteria);
        $this->tree->addJoin($criteria);
        $this->tree->getBranch($criteria, $target, $level);

        $stmt = parent::searchByCriteria($criteria);

        $result = array();

        while ($row = $stmt->fetch()) {
            $data = $this->fillArray($row);
            $result[$data[$this->tableKey]] = $this->createItemFromRow($data);
        }

        return $result;
    }

    /**
     * ��������� ���� ������� �������� ����
     *
     * @param simpleForTree $node
     * @return array
     */
    public function getParentBranch(simpleForTree $node)
    {
        $criteria = new criteria();
        $this->tree->addSelect($criteria);
        $this->tree->addJoin($criteria);
        $this->tree->getParentBranch($criteria, $node);

        $stmt = parent::searchByCriteria($criteria);

        $result = array();

        while ($row = $stmt->fetch()) {
            $data = $this->fillArray($row);
            $result[$data[$this->tableKey]] = $this->createItemFromRow($data);
        }

        return $result;
    }

    /**
     * ��������� ������ �������� ����
     *
     * @param simpleForTree $child
     * @return simpleForTree
     */
    public function getTreeParent(simpleForTree $child)
    {
        $criteria = new criteria();
        $this->tree->addSelect($criteria);
        $this->tree->addJoin($criteria);
        $this->tree->getParentNode($criteria, $child);

        $stmt = parent::searchByCriteria($criteria);

        if ($row = $stmt->fetch()) {

            $row = $this->fillArray($row);
            $parent = $this->createItemFromRow($row);

            return $parent;
        }

        return null;
    }

    /**
     * ���������� �������
     *
     * @param simpleForTree $object
     * @param simpleForTree $target ����, � ������� ����������� ������ (� ������ - ���� ���������� ��������)
     * @param user $user
     */
    public function save(simpleForTree $object, $target = null, $user = null)
    {
        // �������� ����������� ����
        $data = $object->export();

        $mutator = $this->map[$this->treeParams['joinField']]['mutator'];
        $accessor = $this->map[$this->treeParams['joinField']]['accessor'];

        // ���� ������ �������� - ���� ����, � ������� �� ����� ������
        if (!$object->getId()) {
            //$node = $this->tree->getNodeInfo($target);
            $id = $this->tree->insert($target);
            $object->$mutator($id);
        } else {
            // ����� �������� ������������ ����
            $target = $this->getTreeParent($object);
        }

        $result = parent::save($object, $user);

        // �������� ���������� �� ���� �� ������
        $node = $this->tree->getNodeInfo($object->$accessor());

        // ����������� ��� ����������
        $object->importTreeFields($node);

        // ���� ����, ���������� ������ ����, ���� �������� - ������������ ���� ����� ���� � ���� ��������� � ����
        if (isset($data[$this->treeParams['nameField']])) {
            // �������� ���� ������� ������� ����, ����������� 1 �������
            $branch = $this->getBranch($object, 1);

            $pathAccessor = $this->map[$this->treeParams['pathField']]['accessor'];
            $pathMutator = $this->map[$this->treeParams['pathField']]['mutator'];
            $nameAccessor = $this->map[$this->treeParams['nameField']]['accessor'];
            $nameMutator = $this->map[$this->treeParams['nameField']]['mutator'];

            // ������������ ���� �������� ����
            $baseName = ($object->getTreeLevel() > 1 ? $target->$pathAccessor(false) . '/' : '') . $object->$nameAccessor();
            $object->$pathMutator($baseName);
            // ��������� ������� ������
            $this->save($object);

            // ������� ������� ������ �� �������
            array_shift($branch);
            // ������� ���� �������
            foreach ($branch as $key => $val) {
                // ���������� �������� ������� ����������� ����� � ��� ���� �������
                $val->$nameMutator($val->$nameAccessor());
                $this->save($val);
            }
        }
    }

    /**
     * ����������� ����
     *
     * @param simpleForTree $node ����������� ����
     * @param simpleForTree $target ����, � ������� ���������
     * @return boolean
     */
    public function move(simpleForTree $node, simpleForTree $target)
    {
        $result = $this->tree->move($node, $target);

        if ($result) {
            $nameAccessor = $this->map[$this->treeParams['nameField']]['accessor'];
            $nameMutator = $this->map[$this->treeParams['nameField']]['mutator'];
            $node->$nameMutator($node->$nameAccessor());

            $this->save($node);
        }

        return $result;
    }

    /**
     * �������� ����
     *
     * @param simpleForTree $id
     */
    public function delete(simpleForTree $id)
    {
        // �������� ���� ������� ����
        $branch = $this->getBranch($id);

        $mapper = systemToolkit::getInstance()->getMapper($this->name, $this->itemName);

        foreach ($branch as $do) {
            // �������� ���� ��������, ������������ � ���� ������
            $items = (array) $do->getItems();
            foreach ($items as $item) {
                // ������� ��
                $mapper->delete($item);
            }
            parent::delete($do);
        }
        $this->tree->delete($id);
    }

    /**
     * ��������� ������, �������� ������� ���� � ���� ��� �����������
     *
     * @param simpleForTree $folder
     * @return array
     */
    public function getTreeExceptNode(simpleForTree $folder)
    {
        $tree = $this->searchAll();

        $subfolders = $this->getBranch($folder);

        foreach (array_keys($subfolders) as $val) {
            unset($tree[$val]);
        }

        return $tree;
    }

    /**
     * ��������� ������ � ������������ �������� ���� ���������� ������ �����������, �������� � ���� ������ ������� ������
     *
     * @param simpleForTree $id ������� ����
     * @return array
     */
    public function getTreeForMenu(simpleForTree $node)
    {
        $node = $this->tree->getNodeInfo($node);

        $criterion = new criterion('tree2.lkey', 'tree.lkey', criteria::GREATER, true);
        $criterion->addAnd(new criterion('tree2.rkey', 'tree.rkey', criteria::LESS, true));
        $criterion->addAnd(new criterion('tree2.level', new sqlOperator('+', array('tree.level', 1)), criteria::LESS_EQUAL));

        $criteria = new criteria();
        $criteria->clearSelectFields()->addSelectField('data2.*');
        $this->tree->addSelect($criteria, 'tree2');
        $this->tree->addJoin($criteria);
        $criteria->addJoin($this->treeParams['tableName'], $criterion, 'tree2', criteria::JOIN_INNER);
        $criteria->addJoin($this->table, new criterion('data2.' . $this->treeParams['joinField'], 'tree2.id', criteria::EQUAL, true), 'data2', criteria::JOIN_INNER);
        $criteria->add('tree.lkey', $node['lkey'], criteria::LESS_EQUAL);
        $criteria->add('tree.rkey', $node['rkey'], criteria::GREATER_EQUAL);
        $criteria->setOrderByFieldAsc('tree2.lkey');
        $criteria->addGroupBy('tree2.id');

        $stmt = parent::searchByCriteria($criteria);

        $result = array();
        while ($row = $stmt->fetch()) {
            $this->setTreeTmp($row, 'tree2');
            $result[$row[$this->tableKey]] = $this->createItemFromRow($row);
        }

        return $result;
    }

    /**
     * �������� ������ �� ���� � ������
     *
     * @param simpleForTree $object
     */
    public function loadTreeData(simpleForTree $object)
    {
        $accessor = $this->map[$this->treeParams['joinField']]['accessor'];
        $id = $object->$accessor();
        $node = $this->tree->getNodeInfo($id);
        $object->importTreeFields($node);
    }

    /**
     * ��������� ������� �� ������� �������� ������
     *
     * @param array $row ������ � �������
     * @return object
     */
    public function createItemFromRow($row)
    {
        $object = $this->create();
        $object->import($row);
        $object->importTreeFields($this->treeTmp);
        $this->treeTmp = array();
        return $object;
    }

    /**
     * ����� �������� ��������� ������� � �����, ������� ��� ���������� ������� �������
     *
     * @param array $array ������� ������
     * @param string $name ��� ����������� ���������� �������
     * @return array
     */
    public function fillArray(&$array, $name = null)
    {
        $this->setTreeTmp($array);
        return parent::fillArray($array, $name);
    }

    /**
     * ��������� �� ��������� ������ ������ �� ������ � ������� ����
     *
     * @param array $array
     * @param string $name
     */
    protected function setTreeTmp(&$array, $name = 'tree')
    {
        $this->treeTmp = parent::fillArray($array, $name);
    }
}

?>