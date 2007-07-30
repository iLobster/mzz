<?php

//fileLoader::load('db/sqlFunction');
//fileLoader::load('db/simpleSelect');

class new_dbTreeNS
{
    /**
     * ������ �� ��������� PDO
     *
     * @var mzzPdo
     */
    private $db;

    /**
     * ��������� ����������� ������� ������ � ������� ���������
     *
     * @see new_simpleMapperForTree::getTreeParams()
     * @var array
     */
    private $params = array();

    /**
     * ������ �� ������, ���������� � �������
     *
     * @var new_simpleMapperForTree
     */
    private $mapper;

    /**
     * �����������
     *
     * @param array $params
     * @param new_simpleMapperForTree $mapper
     */
    public function __construct(Array $params, $mapper)
    {
        $this->params = $params;
        $this->mapper = $mapper;
        $this->db = db::factory();
    }

    /**
     * ���������� � �������� ����������� ������� � ������� � ������� �� ����������
     *
     * @param criteria $criteria
     */
    public function addJoin(criteria $criteria)
    {
        $criteria->addJoin($this->params['tableName'], new criterion('tree.id', $this->mapper->getClassName() . '.' . $this->params['joinField'], criteria::EQUAL, true), 'tree', criteria::JOIN_INNER);
    }

    /**
     * ���������� � �������� ������� ����������� ����� ��� ������� ������ � ��������� ������ � ���� � �����������
     *
     * @param criteria $criteria
     * @param string $alias ����� �� ������� �� ����������
     */
    public function addSelect(criteria $criteria, $alias = 'tree')
    {
        $criteria->addSelectField($alias . '.id', $alias . simpleMapper::TABLE_KEY_DELIMITER . 'id')
        ->addSelectField($alias . '.lkey', $alias . simpleMapper::TABLE_KEY_DELIMITER . 'lkey')
        ->addSelectField($alias . '.rkey', $alias . simpleMapper::TABLE_KEY_DELIMITER . 'rkey')
        ->addSelectField($alias . '.level', $alias . simpleMapper::TABLE_KEY_DELIMITER . 'level')
        ->setOrderByFieldAsc($alias . '.lkey');
    }

    /**
     * ��������� ���������� �� ����
     *
     * @param new_simpleForTree|integer $id
     * @return unknown
     */
    public function getNodeInfo($id)
    {
        if ($id instanceof new_simpleForTree) {
            $id = $id->getTreeKey();
        }

        $criteria = new criteria($this->params['tableName'], 'tree');

        $criteria->add('tree.id', $id);

        $select = new simpleSelect($criteria);
        $row = $this->db->getAll($select->toString());

        return $this->createItemFromRow($row[0]);
    }

    /**
     * ������� �� ������� � ������� ���� ������, ����������� � ���������
     *
     * @param array $row
     * @return array
     */
    public function createItemFromRow($row)
    {
        return array('id' => $row['id'], 'lkey' => $row['lkey'], 'rkey' => $row['rkey'], 'level' => $row['level']);
    }

    /**
     * ��������� ����� ������
     *
     * @param criteria $criteria
     * @param new_simpleForTree $id
     * @param integer $level
     */
    public function getBranch(criteria $criteria, new_simpleForTree $id, $level = 0)
    {
        $node = $this->getNodeInfo($id);

        $criteria->add('tree.lkey', $node['lkey'], criteria::GREATER_EQUAL);
        $criteria->add('tree.rkey', $node['rkey'], criteria::LESS_EQUAL);
        if ($level > 0) {
            $criteria->add('tree.level', $node['level'] + $level, criteria::LESS_EQUAL);
        }
    }

    /**
     * ��������� ������������ �����
     *
     * @param criteria $criteria
     * @param new_simpleForTree $node
     */
    public function getParentBranch(criteria $criteria, new_simpleForTree $node)
    {
        $node = $this->getNodeInfo($node);

        $criteria->add('tree.lkey', $node['lkey'], criteria::LESS_EQUAL);
        $criteria->add('tree.rkey', $node['rkey'], criteria::GREATER_EQUAL);
    }

    /**
     * ��������� ������������� ����
     *
     * @param criteria $criteria
     * @param new_simpleForTree $id
     */
    public function getParentNode(criteria $criteria, new_simpleForTree $id)
    {
        $node = $this->getNodeInfo($id);

        $criteria->add('tree.lkey', $node['lkey'], criteria::LESS);
        $criteria->add('tree.rkey', $node['rkey'], criteria::GREATER);
        $criteria->add('tree.level', $node['level'] - 1);
    }

