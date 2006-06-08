<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/**
 * dbTreeNS: ������ � ��������� Nested Sets
 *
 * @package system
 * @version 0.4
*/

class dbTreeNS
{
    protected $db;
    /**
     * ��� ������� ���������� ������
     *
     * @var string
     */
    private   $table;

    /**
     * ��� ������� ���������� ������
     *
     * @var string
     */
    private   $dataTable;

    /**
     * �����������
     *
     * @param array  $init  ������ � �������� � ����������� �����
     */
    public function __construct($init)
    {
        # ������ � ������� � �������
        $this->table = $init['tree']['table']; // as tree
        $this->treeID = $init['tree']['id'];

        # ������ � ������� � �������
        $this->dataTable = isset($init['data']['table'])?$init['data']['table']:null; //as data
        $this->dataID = isset($init['data']['id'])?$init['data']['id']:null;

        $this->rowID = is_null($this->dataID) ? $this->treeID : $this->dataID;

        if(!is_null($this->dataTable)) {
            $this->selectPart = '`data`.*';
            $this->innerPart = 'INNER JOIN ' . $this->dataTable .' data ON `data`.' . $this->dataID . ' = `tree`.' . $this->treeID . ' ';
        }
        else {
            $this->selectPart = '*';
            $this->innerPart = '';
        }

        $this->db = DB::factory();

    }

    public function setDataTable($table)
    {
        $this->dataTable = $table;
    }

    public function getDataTable()
    {
        return $this->dataTable;
    }

    /**
     * ������� ������ �� ������ ������
     *
     * @param  int     $level   ������� ������� ������, �� ��������� ��� ������
     * @return array
     */
    public function getTree($level = 0)
    {
        $stmt = $this->db->prepare(' SELECT ' . $this->selectPart .
                                   ' FROM ' . $this->table. ' tree ' . $this->innerPart .
                                   ' WHERE 1 '.
                                   ($level > 0 ? ' AND (tree.level BETWEEN 1 AND :level)' : '') .
                                   ' ORDER BY tree.lkey');

        $level > 0 ? $stmt->bindParam(':level', $level, PDO::PARAM_INT):'';
        $stmt->execute();

        $i = 0;
        $tree = array();
        while($row = $stmt->fetch()) {
            $tree[$row[$this->rowID]] = $row;
        }

        if(count($tree)) {
            return $tree;
        } else {
            return null;
        }
    }

