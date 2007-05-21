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

fileLoader::load('db/criterion');

/**
 * critera: �����, ������������ ��� �������� ������ � ��������� �������
 *
 * @package system
 * @subpackage db
 * @version 0.1.11
 */

class criteria
{
    /**
     * ���������, ������������ ��� ��������� "=" (�����)
     *
     */
    const EQUAL = "=";

    /**
     * ���������, ������������ ��� ��������� "<>" (�� �����)
     *
     */
    const NOT_EQUAL = '<>';

    /**
     * ���������, ������������ ��� ��������� ">" (������)
     *
     */
    const GREATER = '>';

    /**
     * ���������, ������������ ��� ��������� "<" (������)
     *
     */
    const LESS = '<';

    /**
     * ���������, ������������ ��� ��������� ">=" (������ ���� �����)
     *
     */
    const GREATER_EQUAL = '>=';

    /**
     * ���������, ������������ ��� ��������� "<=" (������ ���� �����)
     *
     */
    const LESS_EQUAL = '<=';

    /**
     * ���������, ������������ �������� "IN"
     *
     */
    const IN = 'IN';

    /**
     * ���������, ������������ �������� "IN"
     *
     */
    const NOT_IN = 'NOT IN';

    /**
     * ���������, ������������ �������� "LIKE"
     *
     */
    const LIKE = 'LIKE';

    /**
     * ���������, ������������ �������� "BETWEEN"
     *
     */
    const BETWEEN = 'BETWEEN';

    /**
     * ���������, ������������ �������� "NOT BETWEEN"
     *
     */
    const NOT_BETWEEN = 'NOT BETWEEN';

    /**
     * ���������, ������������ ����������� ��� ��������������� ������
     *
     */
    const FULLTEXT = 'MATCH (%s) AGAINST (%s)';

    /**
     * ���������, ������������ ��������� "IS NULL"
     *
     */
    const IS_NULL = 'IS NULL';

    /**
     * ���������, ������������ ��������� "IS NOT NULL"
     *
     */
    const IS_NOT_NULL = 'IS NOT NULL';

    /**
     * ���������, ������������ ��� ����������� INNER
     *
     */
    const JOIN_INNER = 'INNER';

    /**
     * ���������, ������������ ��� ����������� LEFT
     *
     */
    const JOIN_LEFT = 'LEFT';

    /**
     * ������ ��� �������� �������������� � �������� ������
     *
     * @var array
     */
    private $joins = array();

    /**
     * ��� �������� �������
     *
     * @var string|array
     */
    private $table;

    /**
     * ������ � ������� �������� ������ �� �������� �������
     *
     * @var array
     */
    private $map = array();

    /**
     * ������ ��� �������� ������ ���������� �������
     *
     * @var array
     */
    private $orderBy = array();

    private $orderBySettings = array();

    /**
     * ������ ��� �������� ����� ��� �����������
     *
     * @var array
     */
    private $groupBy = array();

    /**
     * ������ ��� �������� ��� ����� ��� �������
     *
     * @var array
     */
    private $selectFields = array();

    /**
     * ������ ��� �������� ������� � ���������� �����
     *
     * @var array
     */
    private $selectFieldsAliases = array();

    /**
     * ����� ������� ��� �������
     *
     * @var integer
     */
    private $limit = 0;

    /**
     * ��������, ������� � ������� ����� ���������� �������
     *
     * @var integer
     */
    private $offset = 0;

    /**
     * ����, ����������� DISTINCT � ������
     *
     * @var boolean
     */
    private $distinct = false;

    /**
     * �����������
     *
     * @param string $table ��� �������� �������, �� ������� ����� ������������� �������
     */
    public function __construct($table = null, $alias = null)
    {
        if ($table) {
            $this->setTable($table, $alias);
        }
    }

    /**
     * ��������� ����� �������� �������
     *
     * @param string $table
     * @param string $alias �����, ������� ����� �������� �������
     * @return criteria ������� ������
     */
    public function setTable($table, $alias = null)
    {
        if (!empty($alias)) {
            $this->table = array('table' => $table, 'alias' => $alias);
        } else {
            $this->table = $table;
        }
        return $this;
    }

