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
 * sqlOperator: SQL-оператор
 *
 * @package system
 * @subpackage db
 * @version 0.1
*/

class sqlOperator
{
    /**
     * Имя оператора
     *
     * @var string
     */
    private $operator;

    /**
     * Массив операндов
     *
     * @var array
     */
    private $arguments;

    /**
     * Конструктор
     *
     * @param string $operator
     * @param array $arguments
     */
    public function __construct($operator, $arguments)
    {
        if (!is_array($arguments)) {
            throw new mzzInvalidParameterException('Аргументы должны быть переданы в массиве', $arguments);
        }

        $this->operator = strtoupper($operator);
        $this->arguments = $arguments;
    }

    /**
     * Возвращает готовый оператор с операндами
     *
     * @return string
     */
    public function toString()
    {
        if (!in_array($this->operator, array('+', '-', '*', '/', '%', 'DIV', 'MOD'))) {
            throw new mzzInvalidParameterException('Некорректное значение оператора', $this->operator);
        }

        $args = array_map(array($this, 'cast'), $this->arguments);
        return implode(' ' . $this->operator . ' ', $args);
    }

    /**
     * Необходимая нормализация операндов
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
        } else {
            $arg = '`' . str_replace('.', '`.`', $arg) . '`';
        }

        return $arg;
    }

    /**
     * Установка скобок для верного определения приоритетов операций
     *
     * @param string $arg
     * @return string
     */
    private function setPriority($arg)
    {
        if (in_array($this->operator, array('*', '/'))) {
            $arg = '(' . $arg . ')';
        }

        return $arg;
    }
}

?>