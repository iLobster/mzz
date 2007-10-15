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
 * sqlOperator: SQL-��������
 *
 * @package system
 * @subpackage db
 * @version 0.1.3
*/

class sqlOperator
{
    /**
     * ��� ���������
     *
     * @var string
     */
    private $operator;

    /**
     * ������ ���������
     *
     * @var array
     */
    private $arguments;

    /**
     * ��������� ���������
     *
     * @var array
     */
    protected $validOperators = array('+', '-', '*', '/', '%', 'DIV', 'MOD', 'INTERVAL', 'DISTINCT');

    /**
     * ���������, � ������� �������� ��������� ���� ������
     * true ������, ��� �������� ��������� ���������� ��������� � ������� ����, false - �������� ��� ����
     *
     * @var array
     */
    protected $leftSideOperators = array('INTERVAL' => false, 'DISTINCT' => true);

    /**
     * �����������
     *
     * @param string $operator
     * @param array $arguments
     */
    public function __construct($operator, $arguments)
    {
        if (!is_array($arguments)) {
            $arguments = array($arguments);
        }

        $this->operator = strtoupper($operator);
        $this->arguments = $arguments;
    }

    /**
     * ���������� ������� �������� � ����������
     *
     * @return string
     */
    public function toString()
    {
        if (!in_array($this->operator, $this->validOperators)) {
            throw new mzzInvalidParameterException('������������ �������� ���������', $this->operator);
        }

        if (isset($this->leftSideOperators[$this->operator])) {
            $arg = $this->leftSideOperators[$this->operator] ? $this->cast($this->arguments[0]) : $this->arguments[0];
            return $this->operator . ' ' . $arg;
        }

        $args = array_map(array($this, 'cast'), $this->arguments);
        return implode(' ' . $this->operator . ' ', $args);
    }

    /**
     * ����������� ������������ ���������
     *
     * @param string|object $arg
     * @return string
     */
    private function cast($arg)
    {
        if (is_numeric($arg)) {
            $arg = (int)$arg;
        } elseif ($arg instanceof sqlOperator) {
            $arg = $this->setPriority($arg->toString());
        } elseif($arg instanceof sqlFunction) {
            $arg = $arg->toString();
        } else {
            $arg = '`' . str_replace('.', '`.`', $arg) . '`';
        }

        return $arg;
    }

    /**
     * ��������� ������ ��� ������� ����������� ����������� ��������
     *
     * @param string $arg
     * @return string
     */
    private function setPriority($arg)
    {
        if (in_array($this->operator, array('*', '/', '-'))) {
            $arg = '(' . $arg . ')';
        }

        return $arg;
    }
}

?>