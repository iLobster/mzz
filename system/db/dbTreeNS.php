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

/**
 * dbTreeNS: класс для работы с древовидными структурами
 *
 * @package system
 * @version 0.1
 */
class dbTreeNS
{
    /**
     * Ссылка на инстанцию PDO
     *
     * @var mzzPdo
     */
    private $db;

    /**
     * Идентификатор дерева
     *
     * @var integer
     */
    private $tree_id;

    /**
     * Параметры объединения таблицы данных и таблицы структуры
     *
     * @see simpleMapperForTree::getTreeParams()
     * @var array
     */
    private $params = array();

    /**
     * Ссылка на маппер, работающий с данными
     *
     * @var simpleMapperForTree
     */
    private $mapper;

    /**
     * Конструктор
     *
     * @param array $params
     * @param simpleMapperForTree $mapper
     */
    public function __construct(Array $params, $mapper)
    {
        $this->params = $params;
        $this->mapper = $mapper;
        $this->db = db::factory();
    }

    public function setTree($tree_id)
    {
        $this->tree_id = $tree_id;
    }

    /**
     * Добавление к критерии объединения таблицы с данными и таблицы со структурой
     *
     * @param criteria $criteria
     */
    public function addJoin(criteria $criteria)
    {
        $criteria->addJoin($this->params['tableName'], new criterion('tree.id', $this->mapper->getClassName() . '.' . $this->params['joinField'], criteria::EQUAL, true), 'tree', criteria::JOIN_INNER);

        if ($this->tree_id) {
            $criteria->add('tree.' . $this->params['treeIdField'], $this->tree_id);
        }
    }

    /**
     * Добавление к критерии выборки стандартных полей для выборки данных о структуре дерева и поля с сортировкой
     *
     * @param criteria $criteria
     * @param string $alias алиас на таблицу со структурой
     */
    public function addSelect(criteria $criteria, $alias = 'tree')
    {
        $criteria->addSelectField($alias . '.id', $alias . simpleMapper::TABLE_KEY_DELIMITER . 'id')
        ->addSelectField($alias . '.lkey', $alias . simpleMapper::TABLE_KEY_DELIMITER . 'lkey')
        ->addSelectField($alias . '.rkey', $alias . simpleMapper::TABLE_KEY_DELIMITER . 'rkey')
        ->addSelectField($alias . '.level', $alias . simpleMapper::TABLE_KEY_DELIMITER . 'level')
        ->setOrderByFieldAsc($alias . '.lkey');

        if ($this->tree_id) {
            $criteria->addSelectField($alias . '.' . $this->params['treeIdField'], $alias . simpleMapper::TABLE_KEY_DELIMITER . 'tree_id');
        }
    }

    /**
     * Получение информации об узле
     *
     * @param simpleForTree|integer $id
     * @return unknown
     */
    public function getNodeInfo($id)
    {
        if (is_null($id)) {
            throw new mzzRuntimeException('Узел не найден');
        }

        if ($id instanceof simpleForTree) {
            $id = $id->getTreeKey();
        }

        $criteria = new criteria($this->params['tableName'], 'tree');

        $criteria->add('tree.id', $id);

        $this->addSelect($criteria);

        $select = new simpleSelect($criteria);
        $row = $this->db->getAll($select->toString());

        return $this->createItemFromRow($row[0]);
    }

    /**
     * Выборка из массива с данными лишь данных, относящихся к структуре
     *
     * @param array $row
     * @return array
     */
    public function createItemFromRow($row)
    {
        $row = $this->mapper->fillArray($row, 'tree');

        $res = array('id' => $row['id'], 'lkey' => $row['lkey'], 'rkey' => $row['rkey'], 'level' => $row['level']);

        if ($this->tree_id) {
            $res['tree_id'] = $row['tree_id'];
        }

        return $res;
    }

    /**
     * Получение ветви дерева
     *
     * @param criteria $criteria
     * @param simpleForTree $id
     * @param integer $level
     */
    public function getBranch(criteria $criteria, simpleForTree $id, $level = 0)
    {
        $node = $this->getNodeInfo($id);

        $criteria->add('tree.lkey', $node['lkey'], criteria::GREATER_EQUAL);
        $criteria->add('tree.rkey', $node['rkey'], criteria::LESS_EQUAL);
        if ($level > 0) {
            $criteria->add('tree.level', $node['level'] + $level, criteria::LESS_EQUAL);
        }
    }

    /**
     * Получение родительской ветки
     *
     * @param criteria $criteria
     * @param simpleForTree $node
     */
    public function getParentBranch(criteria $criteria, simpleForTree $node)
    {
        $node = $this->getNodeInfo($node);

        $criteria->add('tree.lkey', $node['lkey'], criteria::LESS_EQUAL);
        $criteria->add('tree.rkey', $node['rkey'], criteria::GREATER_EQUAL);
    }

    /**
     * Получение родительского узла
     *
     * @param criteria $criteria
     * @param simpleForTree $id
     */
    public function getParentNode(criteria $criteria, simpleForTree $id)
    {
        $node = $this->getNodeInfo($id);

        $criteria->add('tree.lkey', $node['lkey'], criteria::LESS);
        $criteria->add('tree.rkey', $node['rkey'], criteria::GREATER);
        $criteria->add('tree.level', $node['level'] - 1);
    }

