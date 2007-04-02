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
 * criterion: �����, �������� ���������� � �������� ���������������
 * �������� "���������" �� ��������� � ������ criteria
 *
 * @see criteria
 * @package system
 * @subpackage db
 * @version 0.1.4
 */

class criterion
{
    /**
     * ���������, ������������ ���������� �������� "���" � ���������� SQL
     *
     */
    const C_OR = 'OR';

    /**
     * ���������, ������������ ���������� �������� "�" � ���������� SQL
     *
     */
    const C_AND = 'AND';

    /**
     * ��� �������, ������� ����� ����������� ��� ������� ��������� criterion'�. ������������ � ������ generate
     *
     * @see criterion::generate()
     * @var string
     */
    private $defaultTable;

    /**
     * �����<br>
     * ����������� ������������� �� ����� ���� - ��� ����� ���� �� ������� ����� "." (�����)
     *
     * @var string
     */
    private $alias;

    /**
     * ����, ������������ ��� ������ �������� ������������ $value �������� ����� �����, � �� ������ ��������� ����������<br>
     * ��������� ����� � true � ���������� ������� � ����, ��� ������ ������� ����� ������� � "`" (�������� �������, back tick) � � ���� ����� �������� �����, ���� ������� �������
     *
     * @see criterion::__construct()
     * @var boolean
     */
    private $isField;

    /**
     * ��� ����
     *
     * @var string
     */
    private $field;

    /**
     * �������� ����
     *
     * @var string
     */
    private $value;

    /**
     * ��� ���������<br>
     * ��� ���� ���������� ����������� ������ criteria
     *
     * @see criteria
     * @var string
     */
    private $comparsion;

    /**
     * ����� ��� �������� ������� ������ � ��
     *
     * @var object
     */
    private $db;

    /**
     * ������, �������� �������������� �������� ���������
     *
     * @var array
     */
    private $clauses = array();

    /**
     * �������� �� �������� ���������� sqlFunction
     *
     * @var boolean
     */
    private $isFunction = false;

    /**
     * ������, �������� ���� ���������� ����������� (�/���) ����� ��������������� ���������� ���������
     *
     * @var array
     */
    private $conjunctions = array();

    /**
     * �����������
     *
     * @see criteria
     * @see criterion::getQuotedValue()
     * @param string $field ��� ����
     * @param string $value ��������
     * @param string $comparsion ��� ���������
     * @param boolean $isField ����, ������������, ��� $value - ��� ��� ����, � �� ��������� ���������
     */
    public function __construct($field = null, $value = null, $comparsion = null, $isField = null)
    {
        $this->db = db::factory();
        if (($dotpos = strpos($field, '.')) !== false) {
            $this->alias = substr($field, 0, $dotpos);
            $this->field = substr($field, $dotpos + 1);
        } else {
            $this->field = $field;
        }
        $this->isField = $isField;
        $this->value = $value;
        $this->comparsion = !empty($comparsion) ? $comparsion : criteria::EQUAL;
    }

