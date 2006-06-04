<?php
//
// $Id: standart_header.txt 620 2006-05-07 18:03:00Z zerkms $
// $URL: svn://svn.subversion.ru/usr/local/svn/mzz/docs/standart_header.txt $
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
        while($row = $stmt->fetch()){
            $tree[$row['id']] = array('lkey'  => $row['lkey'],
                                      'rkey'  => $row['rkey'],
                                      'level' => $row['level']);
            }
        return $tree;
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
        if($withId) $idStr = ' id, ';
        else $idStr = '';
        $stmt = $this->db->prepare(' SELECT ' . $idStr . 'lkey, rkey, level FROM ' .$this->table. ' WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if($row = $stmt->fetch()){
            return $row;
            }
        else{
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
        $withParent ? $equalCond = '=' : $equalCond = ' ';
        $rootBranch = $this->getNodeInfo($id);
        if(!$rootBranch) return null;

        $stmt = $this->db->prepare(' SELECT * FROM ' .$this->table.
                                   ' WHERE lkey >' .$equalCond . $rootBranch['lkey'] .
                                   ' AND rkey <' .$equalCond . $rootBranch['rkey'] . '  ORDER BY lkey');

        $stmt->execute();
        while($row = $stmt->fetch()){
            $branch[$row['id']] = array('lkey'  => $row['lkey'],
                                        'rkey'  => $row['rkey'],
                                        'level' => $row['level']);
            }

        return $branch;

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
        $withParent ? $equalCond = '=' : $equalCond = ' ';
        $lowerChild = $this->getNodeInfo($id);
        if(!$lowerChild) return null;

        $stmt = $this->db->prepare(' SELECT * FROM ' .$this->table.
                                   ' WHERE lkey <' .$equalCond . $lowerChild['lkey'] .
                                   ' AND rkey >' .$equalCond . $lowerChild['rkey'] . '  ORDER BY lkey');
        $stmt->execute();
        while($row = $stmt->fetch()){
            $branch[$row['id']] = array('lkey'  => $row['lkey'],
                                        'rkey'  => $row['rkey'],
                                        'level' => $row['level']);
            }

        return $branch;
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

        $stmt = $this->db->prepare(' SELECT * FROM ' .$this->table.
                                   ' WHERE rkey >' . $node['lkey'] .
                                   ' AND lkey <' . $node['rkey'] . '  ORDER BY lkey');
        $stmt->execute();
        while($row = $stmt->fetch()){
            $branch[$row['id']] = array('lkey'  => $row['lkey'],
                                        'rkey'  => $row['rkey'],
                                        'level' => $row['level']);
            }

        return $branch;
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
        if(!$node) return null;

        $stmt = $this->db->prepare(' SELECT * FROM ' .$this->table.
                                   ' WHERE lkey <=' . $node['lkey'] .
                                   ' AND rkey >=' . $node['rkey'] .
                                   ' AND level = '.($node['level']-1) . '  ORDER BY lkey');
        $stmt->execute();
        $row = $stmt->fetch();
        if($row) return $row;
        else     return null;
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
                                   ' SET rkey = rkey + 2, lkey = IF(lkey > ' . $parentNode['rkey'] . ', lkey + 2, lkey)' .
                                   ' WHERE rkey >=' . $parentNode['rkey']);
        $stmt->execute();

        $stmt = $this->db->prepare(' INSERT INTO ' .$this->table.
                                   ' SET lkey = ' . $parentNode['rkey'] . ', rkey = ' . ($parentNode['rkey'] + 1) . ', level = ' . ($parentNode['level'] + 1));
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
                                   ' SET lkey = 1, rkey = ' . ($maxRightKey + 2) . ', level = 1');
        $stmt->execute();
        $newRootNode = array('id'    => $this->db->lastInsertId(),
                         'lkey'  => 1,
                         'rkey'  => $maxRightKey + 2,
                         'level' => 1);


        return $newRootNode;

    }

    public function getMaxRightKey()
    {
        $stmt = $this->db->prepare(' SELECT MAX(`rkey`) FROM ' .$this->table);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);
        return $row[0];


    }

}



?>