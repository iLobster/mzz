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
 * @package system
 * @subpackage db
 * @version $Id$
 */

/**
 * dbTreeNS: ������ � ��������� Nested Sets
 *
 * @package system
 * @subpackage db
 * @version 0.9.5
 */

fileLoader::load('db/sqlFunction');
fileLoader::load('db/simpleSelect');

//@toDo searchByCriteria

class dbTreeNS
{
    /**
     * DB
     *
     * @var object
     */
    protected $db;

    /**
     * ��� ������� ���������� ������
     *
     * @var string
     */
    private $table;

    /**
     * ��� ������� ���������� ������
     *
     * @var string
     */
    private $dataTable;

    /**
     * ����������� ����
     *
     * @var string
     */
    private $innerField;

    /**
     * ��� ���� ����������� ���� ������� ������
     *
     * @var string
     */
    private $dataID;

    /**
     * ��� ���� ����������� ���� ������� � �������
     *
     * @var string
     */
    private $treeID;

    /**
     * ������������� ���������
     *
     * @var integer
     */
    private $treeFieldID;

    /**
     * ���� true, �� ������������ ����� ������������� ���� ��� ������� ����� �� ��� ������
     * ��������� ������ ����������� ���������� �������� �� 1
     *
     * @var bool
     */
    private $correctPathMode;

    /**
     * ������ ��� ������ � �������� ������
     *
     * @var simpleMapper
     */
    private $mapper;

    /**
     * ��� ��������� � ������, ���� ����������� ���������� ������� simple
     *
     * @var string
     */
    private $accessorDataID;

    /**
     * �����������
     *
     * @param array  $init        ������ � �������� � ����������� ����� array( data => mapper,  tree => array(table,id))
     * @param array  $innerField  ��� ���� ������� ����� ������������� ��� ���������� ����, ������ ������
     */
    public function __construct($init, $innerField = 'name')
    {
        $this->db = DB::factory();
        $this->setInnerField($innerField);

        // ������������� ������
        if (!empty($init['mapper']) && $init['mapper'] instanceof simpleMapper) {
            $this->setMapper($init['mapper']);

        } else {
            throw new mzzInvalidParameterException('���������� $init[mapper] �� �������� �������� ', $init['mapper']);

        }

        if (isset($init['treeField'])) {
            $this->treeField = $init['treeField'];
        }

        // ������ � ������� � �������
        $this->table = $init['treeTable']; // as tree

        // @toDo ���� ������ ���������� ���� ������ ���� � �������� ����� ������������
        $this->treeID = 'id';

        // ������ � ����������� ���� � ������� � ������� (������ <-> ������)
        // ���� ���� �� ������� � init ������� ���������� ���� id
        $this->dataID = isset($init['joinField']) ? $init['joinField'] : 'id';
    }

    /**
     * ��������� ������ �������
     *
     * @return string
     */
    public function setMapper(simpleMapper $mapper)
    {
        $this->mapper = $mapper;

        // ����� ������ � ������� � �������
        $this->dataTable = $this->mapper->getTable(); //as data
    }

    /**
     * ��������� ������������� �������
     *
     * @return simpleMapper
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * ��������� ����� ���� �� �������� ���� ���������� ������� ������ � ������� ��������� ������
     *
     * @return string
     */
    public function setInnerField($tableField)
    {
        if (!(is_string($tableField) && strlen($tableField))) {
            throw new mzzInvalidParameterException('���������� $tableField �� �������� ������� � �� ����� ������� ������ ���� ������� ', $tableField);
        }
        $this->innerField = $tableField;
    }

    /**
     * ��������� �������������� ���������
     *
     * @param  integer     $id    �������������(�������� ���. ����) �� �������� ���������� ������
     * @return string
     * @toDo ��� ������ ��������� ������?
     */
    public function setTree($id)
    {
        $this->treeFieldID = (int)$id;
    }

    /**
     * ��������� ����� ���� �� �������� ���� ���������� ������� ������ � ������� ��������� ������
     *
     * @return string
     */
    public function getInnerField()
    {
        return $this->innerField;
    }

    /**
     * ����� ������ ������� ����� �� ������ ����
     *
     * @param  bool     $mode          ����� ������, � ���������� ���� ��� ���
     */
    public function setCorrectPathMode($mode = false)
    {
        $this->correctPathMode = $mode;
    }

