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
 * critera: �����, ������������ ��� �������� ������ � ��������� �������
 *
 * @package system
 * @subpackage db
 * @version 0.1.3
 */

fileLoader::load('db/criterion');

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
     * ������ ��� �������� �������������� � �������� ������
     *
     * @var array
     */
    private $joins = array();

    /**
     * ��� �������� �������
     *
     * @var string
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
     * ����, ���������� � ������ ����������� ��������� ����� ��� �������� ����� ��������� ������� ��� ����� ��������� LIMIT<br>
     * mysql only. �������������� � ��������
     *
     * @deprecated
     * @var boolean
     */
    private $enableCount = false;

    /**
     * �����������
     *
     * @param string $table ��� �������� �������, �� ������� ����� ������������� �������
     */
    public function __construct($table = null)
    {
        if ($table) {
            $this->setTable($table);
        }
    }

    /**
     * ��������� ����� �������� �������
     *
     * @param string $table
     * @return object ��� ������
     */
    public function setTable($table)
    {
        $this->table = $table;
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
     * @return object ��� ������
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
            $this->orderBy = $orderBy;
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
     * @return object ��� ������
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
     * @return object ��� ������
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

        $pre = '`' . $this->getTable() . '`.';

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
     * ����� ��������� �����, ������������, ��� � ������ ����� �������� ��������� ����� ��� �������� �������
     * ��������� mysql only ���� - �������������� � ��������
     *
     * @deprecated
     * @return unknown
     */
    public function enableCount()
    {
        $this->enableCount = true;
        return $this;
    }

    /**
     * ����� ��������� ����� �������� �������
     *
     * @see  criterioa::enableCount()
     * @deprecated
     * @return unknown
     */
    public function getEnableCount()
    {
        return $this->enableCount;
    }

    /**
     * ����� ��� ������� ������ ����� ��� �������
     *
     * @return object ��� ������
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
     * @return object ��� ������
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
     */
    public function addJoin($tablename, criterion $criterion, $alias = '')
    {
        $arr = array('table' => '`' . $tablename . '`', 'criterion' => $criterion);
        if ($alias) {
            $arr['alias'] = '`' . $alias . '`';
        }
        $this->joins[] = $arr;

        return $this;
    }
}

?>