<?php

//fileLoader::load('db/sqlFunction');
//fileLoader::load('db/simpleSelect');

class new_dbTreeNS
{
    private $table;
    private $fields;
    private $criteria;
    private $return_stmt = false;

    public function __construct($table)
    {
        $this->table = $table;
        $this->db = db::factory();
        $this->fields = array(
        'id' => 'tree' . simpleMapper::TABLE_KEY_DELIMITER . 'id',
        'lkey' => 'tree' . simpleMapper::TABLE_KEY_DELIMITER . 'lkey',
        'rkey' => 'tree' . simpleMapper::TABLE_KEY_DELIMITER . 'rkey',
        'level' => 'tree' . simpleMapper::TABLE_KEY_DELIMITER . 'level'
        );
    }

    public function appendCriteria(criteria $criteria)
    {
        $this->criteria = $criteria;
        $this->return_stmt = true;
    }

    public function getTree($level = null)
    {
        $criteria = $this->getCriteria();

        if ($level) {
            $criteria->add('tree.level', $level, criteria::LESS_EQUAL);
        }

        $select = new simpleSelect($criteria);

        $stmt = $this->db->query($select->toString());

        return $this->returnData($stmt);
    }

    public function getFields()
    {
        return $this->fields;
    }

    private function getStdCriteria()
    {
        $criteria = new criteria($this->table, 'tree');

        $criteria->addSelectField('tree.id', $this->fields['id'])
        ->addSelectField('tree.lkey', $this->fields['lkey'])
        ->addSelectField('tree.rkey', $this->fields['rkey'])
        ->addSelectField('tree.level', $this->fields['level']);
        $criteria->setOrderByFieldAsc('tree.lkey');

        return $criteria;
    }

    private function getCriteria()
    {
        $criteria = $this->getStdCriteria();

        if ($this->criteria) {
            $criteria->append($this->criteria);
        }

        return $criteria;
    }

    private function returnData($stmt)
    {
        if ($this->return_stmt) {
            return $stmt;
        }

        $result = array();
        while ($row = $stmt->fetch()) {
            $result[] = $row;
        }

        return $result;
    }

    public function getBranch($id, $level = 0)
    {
        $node = $this->getNodeInfo($id);

        $criteria = $this->getCriteria();

        $criteria->add('tree.lkey', $node['lkey'], criteria::GREATER_EQUAL);
        $criteria->add('tree.rkey', $node['rkey'], criteria::LESS_EQUAL);
        if ($level > 0) {
            $criteria->add('tree.level', $node['level'] + $level, criteria::LESS_EQUAL);
        }

        $select = new simpleSelect($criteria);
        $stmt = $this->db->query($select->toString());

        return $this->returnData($stmt);
    }

    public function getParentBranch($id)
    {
        $node = $this->getNodeInfo($id);

        $criteria = $this->getCriteria();

        $criteria->add('tree.lkey', $node['lkey'], criteria::LESS_EQUAL);
        $criteria->add('tree.rkey', $node['rkey'], criteria::GREATER_EQUAL);

        $select = new simpleSelect($criteria);
        $stmt = $this->db->query($select->toString());

        return $this->returnData($stmt);
    }

    public function getBranchContainingNode($id)
    {
        $node = $this->getNodeInfo($id);

        $criteria = $this->getCriteria();

        $criteria->add('tree.rkey', $node['lkey'], criteria::GREATER);
        $criteria->add('tree.lkey', $node['rkey'], criteria::LESS);

        $select = new simpleSelect($criteria);
        $stmt = $this->db->query($select->toString());

        return $this->returnData($stmt);
    }

    public function getParentNode($id)
    {
        $node = $this->getNodeInfo($id);
        $criteria = $this->getCriteria();
        $criteria->add('tree.lkey', $node['lkey'], criteria::LESS);
        $criteria->add('tree.rkey', $node['rkey'], criteria::GREATER);
        $criteria->add('tree.level', $node['level'] - 1);

        $select = new simpleSelect($criteria);
        $stmt = $this->db->query($select->toString());

        $data = $this->returnData($stmt);

        return is_array($data) ? $this->createItemFromRow($data[0]) : $data;
        //return $this->returnData($stmt);
        /*$row = $this->db->getAll($select->toString());

        return $this->createItemFromRow($row[0]);*/
    }