    /**
     * ���������� ���� �� ������ id ������
     *
     * @param  int     $id  ������������� ���� � ��������� ������
     * @return string
     */
    public function createPathFromTreeByID($id)
    {
        $parentBranch = $this->getParentBranch($id, 9999999);

        if (!is_array($parentBranch)) {
            return null;
        }

        $path = '';

        foreach ($parentBranch as $node) {
            $map = $node->getMap();
            $fieldAccessor = $map[$this->getInnerField()]['accessor'];
            $path .= $node->$fieldAccessor() . '/';
        }
        return substr($path, 0, -1);
    }

    /**
     * ���������� ���� path � ������� ������
     *
     * @param  int     $id  ������������� ���� � ��������� ������
     * @return string
     */
    public function updatePath($dataID)
    {
        $dataID = (int)$dataID;
        $path = $this->createPathFromTreeByID($dataID);
        $this->db->query('UPDATE `' . $this->dataTable . '` SET `path` = "'  .$path . '"  WHERE `' . $this->dataID . '` = ' . $dataID);

        return $path;
    }

    /**
     * �������� ������� �������� �� ����� �������
     *
     * @param array $stmt   ����������� ���������
     * @return array of simple object
     */
    protected function createBranchFromRow($stmt)
    {
        $branch = array();
        while ($row = $stmt->fetch()) {
            $branch[$row[$this->dataID]] = $this->createItemFromRow($row);
        }

        if (!empty($branch)) {
            return $branch;
        } else {
            return null;
        }
    }

    /**
     * �������� ������� �� ����� �������
     *
     * @param array $row ������ � ������� � ����� � �� ���������
     * @return object simple
     */
    protected function createItemFromRow($row)
    {
        $do = $this->mapper->createItemFromRow($row);
        $do->setLevel($row['level']);
        $do->setRightKey($row['rkey']);
        $do->setLeftKey($row['lkey']);

        return $do;
    }

    /**
     * ������� ����� �� ��������
     *
     * @param  criteria $criteria �������� ��� ������
     * @return array of simpleForTree objects
     */
    public function searchByCriteria(criteria $criteria)
    {
        $criteria->addJoin($this->table, new criterion($this->dataTable . '.' . $this->dataID, $this->table . '.' . $this->treeID, criteria::EQUAL, true));

        if ($this->isMultipleTree()) {
            $criteria->add(new criterion($this->table . '.' . $this->treeField, $this->treeFieldID));
        }

        $select = new simpleSelect($criteria);
        $stmt = $this->db->query($select->toString());

        return $this->createBranchFromRow($stmt);
    }

    private function getBasisCriteria()
    {
        if (!isset($this->basisCriteria)) {
            $this->basisCriteria= new criteria();

            // ������ ����� �� ������� �� ���������� ������
            $this->basisCriteria->setTable($this->table, 'tree');

            //������� ������� � ������� ��� `data`
            $this->basisCriteria->addJoin($this->dataTable, new criterion('tree.' . $this->treeID, 'data.' . $this->dataID, criteria::EQUAL, true), 'data', criteria::JOIN_INNER);
        }

        // ���� �������� ���������, �� ��������� ������� ��� �� ����������
        if ($this->isMultipleTree()) {
            $this->basisCriteria->add(new criterion('tree.' .$this->treeField, $this->treeFieldID, criteria::EQUAL));
        } else {
            //@toDo ��������, ��� ���������. ��� ��� ���� ����� � ����� ������� ���� ��������� WHERE
            //�����??
            $this->basisCriteria->add(new criterion('id', 'tree.id', criteria::EQUAL, true));
        }

        return clone $this->basisCriteria;
    }

    private function getBasisQuery()
    {
        $select = new simpleSelect($this->getBasisCriteria());
        return $select->toString();
    }

    /**
     * ��������, �������� � ����������� ��������� ��� ���.
     *
     * @return bool
     */
    private function isMultipleTree()
    {
        return isset($this->treeField) && isset($this->treeFieldID) && $this->treeFieldID > 0;
    }