    /**
     * �����, �� ������ �������� �� ������ ������������ ����� �������
     *
     * @param string|array $defaultTable ��� �������, ������� ����� �����������, ���� ����� �� ��������
     * @return string
     */
    public function generate($defaultTable = '')
    {
        $this->defaultTable = $defaultTable;

        $result = '';

        if (($this->value instanceof sqlFunction) || ($this->value instanceof sqlOperator)) {
            $this->isFunction = true;
            $this->value = $this->value->toString();
        }

        if (!is_null($this->field)) {
            // ��� ����������� `field` IN ('val1', 'val2')
            if ($this->comparsion === criteria::IN || $this->comparsion === criteria::NOT_IN) {
                if (is_array($this->value) && sizeof($this->value)) {
                    $result .= $this->getQuoutedAlias() . '`' . $this->field . '` ' . $this->comparsion . ' (';
                    // ��� �������� ����� ��������� ��� � sizeof($this->value)
                    foreach ($this->value as $val) {
                        $result .= $this->db->quote($val) . ', ';
                    }
                    $result = substr($result, 0, -2);
                    $result .= ')';
                } else {
                    $result .= 'FALSE';
                }
            } elseif ($this->comparsion === criteria::IS_NULL || $this->comparsion === criteria::IS_NOT_NULL) {
                $result = $this->getQuoutedAlias() . '`' . $this->field . '` ' . $this->comparsion;
            } elseif ($this->comparsion === criteria::BETWEEN || $this->comparsion === criteria::NOT_BETWEEN) {
                $result = $this->getQuoutedAlias() . '`' . $this->field . '` ' . $this->comparsion . ' ' . $this->db->quote($this->value[0]) . ' AND ' . $this->db->quote($this->value[1]);
            } elseif ($this->comparsion === criteria::FULLTEXT) {
                $result = sprintf($this->comparsion, $this->getQuoutedAlias() . '`' . $this->field . '`', $this->db->quote($this->value));
            } else {
                $result = $this->getQuoutedAlias() . '`' . $this->field . '` ' . $this->comparsion . ' ' . $this->getQuotedValue();
            }
        }

        if (sizeof($this->conjunctions) > 0) {
            if (strlen($result)) {
                $result = '(' . $result . ')';
            }
            foreach ($this->conjunctions as $key => $val) {
                if ($val) {
                    $result .= ' ' . $val . ' ';
                }
                $result .= '(' . $this->clauses[$key]->generate($defaultTable) . ')';
            }
        }

        return $result;
    }

    /**
     * ����� ��� ���������� � �������� ������� criterion �������������� �������, ��������� ���������� ���������� �
     *
     * @param criterion $criterion
     * @return criterion ������� ������
     */
    public function addAnd(criterion $criterion)
    {
        $this->clauses[] = $criterion;
        $this->conjunctions[] = self::C_AND;
        return $this;
    }

    /**
     * ����� ��� ���������� � �������� ������� criterion �������������� �������, ��������� ���������� ���������� ���
     *
     * @param criterion $criterion
     * @return object ������� ������
     */
    public function addOr(criterion $criterion)
    {
        $this->clauses[] = $criterion;
        $this->conjunctions[] = self::C_OR;
        return $this;
    }

    /**
     * ����� ��� ���������� � �������� ������� criterion �������������� �������, �� ��������� ������� ���������� ����������
     *
     * @param criterion $criterion
     * @return criterion ������� ������
     */
    public function add(criterion $criterion)
    {
        $this->clauses[] = $criterion;
        $this->conjunctions[] = '';
        return $this;
    }

    /**
     * ����� ��� ��������� ����� ����
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * ����� ��� ��������� ������<br>
     * ����� ������������� ������������� ��� ������������
     *
     * @deprecated
     * @return string
     */
    public function getAlias()
    {
        throw new Exception('DEPRECATED');
        return $this->alias;
    }

    /**
     * ����� ��� ��������� ��������������� ������
     *
     * @return string
     */
    private function getQuoutedAlias()
    {
        if (!empty($this->alias)) {
            return '`' . $this->alias . '`.';
        } elseif (!empty($this->defaultTable)) {
            if (is_array($this->defaultTable) && isset($this->defaultTable['alias'])) {
                return '`' . $this->defaultTable['alias'] . '`.';
            } else {
                return '`' . $this->defaultTable . '`.';
            }
        }

        return '';
    }

    /**
     * ����� ��� ��������� ��������
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * ����� ��� ��������� ��������������� ��������<br>
     * ���� ���������� ���� isField - �� ������������ ��������������� ��� ���� � ����������� �������
     *
     * @return string
     */
    private function getQuotedValue()
    {
        if ($this->isFunction) {
            return $this->value;
        } elseif ($this->isField) {
            if (($dotpos = strpos($this->value, '.')) !== false) {
                $alias = substr($this->value, 0, $dotpos);
                $field = substr($this->value, $dotpos + 1);
                return '`' . $alias . '`.`' . $field . '`';
            }
            return '`' . $this->value . '`';
        } else {
            $value = $this->value;

            if (!is_int($value)) {
                $value = $this->db->quote($value);
            }

            return $value;
        }
    }
}

?>