    /**
     * Вставка узла
     *
     * @param simpleForTree $id
     * @return integer id добавленной записи
     */
    public function insert(simpleForTree $id)
    {
        $node = $this->getNodeInfo($id);
        $qry = 'UPDATE `' . $this->params['tableName'] . '` SET rkey = rkey + 2, lkey = IF(lkey > ' . $node['rkey'] . ', lkey + 2, lkey) WHERE rkey >= ' . $node['rkey'];
        $this->addMultitreeWhereCond($qry);
        $this->db->query($qry);
        $qry = 'INSERT INTO `' . $this->params['tableName'] . '` SET lkey = ' . $node['rkey'] . ', rkey = ' . $node['rkey'] . ' + 1, level = ' . $node['level'] . ' + 1';
        if ($this->tree_id) {
            $qry .= ', ' . $this->params['treeIdField'] . ' = ' . $this->tree_id;
        }
        $this->db->query($qry);

        return $this->db->lastInsertId();
    }

    public function addMultitreeWhereCond(&$qry)
    {
        if ($this->tree_id) {
            $qry .= ' AND ' . $this->params['treeIdField'] . ' = ' . $this->tree_id;
        }
    }

    /**
     * Перемещение узла
     *
     * @param simpleForTree $node
     * @param simpleForTree $target
     * @return boolean
     */
    public function move(simpleForTree $node, simpleForTree $target)
    {
        $target = $this->getNodeInfo($target);
        $node = $this->getNodeInfo($node);

        if ($node['lkey'] <= $target['lkey'] && $node['rkey'] >= $target['rkey']) {
            throw new mzzRuntimeException('Невозможно перенести узел во вложенную ветку');
        }

        $skew_tree = $node['rkey'] - $node['lkey'] + 1;
        $skew_level = $target['level'] - $node['level'] + 1;

        $rkey_near = $target['rkey'] - 1;

        $skew_edit = $rkey_near - $node['lkey'] + 1;

        if ($node['rkey'] > $rkey_near) {
            $qry = 'SELECT `id` FROM `' . $this->params['tableName'] . '` WHERE lkey >= ' . $node['lkey'] . ' AND rkey <= ' . $node['rkey'];
            if ($this->tree_id) {
                $qry .= ' AND ' . $this->params['treeIdField'] . ' = ' . $this->tree_id;
            }

            $id_edit = '';
            foreach ($this->db->getAll($qry) as $val) {
                $id_edit .= $val['id'] . ', ';
            }
            $id_edit = substr($id_edit, 0, -2);

            $qry = 'UPDATE `' . $this->params['tableName'] . '` SET rkey = rkey + ' . $skew_tree . ' WHERE rkey < ' . $node['lkey'] . ' AND rkey > ' . $rkey_near;
            $this->addMultitreeWhereCond($qry);
            $this->db->query($qry);

            $qry = 'UPDATE `' . $this->params['tableName'] . '` SET lkey = lkey + ' . $skew_tree . ' WHERE lkey < ' . $node['lkey'] . ' AND lkey > ' . $rkey_near;
            $this->addMultitreeWhereCond($qry);
            $this->db->query($qry);

            $qry = 'UPDATE `' . $this->params['tableName'] . '` SET lkey = lkey + ' . $skew_edit . ', rkey = rkey + ' . $skew_edit . ', level = level + ' . $skew_level . ' WHERE id IN (' . $id_edit . ')';
            $this->addMultitreeWhereCond($qry);
            $this->db->query($qry);
        } else {
            $skew_edit -= $skew_tree;

            $qry = 'UPDATE `' . $this->params['tableName'] . '`
                    SET `lkey` = IF(`rkey` <= ' . $node['rkey'] . ', `lkey` + ' . $skew_edit . ', IF(`lkey` > ' . $node['rkey'] . ' , `lkey` - ' . $skew_tree . ', `lkey`)),
                    `level` = IF(`rkey` <= ' . $node['rkey'] . ', `level` + ' . $skew_level . ', `level`), `rkey` = IF(`rkey` <= ' . $node['rkey'] . ', `rkey` + ' . $skew_edit . ',
                    IF(`rkey` <= ' . $rkey_near . ', `rkey` - ' . $skew_tree . ', `rkey`)) WHERE `rkey` > ' . $node['lkey'] . ' AND `lkey` <= ' . $rkey_near;
            $this->addMultitreeWhereCond($qry);
            $this->db->query($qry);
        }

        return true;
    }

    /**
     * Удаление узла
     *
     * @param simpleForTree $id
     */
    public function delete(simpleForTree $id)
    {
        $node = $this->getNodeInfo($id);
        $qry = 'DELETE FROM `' . $this->params['tableName'] . '` WHERE lkey >= ' . $node['lkey'] . ' AND rkey <= ' . $node['rkey'];
        $this->addMultitreeWhereCond($qry);
        $this->db->query($qry);
        $diff = $node['rkey'] - $node['lkey'] + 1;
        $qry = 'UPDATE `' . $this->params['tableName'] . '` SET lkey = IF(lkey > ' . $node['lkey'] . ', lkey - ' . $diff  . ', lkey), rkey = rkey - ' . $diff . ' WHERE rkey > ' . $node['rkey'];
        $this->addMultitreeWhereCond($qry);
        $this->db->query($qry);
    }
}

?>