    /**
     * ������� ������ �� ������ ������
     *
     * @param  int     $level   ������� ������� ������, �� ��������� ��� ������
     * @return array
     */
    public function getTree($level = 0)
    {
        $criteria = $this->getBasisCriteria();

        // ��������� �� ������ �����
        $criteria->setOrderByFieldAsc('tree.lkey');

        // ���� ������ ������� �������, ��������� �������
        if ($level > 0) {
            $criteria->add(new criterion('tree.level', array(1, $level), criteria::BETWEEN));
        }

        $select = new simpleSelect($criteria);
        $stmt = $this->db->query($select->toString());

        return $this->createBranchFromRow($stmt);
    }

    /**
     * ������� ���������� � ����
     *
     * @param  int     $id       ������������� ����
     * @return array
     */
    public function getNodeInfo($id)
    {
        if (is_array($id)) {
            return $id;
        }

        if ($id instanceof simple) {
            //if (empty($this->accessorDataID)) {
            $map = $id->getMap();
            $acsr = $map[$this->dataID]['accessor'];
            $this->accessorDataID = $id->$acsr();
            //}
            $id = $this->accessorDataID;
        }

        $query = 'SELECT * FROM `' . $this->table . '` `tree` WHERE `tree`.`id` = ' . $id.
        ($this->isMultipleTree() ? ' AND `tree`.`' . $this->treeField . '`= ' . $this->treeFieldID : '');

        $stmt = $this->db->query($query);

        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }

    /**
     * ���������� ������� �� ������� �����
     *
     * @param  bool     $withRootNode ������� ������� � ������ �����
     * @return array
     */
    protected function getBranchStmt($withRootNode = true)
    {
        if ($withRootNode) {
            $less = '<=';
            $more = '>=';
        } else {
            $less = '<';
            $more = '>';
        }

        $stmt = $this->db->prepare($this->getBasisQuery() .
        ' AND `lkey` ' . $more . ' :lkey AND `rkey` ' . $less . ' :rkey' .
        ' AND (`tree`.`level` BETWEEN :high_level AND :level)' .
        ' ORDER BY `tree`.`lkey`');

        return $stmt;
    }

    /**
     * ������� ����� ������� �� ��������� ����
     *
     * @param  int     $id            ������������� ����
     * @param  int     $level         ������� ������� �������
     * @return array|false
     */
    public function getBranch($id, $level = 999999999)
    {
        $rootBranch = $this->getNodeInfo($id);
        if (!$rootBranch) {
            return null;
        }

        $stmt = $this->getBranchStmt();
        $level = $rootBranch['level'] + $level;
        $stmt->bindParam(':lkey', $rootBranch['lkey'], PDO::PARAM_INT);
        $stmt->bindParam(':rkey', $rootBranch['rkey'], PDO::PARAM_INT);
        $stmt->bindParam(':high_level', $rootBranch['level'], PDO::PARAM_INT);
        $stmt->bindParam(':level', $level, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $this->createBranchFromRow($stmt);
        }
        return false;
    }

    /**
     * ������� ������������ ����� ������� �� ��������� ����
     *
     * @param  int     $id           ������������� ����
     * @param  int     $level        ������� ������� �������
     * @return array
     */
    public function getParentBranch($id, $level = 1)
    {
        $lowerChild = $this->getNodeInfo($id);
        if (!$lowerChild) {
            return null;
        }
        $highLevel = $lowerChild['level'] - $level;



        $stmt = $this->db->prepare( $this->getBasisQuery() .
        ' AND `lkey` <= :lkey AND `rkey` >= :rkey' .
        ' AND (`level` BETWEEN :level AND :child_level ) ' .
        ($this->isMultipleTree() ? 'AND `tree`.`' . $this->treeField . '` = :treeFieldID ' : '') .
        '  ORDER BY `lkey`');

        if ($this->isMultipleTree()) {
            $stmt->bindParam(':treeFieldID', $this->treeFieldID, PDO::PARAM_INT);
        }

        $stmt->bindParam(':lkey', $lowerChild['lkey'], PDO::PARAM_INT);
        $stmt->bindParam(':rkey', $lowerChild['rkey'], PDO::PARAM_INT);
        $stmt->bindParam(':child_level', $lowerChild['level'], PDO::PARAM_INT);
        $stmt->bindParam(':level', $highLevel, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $this->createBranchFromRow($stmt);
        }
        return false;
    }