    /**
     * ������� ����
     *
     * @param new_simpleForTree $id
     * @return integer id ����������� ������
     */
    public function insert(new_simpleForTree $id)
    {
        $node = $this->getNodeInfo($id);
        $qry = 'UPDATE `' . $this->params['tableName'] . '` SET rkey = rkey + 2, lkey = IF(lkey > ' . $node['rkey'] . ', lkey + 2, lkey) WHERE rkey >= ' . $node['rkey'];
        $this->db->query($qry);
        $qry = 'INSERT INTO `' . $this->params['tableName'] . '` SET lkey = ' . $node['rkey'] . ', rkey = ' . $node['rkey'] . ' + 1, level = ' . $node['level'] . ' + 1';
        $this->db->query($qry);

        return $this->db->lastInsertId();
    }

    /**
     * ����������� ����
     *
     * @param new_simpleForTree $node
     * @param new_simpleForTree $target
     * @return boolean
     */
    public function move(new_simpleForTree $node, new_simpleForTree $target)
    {
        $target = $this->getNodeInfo($target);
        $node = $this->getNodeInfo($node);

        $skew_tree = $node['rkey'] - $node['lkey'] + 1;
        $skew_level = $target['level'] - $node['level'] + 1;

        $rkey_near = $target['rkey'] - 1;

        $skew_edit = $rkey_near - $node['lkey'] + 1;

        if ($node['rkey'] > $rkey_near) {
            $qry = 'SELECT `id` FROM `' . $this->params['tableName'] . '` WHERE lkey >= ' . $node['lkey'] . ' AND rkey <= ' . $node['rkey'];
            $id_edit = '';
            foreach ($this->db->getAll($qry) as $val) {
                $id_edit .= $val['id'] . ', ';
            }
            $id_edit = substr($id_edit, 0, -2);

            $qry = 'UPDATE `' . $this->params['tableName'] . '` SET rkey = rkey + ' . $skew_tree . ' WHERE rkey < ' . $node['lkey'] . ' AND rkey > ' . $rkey_near;
            $this->db->query($qry);
            $qry = 'UPDATE `' . $this->params['tableName'] . '` SET lkey = lkey + ' . $skew_tree . ' WHERE lkey < ' . $node['lkey'] . ' AND lkey > ' . $rkey_near;
            $this->db->query($qry);
            $qry = 'UPDATE `' . $this->params['tableName'] . '` SET lkey = lkey + ' . $skew_edit . ', rkey = rkey + ' . $skew_edit . ', level = level + ' . $skew_level . ' WHERE id IN (' . $id_edit . ')';
            $this->db->query($qry);
        } else {
            $skew_edit -= $skew_tree;

            $qry = 'UPDATE `' . $this->params['tableName'] . '`
                    SET `lkey` = IF(`rkey` <= ' . $node['rkey'] . ', `lkey` + ' . $skew_edit . ', IF(`lkey` > ' . $node['rkey'] . ' , `lkey` - ' . $skew_tree . ', `lkey`)),
                    `level` = IF(`rkey` <= ' . $node['rkey'] . ', `level` + ' . $skew_level . ', `level`), `rkey` = IF(`rkey` <= ' . $node['rkey'] . ', `rkey` + ' . $skew_edit . ',
                    IF(`rkey` <= ' . $rkey_near . ', `rkey` - ' . $skew_tree . ', `rkey`)) WHERE `rkey` > ' . $node['lkey'] . ' AND `lkey` <= ' . $rkey_near;

            $this->db->query($qry);
        }

        return true;
    }

    /**
     * �������� ����
     *
     * @param new_simpleForTree $id
     */
    public function delete(new_simpleForTree $id)
    {
        $node = $this->getNodeInfo($id);
        $qry = 'DELETE FROM `' . $this->params['tableName'] . '` WHERE lkey >= ' . $node['lkey'] . ' AND rkey <= ' . $node['rkey'];
        $this->db->query($qry);
        $diff = $node['rkey'] - $node['lkey'] + 1;
        $qry = 'UPDATE `' . $this->params['tableName'] . '` SET lkey = IF(lkey > ' . $node['lkey'] . ', lkey - ' . $diff  . ', lkey), rkey = rkey - ' . $diff . ' WHERE rkey > ' . $node['rkey'];
        $this->db->query($qry);
    }
}

?>