    public function move($node, $target)
    {
        $target = $this->getNodeInfo($target);
        $node = $this->getNodeInfo($node);

        $skew_tree = $node['rkey'] - $node['lkey'] + 1;
        $skew_level = $target['level'] - $node['level'] + 1;

        $rkey_near = $target['rkey'] - 1;

        $skew_edit = $rkey_near - $node['lkey'] + 1;

        if ($node['rkey'] > $rkey_near) {
            $qry = 'SELECT `id` FROM `' . $this->table . '` WHERE lkey >= ' . $node['lkey'] . ' AND rkey <= ' . $node['rkey'];
            $id_edit = '';
            foreach ($this->db->getAll($qry) as $val) {
                $id_edit .= $val['id'] . ', ';
            }
            $id_edit = substr($id_edit, 0, -2);

            $qry = 'UPDATE `' . $this->table . '` SET rkey = rkey + ' . $skew_tree . ' WHERE rkey < ' . $node['lkey'] . ' AND rkey > ' . $rkey_near;
            $this->db->query($qry);
            $qry = 'UPDATE `' . $this->table . '` SET lkey = lkey + ' . $skew_tree . ' WHERE lkey < ' . $node['lkey'] . ' AND lkey > ' . $rkey_near;
            $this->db->query($qry);
            $qry = 'UPDATE `' . $this->table . '` SET lkey = lkey + ' . $skew_edit . ', rkey = rkey + ' . $skew_edit . ', level = level + ' . $skew_level . ' WHERE id IN (' . $id_edit . ')';
            $this->db->query($qry);
        } else {
            $skew_edit -= $skew_tree;

            $qry = 'UPDATE `' . $this->table . '`
                     SET `lkey` = IF(`rkey` <= ' . $node['rkey'] . ', `lkey` + ' . $skew_edit . ', IF(`lkey` > ' . $node['rkey'] . ' , `lkey` - ' . $skew_tree . ', `lkey`)),
                      `level` = IF(`rkey` <= ' . $node['rkey'] . ', `level` + ' . $skew_level . ', `level`), `rkey` = IF(`rkey` <= ' . $node['rkey'] . ', `rkey` + ' . $skew_edit . ',
                        IF(`rkey` <= ' . $rkey_near . ', `rkey` - ' . $skew_tree . ', `rkey`)) WHERE `rkey` > ' . $node['lkey'] . ' AND `lkey` <= ' . $rkey_near;

            $this->db->query($qry);
        }

        return true;
    }

    public function insert($id)
    {
        $node = $this->getNodeInfo($id);
        $qry = 'UPDATE `' . $this->table . '` SET rkey = rkey + 2, lkey = IF(lkey > ' . $node['rkey'] . ', lkey + 2, lkey) WHERE rkey >= ' . $node['rkey'];
        $this->db->query($qry);
        $qry = 'INSERT INTO `' . $this->table . '` SET lkey = ' . $node['rkey'] . ', rkey = ' . $node['rkey'] . ' + 1, level = ' . $node['level'] . ' + 1';
        $this->db->query($qry);

        return $this->db->lastInsertId();
    }

    public function delete($id)
    {
        $node = $this->getNodeInfo($id);
        $qry = 'DELETE FROM `' . $this->table . '` WHERE lkey >= ' . $node['lkey'] . ' AND rkey <= ' . $node['rkey'];
        $this->db->query($qry);
        $diff = $node['rkey'] - $node['lkey'] + 1;
        $qry = 'UPDATE `' . $this->table . '` SET lkey = IF(lkey > ' . $node['lkey'] . ', lkey - ' . $diff  . ', lkey), rkey = rkey - ' . $diff . ' WHERE rkey > ' . $node['rkey'];
        $this->db->query($qry);
    }

    public function getNodeInfo($id)
    {
        if ($id instanceof new_simpleForTree) {
            $id = $id->getTreeKey();
        }

        $criteria = $this->getStdCriteria();

        $criteria->add('tree.id', $id);

        $select = new simpleSelect($criteria);
        $row = $this->db->getAll($select->toString());

        return $this->createItemFromRow($row[0]);
    }

    public function createItemFromRow($row)
    {
        return array('id' => $row[$this->fields['id']], 'lkey' => $row[$this->fields['lkey']], 'rkey' => $row[$this->fields['rkey']], 'level' => $row[$this->fields['level']]);
    }
}

?>