    /**
     * ������� ����� � ������� ��������� �������� ����
     *
     * @param  int     $id           ������������� ����
     * @param  int     $level        ����� �������, ���������� ����� �������� ����
     * @return array
     */
    public function getBranchContainingNode($id, $level = 999999999)
    {
        $node = $this->getNodeInfo($id);
        if (!$node) {
            return null;
        }

        $stmt = $this->db->prepare($this->getBasisQuery() .
        ' AND `tree`.`rkey` >:lkey ' .
        ($this->isMultipleTree() ? 'AND `tree`.`' . $this->treeField . '` = :treeFieldID ' : '') .
        ' AND `tree`.`lkey` <:rkey AND `tree`.`level` <= :level ORDER BY `tree`.`lkey`');

        if ($this->isMultipleTree()) {
            $stmt->bindParam(':treeFieldID', $this->treeFieldID, PDO::PARAM_INT);
        }

        $level += $node['level'];
        $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
        $stmt->bindParam(':rkey', $node['rkey'], PDO::PARAM_INT);
        $stmt->bindParam(':level', $level, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $this->createBranchFromRow($stmt);
        }
        return false;
    }

    private function getRootName()
    {
        $tree = $this->getTree(1);
        $root = array_pop($tree);
        $map = $root->getMap();
        $accessor = $map[$this->getInnerField()]['accessor'];
        return $root->$accessor();
    }

