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
 * @version 0.2
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
     * ����, ������������ �������� 2�� �������� ����� ��� ��������� ����������
     *
     * @var boolean
     */
    protected $isField = false;

    /**
     * ������ ������ simpleSelect, ����� ������� ���������� ������������� �����, ������, ������� � ��������
     *
     * @var simpleSelect
     */
    protected $simpleSelect;

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
        $this->function = $function;

        if (!is_array($arguments) && ($arguments instanceof sqlFunction || $arguments instanceof sqlOperator)) {
            $arguments = array($arguments);
        }

        $this->arguments = $arguments;
        $this->isField = $isField;
    }

    /**
     * ���������� sql �������
     *
     * @return string|null

     */
    public function toString($simpleSelect)
    {
        $this->simpleSelect = $simpleSelect;

        $arguments = $this->arguments;
        $isField = $this->isField;

        if(is_array($arguments)) {
            foreach ($arguments as $key => $arg) {
                if($arg !== true) {
                    if (($arg instanceof sqlFunction) || ($arg instanceof sqlOperator)) {
                        $this->argumentsString .= $arg->toString($this->simpleSelect) . ', ';
                    } else {
                        $this->argumentsString .= $this->quote($arg) . ', ';
                    }
                } else {
                    $this->argumentsString .= $this->simpleSelect->quoteField($key) . ', ';
                }
            }
        } elseif($arguments) {
            if($isField) {
                if ($arguments == '*') {
                    $this->argumentsString .= '*  ';
                } else {
                    $this->argumentsString .= $this->simpleSelect->quoteField($arguments) . ', ';
                }
            } else {
                $this->argumentsString .= $this->quote($arguments) . ", ";
            }
        }

        $this->argumentsString = substr($this->argumentsString, 0, -2);


        if(!empty($this->function)) {
            return strtoupper($this->function) . '(' . $this->argumentsString . ')';
        }
        return null;
    }

    /**
     * ��������� ���������� �������
     *
     * @return string|array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * ���������� ���� ������� � ��� �������, ����������� ������ "_"
     *
     * @return string|null
     * @toDo � ������������ � criteria 380 ��� �������� ����?
     */
    public function getFieldName()
    {
        $name = $this->function;

        if (is_array($this->arguments)) {
            foreach ($this->arguments as $argument) {
                if ($argument instanceof sqlFunction || $argument instanceof sqlOperator) {
                    $name .= '_' . implode('_', $argument->getArguments());
                }
            }
        } else {
            $name .= '_' . $this->arguments;
        }

        return $name;
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
            return $this->simpleSelect->quote($value);
        }
    }
}

?>