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
 * @package system
 * @subpackage db
 * @version $Id$
*/

/**
 * sqlFunction: SQL-�������
 *
 * @package system
 * @subpackage db
 * @version 0.1.3
*/

class sqlFunction
{
    /**
     * ��� �������
     */
    protected $function = null;

    /**
     * ���������
     */
    protected $arguments = null;

    /**
     * ���������
     *
     * @var string
     */
    protected $argumentsString = '';

    /**
     * ������ ��
     *
     * @var object
     */
    protected $db;

    /**
     * �����������
     *
     * @param string $function ��� �������
     * @param mixed $arguments ���������, �������� �������� ������� � �������� sqlFunction
     * @param bool $isField �������� �� �������� �����
     */
    public function __construct($function, $arguments = null, $isField = false)
    {
        $this->db = DB::factory();
        $this->function = $function;

        if (!is_array($arguments) && ($arguments instanceof sqlFunction || $arguments instanceof sqlOperator)) {
            $arguments = array($arguments);
        }

        if(is_array($arguments)) {
            foreach ($arguments as $key => $arg) {
                if($arg !== true) {
                    if (($arg instanceof sqlFunction) || ($arg instanceof sqlOperator)) {
                        $this->argumentsString .= $arg->toString() . ', ';
                    } else {
                        $this->argumentsString .= $this->quote($arg) . ", ";
                    }
                } else {
                    $field = str_replace('.', '`.`', $key);
                    $this->argumentsString .= '`' . $field . '`, ';
                }
            }
        } elseif($arguments) {
            if($isField) {
                if ($arguments == '*') {
                    $this->argumentsString .= '*  ';
                } else {
                    $field = str_replace('.', '`.`', $arguments);
                    $this->argumentsString .= '`' . $field . '`, ';
                }
            } else {
                $this->argumentsString .= $this->quote($arguments) . ", ";
            }
        }

        $this->argumentsString = substr($this->argumentsString, 0, -2);
    }

    /**
     * ���������� sql �������
     *
     * @return string|null

     */
    public function toString()
    {
        if(!empty($this->function)) {
            return strtoupper($this->function) . '(' . $this->argumentsString . ')';
        }
        return null;
    }

    /**
     * ���������� ���� ������� � ��� �������, ����������� ������ "_"
     *
     * @return string|null
     * @toDo � ������������ � criteria 380 ��� �������� ����?
     */
    public function getFieldName()
    {
        return $this->function . '_' . $this->argumentsString;
    }

    /**
     * ��������� �������� � ������� ���� ��� �� null, ����� ��� ����� �
     * ��������� ������
     *
     * @param mixed $value �������� ���������
     * @return mixed
     */
    protected function quote($value)
    {
        if (is_integer($value) || is_float($value)) {
            return $value;
        } elseif (is_null($value)){
            return 'null';
        } else {
            return $this->db->quote($value);
        }
    }

}
?>