    public function getNodeByPath($path)
    {
        $node = $this->getLongestNodeByPath($path);

        $stmt = $this->db->prepare($qry = $this->getBasisQuery() .
        ' AND `lkey` = :lkey');

        $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            $result = $this->createBranchFromRow($stmt);
            if (is_array($result) && sizeof($result)) {
                return current($result);
            }
        }
        return null;
    }

    /**
     * ������� �����(����������� �����) �� ������ ���� �� �������� ���� �����
     *
     * @param  string     $path          ����
     * @param  string     $deep          ������� �������
     * @return array|false array with nodes or false
     */
    public function getBranchByPath($path, $deep = 1)
    {
        $lastNode = $this->getLongestNodeByPath($path);

        // ������� ��� ��������� ����
        $stmt = $this->getBranchStmt(false);

        $stmt->bindParam(':lkey', $lastNode['lkey'], PDO::PARAM_INT);
        $stmt->bindParam(':rkey', $lastNode['rkey'], PDO::PARAM_INT);
        $stmt->bindParam(':high_level', $lastNode['level'], PDO::PARAM_INT);
        $stmt->bindValue(':level', $lastNode['level'] + $deep, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $this->createBranchFromRow($stmt);
        }
        return false;
    }

    private function getLongestNodeByPath($path)
    {
        // ����������� ����
        $path = preg_replace('#/+#', '/', $path);
        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }

        $rootName = $this->getRootName();

        if (strpos($path, $rootName) !== 0) {
            $path = $rootName . '/' . $path;
        }

        if (substr($path, -1) == '/') {
            $path = substr($path, 0, -1);
        }

        if ($this->correctPathMode) {
            // ������� ����� ���� �������������� � �������
            $rewritedPath = $this->getPathVariants($path);

        } else {
            // ������� �������� �� ������������ ����, ������� ������ �����
            /*echo '<br><pre>'; var_dump($path); echo '<br></pre>';
            $pathParts = explode('/', trim($path));
            foreach ($pathParts as $key => $part) {
                if (strlen($part) == 0 ) {
                    unset($pathParts[$key]);
                }
            }
            echo '<br><pre>'; var_dump(implode('/', $pathParts)); echo '<br></pre>';echo '<br><br>';*/
            $rewritedPath[] = $path;
        }

        // �������� ��� ������������ ����
        $query = '';

        foreach ($rewritedPath as $pathVariant) {
            if (strlen($pathVariant) == 0) {
                continue;
            }
            $query .= $this->getBasisQuery() . " AND `data`.`path` = '" . $pathVariant . "' UNION ";
        }

        $query = substr($query, 0, -6) ;

        $stmt = $this->db->query($query);

        $existNodes = $stmt->fetchAll();

        // ����� ����� ������� ������������ ����
        return array_pop($existNodes);
    }

    /**
     * ������� ���������� � ������������ ����
     *
     * @param  int  $id  ������������� ����
     * @return array|null
     */
    public function getParentNode($id)
    {
        $node = $this->getNodeInfo($id);
        if (!$node) {
            return null;
        }

        $query = $this->getBasisQuery() .
        ' AND `tree`.`lkey` <= ' . $node['lkey'] .
        ' AND `tree`.`rkey` >= ' . $node['rkey'] .
        ' AND `tree`.`level` = ' . ($node['level'] - 1).
        ' ORDER BY `tree`.`lkey`';

        $row = $this->db->getRow($query);

        if ($row) {
            return $this->createItemFromRow($row);
        } else {
            return null;
        }
    }

    /**
     * ������� ���� ���� ���������, ���� ����� ������� ������ ������
     *
     * @param  integer $id ������������� ������������� ����, ��� ������� ���������
     * @param  simple object $newNode ������ ��� ����������� � ������� ������
     * @return simple object � ������������ ������ � ����� � ������
     */
    public function insertNode($id, simple $newNode)
    {
        if ($id == 0) {
            return $this->insertRootNode($newNode);
        }

        if (!$parentNode = $this->getNodeInfo($id)) {
            return false;
        }

        $query = 'UPDATE ' . $this->table.
        ' SET `rkey` = `rkey` + 2, `lkey` = IF(`lkey` > ' . (int)$parentNode['rkey'] . ', `lkey` + 2, `lkey`)' .
        ' WHERE `rkey` >= ' . (int)$parentNode['rkey'] .
        ($this->isMultipleTree() ? ' AND ' . $this->treeField . ' = ' . (int)$this->treeFieldID : ' ');

        $this->db->exec($query);

        $query = 'INSERT INTO `' . $this->table . '` SET `lkey` = ' . $parentNode['rkey'] .
        ', `rkey` = ' . ($parentNode['rkey'] + 1) .
        ', `level` = ' . ($parentNode['level'] + 1).
        ($this->isMultipleTree() ? ', `' . $this->treeField . '` = ' . $this->treeFieldID : ' ');
        $this->db->exec($query);

        $map = $newNode->getMap();
        if ($this->isMultipleTree()) {
            $mtr = $map[$this->treeField]['mutator'];
            $newNode->$mtr($this->treeFieldID);
        }

        $acsr = $map[$this->dataID]['accessor'];
        if ($newNode->$acsr() != ($lastID = $this->db->lastInsertId())) {
            $mtr = $map[$this->dataID]['mutator'];
            $newNode->$mtr($lastID);
        }

        $this->mapper->save($newNode);

        $newNode->setLevel($parentNode['level'] + 1);
        $newNode->setRightKey($parentNode['rkey'] + 1);
        $newNode->setLeftKey((int)$parentNode['rkey']);

        // ���������� ����� � ������� ������ � � �������
        $newNode->import(array('path' => $this->updatePath($newNode->$acsr())));
        return $newNode;
    }


    /**
     * ������� ��������� ����
     *
     * @return array
     */
    public function insertRootNode(simple $newRootNode)
    {
        $maxRightKey = $this->getMaxRightKey();
        $this->db->query('UPDATE `' . $this->table . '` SET `rkey` = `rkey` + 1, `lkey` = `lkey` + 1, `level` = `level` + 1 ' .
        ($this->isMultipleTree() ? 'WHERE `' . $this->treeField . '` = ' . $this->treeFieldID : ' '));


        $stmt = $this->db->prepare('INSERT INTO `' .$this->table . '` SET `lkey` = 1, `rkey` = :new_max_right_key, `level` = 1' .
        ($this->isMultipleTree() ? ', `' . $this->treeField . '` = ' . $this->treeFieldID : ' '));

        $stmt->bindValue(':new_max_right_key', $maxRightKey + 2, PDO::PARAM_INT);
        $stmt->execute();

        $map = $newRootNode->getMap();
        if ($this->isMultipleTree()) {
            $mtr = $map[$this->treeField]['mutator'];
            $newRootNode->$mtr($this->treeFieldID);
        }

        $acsr = $map[$this->dataID]['accessor'];
        if ($newRootNode->$acsr() != ($lastID = $this->db->lastInsertId())) {
            $mtr = $map[$this->dataID]['mutator'];
            $newRootNode->$mtr($lastID);
        }


        $this->mapper->save($newRootNode);

        $newRootNode->setLevel(1);
        $newRootNode->setRightKey($maxRightKey + 2);
        $newRootNode->setLeftKey(1);

        // ���������� ����� � ������� ������ � � �������
        $newRootNode->import(array('path' => $this->updatePath($newRootNode->$acsr())));

        // ���������� ���� ��������� � ����
        $this->db->exec('UPDATE ' . $this->dataTable .
        ' SET `path` = CONCAT_WS("/", "' . $newRootNode->getPath(). '", `path`) WHERE ' .
        '`' .$this->dataID . '`<>' . $newRootNode->$acsr() .
        ($this->isMultipleTree() ? ' AND `' . $this->treeField . '` = ' . $this->treeFieldID : ' '));

        return $newRootNode;
    }

    /**
     * �������� ���� ������ � ���������
     *
     * @param  int     $id           ������������� ���������� ����
     * @return bool
     */
    public function removeNode($id)
    {
        $node = $this->getNodeInfo($id);

        if ($node['lkey'] == 1) {
            return false;
        }

        //�������� ������ �� ������� ������
        $deletedBranch = $this->getBranch($id);
        if (count($deletedBranch)) {
            foreach ($deletedBranch as $currentNode) {
                $this->mapper->delete($currentNode->getId());
            }
        }

        // �������� ������� �� ������

        $query = 'DELETE `tree` FROM `' . $this->table . '` `tree` WHERE ' .
        ' `tree`.`lkey` >= ' . $node['lkey'] . ' AND `tree`.`rkey` <= ' . $node['rkey'] .
        ($this->isMultipleTree() ? ' AND `tree`.`' . $this->treeField . '` = ' . $this->treeFieldID : ' ');
        $this->db->exec($query);

        // ���������� ������
        $v = $node['rkey'] - $node['lkey'] + 1;
        $query = 'UPDATE `' .$this->table . '`' .
        ' SET `lkey` = IF(`lkey` > ' . (int)$node['lkey'] . ', `lkey` - ' . $v . ', `lkey`), `rkey` = `rkey` - ' . $v .
        ' WHERE `rkey` >= ' . (int)$node['rkey'] .
        ($this->isMultipleTree() ? ' AND `' . $this->treeField . '` = ' . $this->treeFieldID : ' ');

        return $this->db->exec($query);
    }

    /**
     * ������ ���� �������
     *
     * @param  int     $id1           ������������� ������� ������������� ����
     * @param  int     $id2           ������������� ������� ������������� ����
     * @return bool
     */
    public function swapNode($id1, $id2)
    {
        $node1 = $this->getNodeInfo($id1);
        $node2 = $this->getNodeInfo($id2);

        if (!$node1 || !$node2 || $node1 == $node2) {
            return false;
        }

        $stmt = $this->db->prepare('UPDATE `' .$this->table . '` SET `lkey` = :lkey, `rkey` = :rkey, ' .
        '`level` = :level WHERE `id` = :id' .
        ($this->isMultipleTree() ? ' AND `' . $this->treeField . '` = ' . $this->treeFieldID : ' ') );

        foreach (array($id1 => $node2, $id2 => $node1) as $id => $node) {
            $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
            $stmt->bindParam(':rkey', $node['rkey'], PDO::PARAM_INT);
            $stmt->bindParam(':level',$node['level'],PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        return !(bool)$stmt->errorCode();
    }

    /**
     * ����������� ���� ������ � ���������
     *
     * @param  int     $id           ������������� ������������� ����
     * @param  int     $parentId     ������������� ������ ������������� ����
     * @return bool
     */
    public function moveNode($id, $parentId)
    {
        $node = $this->getNodeInfo($id);
        $parentNode = $this->getNodeInfo($parentId);

        if ($id == $parentId || (!$node || !$parentNode)) {
            return false;
        }

        if ($parentNode['lkey'] >= $node['lkey'] && $parentNode['lkey'] <= $node['rkey']) {
            return false;
        }

        // @todo: ���� ����������� ������������� ������� ���� �� level 1, � ����� ������
        //$level_up = ($notRoot = $parentNode['level'] != 1 ) ? $parentNode['level'] : 0;
        $level_up = $parentNode['level'];
        $notRoot = true;

        $query = ($notRoot) ?
        "SELECT (`rkey` - 1) AS `rkey` FROM `" . $this->table . "` WHERE `id` = " . $parentNode['id'] :
        "SELECT MAX(`rkey`) as `rkey` FROM `" . $this->table . "` WHERE 1 ";
        $query .= $this->isMultipleTree() ? ' AND `' . $this->treeField . '` = ' . $this->treeFieldID : ' ' ;

        if ($row = $this->db->getRow($query)) {
            $rkey = $row['rkey'];
            $right_key_near = $rkey;
            $skew_level = $level_up - $node['level'] + 1;
            $skew_tree = $node['rkey'] - $node['lkey'] + 1;

            $query = 'SELECT `id` FROM `' . $this->table . '` WHERE `lkey` >= :lkey AND `rkey` <= :rkey' .
            ($this->isMultipleTree() ? ' AND `' . $this->treeField . '` = ' . $this->treeFieldID : ' ' );

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
            $stmt->bindParam(':rkey', $node['rkey'], PDO::PARAM_INT);
            $stmt->execute();

            $id_edit = '';
            while ($row = $stmt->fetch()) {
                $id_edit .= ($id_edit != '') ? ', ' : '';
                $id_edit .= $row['id'];
            }
            if ( $node['rkey'] > $right_key_near ) {
                $skew_edit = $right_key_near - $node['lkey'] + 1;

                $query = 'UPDATE `' . $this->table . '` SET `rkey` = `rkey` + :skew_tree WHERE `rkey` < :lkey AND `rkey` > :right_key_near';
                $query .= $this->isMultipleTree() ? ' AND `' . $this->treeField . '` = ' . $this->treeFieldID : ' ' ;

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':skew_tree', $skew_tree, PDO::PARAM_INT);
                $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
                $stmt->bindParam(':right_key_near', $right_key_near, PDO::PARAM_INT);
                $stmt->execute();

                $query = 'UPDATE `' . $this->table . '` SET `lkey` = `lkey` + :skew_tree WHERE `lkey` < :lkey AND `lkey` > :right_key_near';
                $query .= $this->isMultipleTree() ? ' AND `' . $this->treeField . '` = ' . $this->treeFieldID : ' ' ;

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':skew_tree', $skew_tree, PDO::PARAM_INT);
                $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
                $stmt->bindParam(':right_key_near', $right_key_near, PDO::PARAM_INT);
                $stmt->execute();

                $query = 'UPDATE `' . $this->table . '` SET `lkey` = `lkey` + :lskew_edit , `rkey` = `rkey` + :rskew_edit , `level` = `level` + :skew_level WHERE `id` IN (' . $id_edit . ')';
                $query .= $this->isMultipleTree() ? ' AND `' . $this->treeField . '` = ' . $this->treeFieldID : ' ' ;

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':lskew_edit', $skew_edit, PDO::PARAM_INT);
                $stmt->bindParam(':rskew_edit', $skew_edit, PDO::PARAM_INT);
                $stmt->bindParam(':skew_level', $skew_level, PDO::PARAM_INT);
                $stmt->execute();
                /*
                @todo �������� ������, �� �������� ������ ���������� ����. ������� ��� ���������, �� ������ �������.

                $query = 'UPDATE ' . $this->table .
                ' SET lkey = IF(rkey <=' . $node['rkey'] . ', lkey + ' . $skew_edit . ', IF(lkey > ' . $node['rkey'] . ', lkey - ' . $skew_tree . ', lkey)),'.
                ' level = IF(rkey <= ' . $node['rkey'] . ', level + ' . $skew_level . ', level),' .
                ' rkey = IF(rkey <= ' . $node['rkey'] . ', rkey + ' . $skew_edit . ', IF(rkey <= ' . $right_key_near . ', rkey - ' . $skew_tree . ' , rkey))' .
                ' WHERE rkey > ' . $node['lkey'] . ' AND lkey <= ' . $right_key_near ;
                */
            } else {

                $skew_edit = $right_key_near - $node['lkey'] + 1 - $skew_tree;
                $query = 'UPDATE `' . $this->table . '`' .
                ' SET `lkey` = IF(`rkey` <= ' . (int)$node['rkey'] . ', `lkey` + ' . (int)$skew_edit . ', IF(`lkey` > ' . (int)$node['rkey'] . ' , `lkey` - ' . (int)$skew_tree . ', `lkey`)),' .
                ' `level` = IF(`rkey` <= ' . (int)$node['rkey'] . ', `level` + ' . (int)$skew_level . ', `level`), `rkey` = IF(`rkey` <= ' . (int)$node['rkey'] . ', `rkey` + ' . (int)$skew_edit . ',' .
                ' IF(`rkey` <= ' . (int)$right_key_near . ', `rkey` - ' . (int)$skew_tree . ', `rkey`)) WHERE `rkey` > ' . (int)$node['lkey'] . ' AND `lkey` <= ' . (int)$right_key_near .
                ($this->isMultipleTree() ? ' AND `' . $this->treeField . '` = ' . $this->treeFieldID : ' ');

                //$stmt = $this->db->prepare($query);
                //$stmt->bindParam(':rkey', $node['rkey'], PDO::PARAM_INT);
                //$stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
                //$stmt->bindParam(':skew_tree', $skew_tree, PDO::PARAM_INT);
                //$stmt->bindParam(':skew_edit', $skew_edit, PDO::PARAM_INT);
                //$stmt->bindParam(':skew_level', $skew_level, PDO::PARAM_INT);
                //$stmt->bindParam(':right_key_near', $right_key_near, PDO::PARAM_INT);
                //$stmt->execute();
                $this->db->exec($query);
            }

            // ���������� ����� � ������� ������
            $this->updatePaths($node, $parentNode);

            return true;
        }
    }

    /**
     * ����� ���������� ����� ��� ����� ���� ����������
     *
     * @param mixed $node
     * @param mixed $parentNode
     * @return boolean
     */
    public function updatePaths($node, $parentNode = null)
    {
        $node = $this->getNodeInfo($node);

        if (!$parentNode) {
            $parentNode = $this->getParentNode($node);
            if (is_null($parentNode)) {
                $parentNode = $node;
            }
        }

        $parentNode = $this->getNodeInfo($parentNode);

        if ($this->dataTable) {
            $movedBranch = $this->getBranch($parentNode['id']);

            $oldPathToRootNodeOfBranch = $movedBranch[$node['id']]->getPath(false);
            $newPathToRootNodeOfBranch = $this->updatePath($node['id']);

            // ���� ����������� ���� ������� ��� ���� ������� ������, �� ��������� ���� �� ����
            if (count($movedBranch) == 2 && isset($movedBranch[$parentNode['id']]) && isset($movedBranch[$node['id']])) {
                return true;
            }

            $idSet = '(';
            foreach (array_keys($movedBranch) as $i) {
                if ($i == $parentNode['id'] || $i == $node['id']) {
                    continue;
                }
                $idSet .= $i . ',';
            }

            $idSet = substr($idSet, 0, -1) . ')';

            $this->db->exec($qry = 'UPDATE `' . $this->dataTable . '`' .
            ' SET `path` = REPLACE(`path`, "' . $oldPathToRootNodeOfBranch . '", "' . $newPathToRootNodeOfBranch . '") '.
            ' WHERE `' . $this->dataID . '` IN ' . $idSet .
            ($this->isMultipleTree() ? ' AND `' . $this->treeField . '` = ' . $this->treeFieldID : ' ')
            );
        }
    }

    /**
     * ������� ������������� ������� �����
     *
     * @return int
     */
    public function getMaxRightKey()
    {
        return (int)$this->db->getOne('SELECT MAX(`rkey`) FROM `' .$this->table . '`' .
        ($this->isMultipleTree() ? ' WHERE `' . $this->treeField . '` = ' . $this->treeFieldID : ' '));
    }

    /**
     * ������� ������� ����������� ��������� ������������ �������� ����
     *
     * @param  string     $path          ����
     * @return array array with id
     */
    protected function getPathVariants($path)
    {
        $pathParts = explode('/', trim($path));

        $query = '';
        foreach ($pathParts as $pathPart) {
            if (strlen($pathPart) == 0) {
                continue;
            }
            $query .= $this->getBasisQuery() . ' AND `' . $this->innerField . "` = '" . $pathPart . "' UNION ";
        }

        $query = substr($query, 0, -6);
        $stmt = $this->db->query($query);
        $existNodes = $stmt->fetchAll();

        $rewritedPath = array();
        foreach ($existNodes as $i => $node) {
            if ($i == 0) {
                $rewritedPath[$i] = $node[$this->innerField];
            } else {
                $rewritedPath[$i] = $rewritedPath[$i - 1] . '/' . $node[$this->innerField];
            }
        }

        return $rewritedPath;

    }

    /**
     * �������� ���� ��� �������� �����
     *
     */
    public function createPathField()
    {
        if (isset($this->dataTable)) {
            $this->db->query('ALTER TABLE ' . $this->dataTable . ' ADD `path` char(255)');
        }
    }
}



?>
