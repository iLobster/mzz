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
 * criterion: �����, �������� ���������� � �������� ���������������
 * �������� "���������" �� ��������� � ������ criteria
 *
 * @see criteria
 * @package system
 * @subpackage db
 * @version 0.1.1
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
     * @param string $defaultTable ��� �������, ������� ����� �����������, ���� ����� �� ��������
     * @return string
     */
    public function generate($defaultTable = '')
    {
        $this->defaultTable = $defaultTable;

        $result = '';

        if (!is_null($this->field)) {
            // ��� ����������� `field` IN ('val1', 'val2')
            if ($this->comparsion === criteria::IN) {

                $result .= $this->getQuoutedAlias() . '`' . $this->field . '` ' . $this->comparsion . ' (';
                // ��� �������� ����� ��������� ��� � sizeof($this->value)
                foreach ($this->value as $val) {
                    $result .= $this->db->quote($val) . ', ';
                }
                $result = substr($result, 0, -2);
                $result .= ')';

            } elseif ($this->comparsion === criteria::BETWEEN) {
                $result .= $this->getQuoutedAlias() . '`' . $this->field . '` ' . $this->comparsion . ' ' . $this->db->quote($this->value[0]) . ' AND ' . $this->db->quote($this->value[1]);
            } else {
                $result .= $this->getQuoutedAlias() . '`' . $this->field . '` ' . $this->comparsion . ' ' . $this->getQuotedValue();
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
                $result .= '(' . $this->clauses[$key]->generate() . ')';
            }
        }

        return $result;
    }

    /**
     * ����� ��� ���������� � �������� ������� criterion �������������� �������, ��������� ���������� ���������� �
     *
     * @param object $criterion
     * @return object ������� ������
     */
    public function addAnd($criterion)
    {
        $this->clauses[] = $criterion;
        $this->conjunctions[] = self::C_AND;
        return $this;
    }

    /**
     * ����� ��� ���������� � �������� ������� criterion �������������� �������, ��������� ���������� ���������� ���
     *
     * @param object $criterion
     * @return object ������� ������
     */
    public function addOr($criterion)
    {
        $this->clauses[] = $criterion;
        $this->conjunctions[] = self::C_OR;
        return $this;
    }

    /**
     * ����� ��� ���������� � �������� ������� criterion �������������� �������, �� ��������� ������� ���������� ����������
     *
     * @param object $criterion
     * @return object ������� ������
     */
    public function add($criterion)
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
            return '`' . $this->defaultTable . '`.';
        }

        return '';
    }

    /**
     * ����� ��� ��������� �������� ��������
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
        if ($this->isField) {
            if (($dotpos = strpos($this->value, '.')) !== false) {
                $alias = substr($this->value, 0, $dotpos);
                $field = substr($this->value, $dotpos + 1);
                return '`' . $alias . '`.`' . $field . '`';
            }
            return '`' . $this->value . '`';
        } else {
            return  $this->db->quote($this->value);
        }
    }
}

?>