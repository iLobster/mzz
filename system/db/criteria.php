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
 * @version 0.1.7
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
        if ($limit = $criteria->getLimit()) {
            $this->limit = $limit;
        }
        if ($offset = $criteria->getOffset()) {
            $this->offset = $offset;
        }
        if ($orderBy = $criteria->getOrderByFields()) {
            $this->orderBy += $orderBy;
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
    public function getCriterion($key)
    {
        if (isset($this->map[$key])) {
            return $this->map[$key];
        }
        return null;
    }

    /**
     * ��������� ���� �� �������� ����� ������������� ���������� �������. ����������� ASC
     *
     * @param string $field ��� ����
     * @return criteria ������� ������
     */
    public function setOrderByFieldAsc($field)
    {
        $field = str_replace('.', '`.`', $field);
        $this->orderBy[] = '`' . $field . '` ASC';
        return $this;
    }

    /**
     * ��������� ���� �� �������� ����� ������������� ���������� �������. ����������� DESC
     *
     * @param string $field ��� ����
     * @return criteria ������� ������
     */
    public function setOrderByFieldDesc($field)
    {
        $field = str_replace('.', '`.`', $field);
        $this->orderBy[] = '`' . $field . '` DESC';
        return $this;
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
            foreach ($this->orderBy as $val) {
                $result[] = (strpos($val, '.') === false) ? $pre . $val : $val;
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
    public function getSelectFieldAlias($field)
    {
        $name = ($field instanceof sqlFunction) ? $field->getFieldName() : $field;
        return isset($this->selectFieldsAliases[$name]) ? $this->selectFieldsAliases[$name] : null;
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