    /**
     * ��������� ����� �������� �������
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * ����� ��� ���������� ��� ������ ������� �������
     *
     * @see criterion
     * @param string|object $field ��� ���� ��� ������ ������ criterion
     * @param string $value ��������. �� ������������ ���� � �������� $field ��������� criterion
     * @param string $comparsion ��� ���������. �� ������������ ���� � �������� $field ��������� criterion
     * @return criteria ������� ������
     */
    public function add($field, $value = null, $comparsion = null)
    {
        if ($field instanceof criterion) {
            if (!is_null($field->getField())) {
                $this->map[$field->getField()] = $field;
            } else {
                $this->map[] = $field;
            }
        } else {
            $this->map[$field] = new criterion($field, $value, $comparsion);
        }

        return $this;
    }

    /**
     * ����� ��� ���������� ������ �� ������������� ������� criteria � ��������<br>
     * ����� ������ �����������, ����� ����������
     *
     * @param criteria $criteria
     */
    public function append(criteria $criteria)
    {
        if ($selectFields = $criteria->getSelectFields()) {
            $this->selectFields = array_merge($this->selectFields, $selectFields);
        }

        if ($aliases = $criteria->getSelectFieldAlias()) {
            $this->selectFieldsAliases = array_merge($this->selectFieldsAliases, $aliases);
        }

        if ($joins = $criteria->getJoins()) {
            $this->joins = array_merge($this->joins, $joins);
        }

        if ($map = $criteria->getCriterion()) {
            $this->map = array_merge($this->map, $map);
        }

        if ($limit = $criteria->getLimit()) {
            $this->limit = $limit;
        }

        if ($offset = $criteria->getOffset()) {
            $this->offset = $offset;
        }

        if ($orderBy = $criteria->getOrderByFields()) {
            $this->orderBy = array_merge($this->orderBy, $orderBy);
        }

        if ($orderBySettings = $criteria->getOrderBySettings()) {
            $this->orderBySettings = array_merge($this->orderBySettings, $orderBySettings);
        }

        if ($groupBy = $criteria->getGroupBy()) {
            $this->groupBy = array_merge($this->groupBy, $groupBy);
        }
    }

    /**
     * ����� ��� ��������� ��� �����
     *
     * @return array
     */
    public function keys()
    {
        return array_keys($this->map);
    }

    /**
     * ����� �������� ������ �� ��������� �������
     *
     * @param ��� ����� $key
     * @return criteria ������� ������
     */
    public function remove($key)
    {
        unset($this->map[$key]);
        return $this;
    }

    /**
     * ����� ��������� ����������� ������� criterion �� ����� �����
     *
     * @param string $key ��� �����
     * @return object|null ������� ������, ���� null � ��������� ������
     */
    public function getCriterion($key = null)
    {
        if (isset($this->map[$key])) {
            return $this->map[$key];
        }
        return $this->map;
    }

    /**
     * ��������� ���� �� �������� ����� ������������� ���������� �������. ����������� ASC
     *
     * @param string $field ��� ����
     * @param boolean $alias
     * @return criteria ������� ������
     */
    public function setOrderByFieldAsc($field, $alias = true)
    {
        $this->setOrderBy($field, 'ASC', $alias);
        return $this;
    }

    /**
     * ��������� ���� �� �������� ����� ������������� ���������� �������. ����������� DESC
     *
     * @param string $field ��� ����
     * @param boolean $alias
     * @return criteria ������� ������
     */
    public function setOrderByFieldDesc($field, $alias = true)
    {
        $this->setOrderBy($field, 'DESC', $alias);
        return $this;
    }

    /**
     * ��������� ���� �� �������� ����� ������������ ����������
     *
     * @param string $field
     * @param string $direction
     * @param boolean $alias
     */
    private function setOrderBy($field, $direction, $alias)
    {
        if ($field instanceof sqlFunction) {
            $field = $field->toString() . ' ';
        } else {
            $field = '`' . str_replace('.', '`.`', $field) . '` ';
        }
        $this->orderBy[] = $field . $direction;
        $this->setOrderBySetting($alias);
    }

    protected function getOrderBySettings()
    {
        return $this->orderBySettings;
    }

    /**
     * ��������� ����� ��� ����������
     *
     * @param string $alias
     */
    private function setOrderBySetting($alias)
    {
        $this->orderBySettings[] = array('alias' => $alias);
    }