    /**
     * ������� ���������� � ����
     *
     * @param  int     $id       ������������� ����
     * @return array
     */
    public function getNodeInfo($id)
    {
        $stmt = $this->db->prepare(' SELECT * FROM ' .$this->table. ' WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }

    /**
     * ������� ����� ������� �� ��������� ����
     *
     * @param  int     $id            ������������� ����
     * @param  int     $level         ������� ������� �������
     * @return array
     */
    public function getBranch($id, $level = 0)
    {
        $rootBranch = $this->getNodeInfo($id);
        if(!$rootBranch) {
            return null;
        }

        $stmt = $this->db->prepare(' SELECT ' . $this->selectPart .
                                   ' FROM ' . $this->table . ' `tree` '. $this->innerPart .
                                   ' WHERE lkey >= :lkey AND rkey <= :rkey' .
                                   ' AND (level BETWEEN :high_level AND :level)' .
                                   ' ORDER BY lkey');

        $level = $rootBranch['level'] + $level;
        $stmt->bindParam(':lkey', $rootBranch['lkey'], PDO::PARAM_INT);
        $stmt->bindParam(':rkey', $rootBranch['rkey'], PDO::PARAM_INT);
        $stmt->bindParam(':high_level', $rootBranch['level'], PDO::PARAM_INT);
        $stmt->bindParam(':level', $level, PDO::PARAM_INT);
        $stmt->execute();

        $branch = array();
        while($row = $stmt->fetch()) {
            $branch[$row[$this->rowID]] = $row;
        }

        if(count($branch)) {
            return $branch;
        } else {
            return null;
        }

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
        if(!$lowerChild) {
             return null;
        }
        $highLevel = $lowerChild['level'] - $level;

        $stmt = $this->db->prepare(' SELECT ' . $this->selectPart .
                                   ' FROM ' . $this->table . ' `tree` '. $this->innerPart .
                                   ' WHERE lkey <= :lkey AND rkey >= :rkey' .
                                   ' AND ( level BETWEEN :level AND :child_level )   ORDER BY lkey');

        $stmt->bindParam(':lkey', $lowerChild['lkey'], PDO::PARAM_INT);
        $stmt->bindParam(':rkey', $lowerChild['rkey'], PDO::PARAM_INT);
        $stmt->bindParam(':child_level', $lowerChild['level'], PDO::PARAM_INT);
        $stmt->bindParam(':level', $highLevel, PDO::PARAM_INT);
        $stmt->execute();

        $branch = array();
        while($row = $stmt->fetch()){
            $branch[$row[$this->rowID]] = $row;
        }
        //echo'<pre>';print_r($branch); echo'</pre>';
        if(count($branch)) {
            return $branch;
        } else {
            return null;
        }
    }

    /**
     * ������� ����� � ������� ��������� �������� ����
     *
     * @param  int     $id           ������������� ����
     * @return array
     */
    public function getBranchContainingNode($id)
    {
        $node = $this->getNodeInfo($id);
        if(!$node) return null;

        $stmt = $this->db->prepare(' SELECT ' . $this->selectPart .
                                   ' FROM ' . $this->table . ' `tree` '. $this->innerPart .
                                   ' WHERE rkey >:lkey ' .
                                   ' AND lkey <:rkey ORDER BY lkey');
        $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
        $stmt->bindParam(':rkey', $node['rkey'], PDO::PARAM_INT);
        $stmt->execute();

        $branch = array();
        while($row = $stmt->fetch()) {
            $branch[$row[$this->rowID]] = $row;
        }

        if(count($branch)) {
            return $branch;
        } else {
            return null;
        }
    }
    /**
     * ������� ���������� � ������������ ����
     *
     * @param  int     $id           ������������� ����
     * @return array with id
     */
    public function getParentNode($id)
    {
        $node = $this->getNodeInfo($id);
        if(!$node){ return null; }

        $stmt = $this->db->prepare(' SELECT ' . $this->selectPart .
                                   ' FROM ' . $this->table . ' `tree` '. $this->innerPart .
                                   ' WHERE `tree`.lkey <= :lkey' .
                                   ' AND `tree`.rkey >= :rkey' .
                                   ' AND `tree`.level = :level  ORDER BY `tree`.lkey');

        $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
        $stmt->bindParam(':rkey', $node['rkey'], PDO::PARAM_INT);
        $stmt->bindParam(':level', $v = $node['level'] - 1, PDO::PARAM_INT);

        $stmt->execute();
        $row = $stmt->fetch();

        if($row) {
            return $row;
        } else {
            return null;
        }
    }
    /**
     * ������� ���� ���� ���������
     *
     * @param  int     $id           ������������� ���� ���� �������� ���������
     * @return array
     */
    public function insertNode($id)
    {
        if($id == 0) return $this->insertRootNode();

        $parentNode = $this->getNodeInfo($id);

        $stmt = $this->db->prepare(' UPDATE ' .$this->table.
                                   ' SET rkey = rkey + 2, lkey = IF(lkey > :PN_RKey, lkey + 2, lkey)' .
                                   ' WHERE rkey >= :PN_RKey');

        $stmt->bindParam(':PN_RKey',  $parentNode['rkey'], PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $this->db->prepare(' INSERT INTO ' .$this->table.
                                   ' SET lkey = :parent_rkey, rkey = :PN_RKey, level = :PN_Level');
        $stmt->bindParam(':parent_rkey',  $parentNode['rkey'], PDO::PARAM_INT);
        $stmt->bindParam(':PN_RKey', $v = $parentNode['rkey']+1, PDO::PARAM_INT);
        $stmt->bindParam(':PN_Level', $v = $parentNode['level']+1, PDO::PARAM_INT);
        $stmt->execute();

        $newNode = array('id'    => $this->db->lastInsertId(),
                         'lkey'  => $parentNode['rkey'],
                         'rkey'  => $parentNode['rkey'] + 1,
                         'level' => $parentNode['level'] + 1);


        return $newNode;

    }
    /**
     * ������� ��������� ����
     *
     * @return array
     */
    public function insertRootNode()
    {
        //$parentNode = $this->getNodeInfo($id);
        $maxRightKey = $this->getMaxRightKey();
        $stmt = $this->db->prepare(' UPDATE ' .$this->table.
                                   ' SET rkey = rkey + 1, lkey = lkey + 1, level = level + 1');
        $stmt->execute();
        $stmt = $this->db->prepare(' INSERT INTO ' .$this->table.
                                   ' SET lkey = 1, rkey = :new_max_right_key, level = 1');
        $stmt->bindParam(':new_max_right_key', $v = $maxRightKey + 2, PDO::PARAM_INT);
        $stmt->execute();

        $newRootNode = array('id'    => $this->db->lastInsertId(),
                         'lkey'  => 1,
                         'rkey'  => $maxRightKey + 2,
                         'level' => 1);


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
        $stmt = $this->db->prepare(' DELETE FROM ' .$this->table.
                                   ' WHERE lkey>= :lkey AND rkey<= :rkey');
        $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
        $stmt->bindParam(':rkey', $node['rkey'], PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $this->db->prepare(' UPDATE ' .$this->table.
                                   ' SET lkey = IF(lkey > :lkey, lkey - :val, lkey), rkey = rkey - :val'.
                                   ' WHERE rkey >= :rkey');
        $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
        $stmt->bindParam(':rkey', $node['rkey'], PDO::PARAM_INT);
        $stmt->bindParam(':val', $v = $node['rkey'] - $node['lkey'] + 1, PDO::PARAM_INT);
        $stmt->execute();

        if(!$stmt->errorCode()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * ������ ���� �������
     *
     * @param  int     $id1           ������������� ������� ������������� ����
     * @param  int     $id2           ������������� ������� ������������� ����
     * @return void
     */
    public function swapNode($id1, $id2)
    {
        $node1 = $this->getNodeInfo($id1);
        $node2 = $this->getNodeInfo($id2);

        if(!$node1 || !$node2 || $node1 == $node2) {
            return false;
        }

        $stmt = $this->db->prepare(' UPDATE ' .$this->table.
                                   ' SET lkey = :lkey, rkey = :rkey, level = :level' .
                                   ' WHERE id = :id');

        foreach(array($id1 => $node2, $id2 => $node1) as $id => $node) {
            $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
            $stmt->bindParam(':rkey', $node['rkey'], PDO::PARAM_INT);
            $stmt->bindParam(':level',$node['level'],PDO::PARAM_INT);
            $stmt->bindParam(':id',   $id,           PDO::PARAM_INT);
            $stmt->execute();
            }
    }

    /**
     * ����������� ���� ������ � ���������
     *
     * @param  int     $id           ������������� ������������� ����
     * @param  int     $parentId     ������������� ������ ������������� ����
     * @return void
     */
    public function moveNode($id, $parentId)
    {
        $node       = $this->getNodeInfo($id);
        $parentNode = $this->getNodeInfo($parentId);

        if ( $id == $parentId ) return false;
        if ( !$node || !$parentNode ) return false;
        if($parentNode['lkey'] >= $node['lkey'] && $parentNode['lkey'] <= $node['rkey']) return false;

        $level_up = ($notRoot = $parentNode['level'] != 1 ) ? $parentNode['level'] : 0;

        $query = ($notRoot) ?
        "SELECT (rkey - 1) AS rkey FROM " . $this->table . " WHERE id = " . $parentId :
        "SELECT MAX(rkey) as rkey FROM " . $this->table;

        if ($row = $this->db->getRow($query) ) {
            $rkey = $row['rkey'];
            $right_key_near = $rkey;
            $skew_level = $level_up - $node['level'] + 1;
            $skew_tree = $node['rkey'] - $node['lkey'] + 1;

            $query = 'SELECT id FROM ' . $this->table . ' WHERE lkey >= :lkey AND rkey <= :rkey';
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
            $stmt->bindParam(':rkey', $node['rkey'], PDO::PARAM_INT);
            $stmt->execute();

            $id_edit = '';
            while ( $row = $stmt->fetch() ) {
                $id_edit .= ( $id_edit != '' ) ? ', ' : '';
                $id_edit .= $row['id'];
            };

            if ( $node['rkey'] > $right_key_near ) {
                $skew_edit = $right_key_near - $node['lkey'] + 1;

                $query = "UPDATE " . $this->table . ' SET rkey = rkey + :skew_tree WHERE rkey < :lkey AND rkey > :right_key_near';
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':skew_tree', $skew_tree, PDO::PARAM_INT);
                $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
                $stmt->bindParam(':right_key_near', $right_key_near, PDO::PARAM_INT);
                $stmt->execute();

                $query = 'UPDATE ' . $this->table . ' SET lkey = lkey + :skew_tree WHERE lkey < :lkey AND lkey > :right_key_near';
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':skew_tree', $skew_tree, PDO::PARAM_INT);
                $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
                $stmt->bindParam(':right_key_near', $right_key_near, PDO::PARAM_INT);
                $stmt->execute();

                $query = 'UPDATE ' . $this->table . ' SET lkey = lkey + :skew_edit , rkey = rkey + :skew_edit , level = level + :skew_level WHERE id IN ( :id_edit )';
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':skew_edit', $skew_edit, PDO::PARAM_INT);
                $stmt->bindParam(':skew_level', $skew_level, PDO::PARAM_INT);
                $stmt->bindParam(':id_edit', $id_edit, PDO::PARAM_STR);
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
                $query = 'UPDATE ' . $this->table .
                         ' SET lkey = IF(rkey <= :rkey, lkey + :skew_edit, IF(lkey > :rkey , lkey - :skew_tree , lkey)),' .
                         ' level = IF(rkey <= :rkey, level + :skew_level, level), rkey = IF(rkey <= :rkey, rkey + :skew_edit,' .
                         ' IF(rkey <= :right_key_near , rkey - :skew_tree, rkey)) WHERE rkey > :lkey AND lkey <= :right_key_near';
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':rkey', $node['rkey'], PDO::PARAM_INT);
                $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
                $stmt->bindParam(':skew_tree', $skew_tree, PDO::PARAM_INT);
                $stmt->bindParam(':skew_edit', $skew_edit, PDO::PARAM_INT);
                $stmt->bindParam(':skew_level', $skew_level, PDO::PARAM_INT);
                $stmt->bindParam(':right_key_near', $right_key_near, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

    }

    public function getMaxRightKey()
    {
        return $this->db->getOne(' SELECT MAX(rkey) FROM ' .$this->table);
    }

}



?>