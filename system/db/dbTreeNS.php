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
 * dbTreeNS: работа с деревьями Nested Sets
 *
 * @package system
 * @version 0.1
*/
class dbTreeNS
{
    protected $db;
    private   $table = 'tree';

    public function __construct()
    {
        $this->db = DB::factory();
    }

    public function getTable()
    {
        return $this->table;
    }

    /**
     * Выборка дерева по левому обходу
     *
     * @return array
     */
    public function getTree()
    {
        $stmt = $this->db->prepare(' SELECT * FROM ' .$this->table. ' ORDER BY lkey');
        $stmt->execute();
        $i = 0;
        $tree = array();
        while($row = $stmt->fetch()) {
            $tree[$row['id']] = array('lkey'  => $row['lkey'],
                                      'rkey'  => $row['rkey'],
                                      'level' => $row['level']);
        }

        if(count($tree)) {
            return $tree;
        } else {
            return null;
        }
    }

    /**
     * Выборка информации о узле
     *
     * @param  int     $id       Идентификатор узла
     * @param  int     $withId   ДОлжен ли быть id в возвращаемом наборе
     * @return array
     */
    public function getNodeInfo($id, $withId = false)
    {
        $idStr = $withId ? ' id, ' : '';
        $stmt = $this->db->prepare(' SELECT ' . $idStr . 'lkey, rkey, level FROM ' .$this->table. ' WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }

    /**
     * Выборка ветки начиная от заданного узла
     *
     * @param  int     $id           Идентификатор узла
     * @param  bool    $withParent   Выбирать ли исходный узел ветки
     * @return array
     */
    public function getBranch($id, $withParent = true)
    {
        $equalCond = $withParent ?  '=' :  ' ';
        $rootBranch = $this->getNodeInfo($id);
        if(!$rootBranch) {
            return null;
        }

        $stmt = $this->db->prepare(' SELECT * FROM ' .$this->table.
                                   ' WHERE lkey >' .$equalCond . ':lkey' .
                                   ' AND rkey <' .$equalCond . ':rkey  ORDER BY lkey');

        $stmt->bindParam(':lkey', $rootBranch['lkey'], PDO::PARAM_INT);
        $stmt->bindParam(':rkey', $rootBranch['rkey'], PDO::PARAM_INT);

        $stmt->execute();

        $branch = array();
        while($row = $stmt->fetch()) {
            $branch[$row['id']] = array('lkey'  => $row['lkey'],
                                        'rkey'  => $row['rkey'],
                                        'level' => $row['level']);
        }

        if(count($branch)) {
            return $branch;
        } else {
            return null;
        }

    }

    /**
     * Выборка родительской ветки начиная от заданного узла
     *
     * @param  int     $id           Идентификатор узла
     * @param  bool    $withParent   Выбирать ли исходный корень ветки
     * @return array
     */
    public function getParentBranch($id, $withParent = true)
    {
        $equalCond = $withParent ? '=' : ' ';
        $lowerChild = $this->getNodeInfo($id);
        if(!$lowerChild) {
             return null;
        }

        $stmt = $this->db->prepare(' SELECT * FROM ' .$this->table.
                                   ' WHERE lkey <' .$equalCond . ':lkey' .
                                   ' AND rkey >' .$equalCond . ':rkey' . '  ORDER BY lkey');

        $stmt->bindParam(':lkey', $lowerChild['lkey'], PDO::PARAM_INT);
        $stmt->bindParam(':rkey', $lowerChild['rkey'], PDO::PARAM_INT);
        $stmt->execute();

        $branch = array();
        while($row = $stmt->fetch()){
            $branch[$row['id']] = array('lkey'  => $row['lkey'],
                                        'rkey'  => $row['rkey'],
                                        'level' => $row['level']);
        }

        if(count($branch)) {
            return $branch;
        } else {
            return null;
        }
    }

    /**
     * Выборка ветки в которой находится заданный узел
     *
     * @param  int     $id           Идентификатор узла
     * @return array
     */
    public function getBranchContainingNode($id)
    {
        $node = $this->getNodeInfo($id);
        if(!$node) return null;

        $stmt = $this->db->prepare(' SELECT * FROM ' .$this->table .
                                   ' WHERE rkey >:lkey ' .
                                   ' AND lkey <:rkey ORDER BY lkey');
        $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
        $stmt->bindParam(':rkey', $node['rkey'], PDO::PARAM_INT);
        $stmt->execute();

        $branch = array();
        while($row = $stmt->fetch()) {
            $branch[$row['id']] = array('lkey'  => $row['lkey'],
                                        'rkey'  => $row['rkey'],
                                        'level' => $row['level']);
        }

        if(count($branch)) {
            return $branch;
        } else {
            return null;
        }
    }
    /**
     * Выборка информации о родительском узле
     *
     * @param  int     $id           Идентификатор узла
     * @return array with id
     * @todo   упростить, без пробегания по всему дереву
     */
    public function getParentNode($id)
    {
        $node = $this->getNodeInfo($id);
        if(!$node){ return null; }

        $stmt = $this->db->prepare(' SELECT * FROM ' .$this->table.
                                   ' WHERE lkey <=:lkey' .
                                   ' AND rkey >=:rkey' .
                                   ' AND level = :level  ORDER BY lkey');

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
     * Вставка узла ниже заданного
     *
     * @param  int     $id           Идентификатор узла ниже которого размещать
     * @return array
     */
    public function insertNode($id)
    {
        //if($id == 0) return $this->insertRootNode();

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
     * Вставка корневого узла
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
                                   ' SET lkey = 1, rkey = :mrk, level = 1');
        $stmt->bindParam(':mrk', $v = $maxRightKey + 2, PDO::PARAM_INT);
        $stmt->execute();

        $newRootNode = array('id'    => $this->db->lastInsertId(),
                         'lkey'  => 1,
                         'rkey'  => $maxRightKey + 2,
                         'level' => 1);


        return $newRootNode;

    }
    /**
     * Удаление узла вместе с потомками
     *
     * @param  int     $id           Идентификатор удаляемого узла
     * @return void
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
    }
    /**
     * Перемещение узла вместе с потомками
     *
     * @param  int     $id           Идентификатор перемещаемого узла
     * @param  int     $parentId     Идентификатор нового родительского узла
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

        //echo'<pre>$parentId[level]=';print_r($parentId['level']); echo'</pre>';
        //echo'<pre>$level_up=';print_r($level_up); echo'</pre>';

        $query = ($notRoot) ?
        "SELECT (rkey - 1) AS rkey FROM " . $this->table . " WHERE id = " . $parentId :
        "SELECT MAX(rkey) as rkey FROM " . $this->table;

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        if ($row = $stmt->fetch() ) {
            $rkey = $row['rkey'];
            $right_key_near = $rkey;
            $skew_level = $level_up - $node['level'] + 1;

            //echo'<pre>$skew_level=';print_r($skew_level); echo'</pre>';

            $skew_tree = $node['rkey'] - $node['lkey'] + 1;
            $query = "SELECT id FROM " . $this->table . " WHERE lkey >= " . $node['lkey'] . " AND rkey <= " . $node['rkey'];
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $id_edit = '';
            while ( $row = $stmt->fetch() ) {
                $id_edit .= ( $id_edit != '' ) ? ', ' : '';
                $id_edit .= $row['id'];
            };

            if ( $node['rkey'] > $right_key_near ) {
                $skew_edit = $right_key_near - $node['lkey'] + 1;

                $query = "UPDATE " . $this->table . " SET rkey = rkey + " . $skew_tree . " WHERE rkey < " . $node['lkey'] . " AND rkey > " . $right_key_near;
                $stmt = $this->db->prepare($query);
                $stmt->execute();

                $query = "UPDATE " . $this->table . " SET lkey = lkey + " . $skew_tree . " WHERE lkey < " . $node['lkey'] . " AND lkey > " . $right_key_near;
                $stmt = $this->db->prepare($query);
                $stmt->execute();

                $query = "UPDATE " . $this->table . " SET lkey = lkey + " . $skew_edit . ", rkey = rkey + " . $skew_edit . ", level = level + " . $skew_level . " WHERE id IN (" . $id_edit . ")";
                $stmt = $this->db->prepare($query);
                $stmt->execute();
                /*
                @todo отладить запрос, он является суммой предыдущих трех. Навроде все правильно, но только навроде.

                $query = 'UPDATE ' . $this->table .
                         ' SET lkey = IF(rkey <=' . $node['rkey'] . ', lkey + ' . $skew_edit . ', IF(lkey > ' . $node['rkey'] . ', lkey - ' . $skew_tree . ', lkey)),'.
                         ' level = IF(rkey <= ' . $node['rkey'] . ', level + ' . $skew_level . ', level),' .
                         ' rkey = IF(rkey <= ' . $node['rkey'] . ', rkey + ' . $skew_edit . ', IF(rkey <= ' . $right_key_near . ', rkey - ' . $skew_tree . ' , rkey))' .
                         ' WHERE rkey > ' . $node['lkey'] . ' AND lkey <= ' . $right_key_near ;

                $stmt = $this->db->prepare($query);
                echo'<pre>';print_r($stmt); echo'</pre>';
                $stmt->execute(); */

            } else {
                //echo'<pre>';print_r($stmt); echo'</pre>';
                $skew_edit = $right_key_near - $node['lkey'] + 1 - $skew_tree;
                $query = "UPDATE " . $this->table . " SET lkey = IF(rkey <= " . $node['rkey'] . ", lkey + " . $skew_edit . ", IF(lkey > " . $node['rkey'] . ", lkey - " . $skew_tree . ", lkey)), level = IF(rkey <= " . $node['rkey'] . ", level + " . $skew_level . ", level), rkey = IF(rkey <= " . $node['rkey'] . ", rkey + " . $skew_edit . ", IF(rkey <= " . $right_key_near . ", rkey - " . $skew_tree . ", rkey)) WHERE rkey > " . $node['lkey'] . " AND lkey <= " . $right_key_near;
                $stmt = $this->db->prepare($query);
                //echo'<pre>';print_r($stmt); echo'</pre>';
                $stmt->execute();
            };
        };

    }

    public function getMaxRightKey()
    {
        return $this->db->getOne(' SELECT MAX(rkey) FROM ' .$this->table);
    }

}



?>