    /**
     * ����� ��������� �����, �� ������� ������������ ����������
     *
     * @return array
     */
    public function getOrderByFields()
    {
        $result = array();

        $table = $this->getTable();
        if (is_array($table) && isset($table['alias'])) {
            $table = $table['alias'];
        }

        $pre = '`' . $table . '`.';

        if ($pre != '``.') {
            foreach ($this->orderBy as $key => $val) {
                $result[] = (strpos($val, '.') === false && (!isset($this->orderBySettings[$key]['alias']) || $this->orderBySettings[$key]['alias'] == true)) ? $pre . $val : $val;
            }
        } else {
            return $this->orderBy;
        }

        return $result;
    }

    /**
     * ����� ��������� ������ � ����� ���������� �������
     *
     * @return integer
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * ����� ��������� ������ � ������
     *
     * @return integer
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * ����� ��� ��������� ����� ���������� �������
     *
     * @param integer $limit
     * @return object ��� ������
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * ����� ��������� ������
     *
     * @param integer $offset
     * @return object ��� ������
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * ����� ������� ����� ���������� �������
     *
     * @return object ��� ������
     */
    public function clearLimit()
    {
        $this->limit = 0;
        return $this;
    }

    /**
     * ����� ������� ������
     *
     * @return object ��� ������
     */
    public function clearOffset()
    {
        $this->offset = 0;
        return $this;
    }

    /**
     * ����� ��� ������� ������ ����� ��� �������
     *
     * @return criteria ������� ������
     */
    public function clearSelectFields()
    {
        $this->selectFields = array();
        return $this;
    }

    /**
     * ����� ���������� ����� ��� �������
     *
     * @param string $field ��� ����
     * @param string $alias �����, ������� ����� �������� ����������� ����
     * @return criteria ������� ������
     */
    public function addSelectField($field, $alias = null)
    {
        if ($field instanceof sqlFunction) {
            $this->selectFieldsAliases[$field->getFieldName()] = $alias;
        } else {
            $this->selectFieldsAliases[$field] = $alias;
        }
        $this->selectFields[] = $field;
        return $this;
    }

    /**
     * ����� ��������� ������ ���������� �����
     *
     * @return array
     */
    public function getSelectFields()
    {
        return $this->selectFields;
    }

    /**
     * ����� ��������� ������ ������� ��� ����������� ����
     *
     * @param string $field
     * @return string|null ������� �����, ���� null ���� ����� �� ������
     */
    public function getSelectFieldAlias($field = null)
    {
        if ($field) {
            $name = ($field instanceof sqlFunction) ? $field->getFieldName() : $field;
            return isset($this->selectFieldsAliases[$name]) ? $this->selectFieldsAliases[$name] : null;
        }

        return $this->selectFieldsAliases;
    }

    /**
     * ����� ��������� ������ � ������� ��� �����������
     *
     * @return array
     */
    public function getJoins()
    {
        return $this->joins;
    }

    /**
     * ����� ��� ���������� ������ �����������
     *
     * @param string $tablename ��� �������
     * @param criterion $criterion ������� �����������
     * @param string $alias �����, ������� ����� �������� �������������� �������
     * @param string $joinType ��� �����������
     * @return criteria ������� ������
     */
    public function addJoin($tablename, criterion $criterion, $alias = '', $joinType = self::JOIN_LEFT)
    {
        $arr = array('table' => $tablename, 'criterion' => $criterion);
        $arr['type'] = $joinType;
        if ($alias) {
            $arr['alias'] = '`' . $alias . '`';
        }
        $this->joins[] = $arr;

        return $this;
    }

    /**
     * ����� ��� ���������� ������ ���� ��� �����������
     *
     * @param string $field ��� ����
     * @return criteria ������� ������
     */
    public function addGroupBy($field)
    {
        $field = '`' . str_replace('.', '`.`', $field) . '`';
        $this->groupBy[] = $field;
        return $this;
    }

    /**
     * ����� ��������� ����� ��� �����������
     *
     * @return array
     */
    public function getGroupBy()
    {
        return $this->groupBy;
    }

    /**
     * ������� ������ ����� ��� �����������
     *
     * @return criteria ������� ������
     */
    public function clearGroupBy()
    {
        $this->groupBy = array();
        return $this;
    }

    /**
     * ��������� �������� ����� distinct
     *
     * @return boolean
     */
    public function getDistinct()
    {
        return $this->distinct;
    }

    /**
     * ��������� �������� ����� distinct
     *
     * @param boolean $value
     */
    public function setDistinct($value = true)
    {
        $this->distinct = (bool)$value;
    }
}

?>