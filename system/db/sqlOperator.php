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
 * @version 0.2
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
     * Доступные операторы
     *
     * @var array
     */
    protected $validOperators = array('+', '-', '*', '/', '%', 'DIV', 'MOD', 'INTERVAL', 'DISTINCT', '<', '>', '=', '!=', '<=', '>=');

    /**
     * Операторы, у которых операнды находятся лишь справа
     * true значит, что значения операндов необходимо приводить к нужному типу, false - оставить как есть
     *
     * @var array
     */
    protected $leftSideOperators = array('INTERVAL' => false, 'DISTINCT' => true);

    /**
     * Объект класса simpleSelect, через который происходит экранирование полей, таблиц, алиасов и значений
     *
     * @var simpleSelect
     */
    private $simpleSelect;

    /**
     * Конструктор
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
     * Возвращает готовый оператор с операндами
     *
     * @return string
     */
    public function toString($simpleSelect)
    {
        $this->simpleSelect = $simpleSelect;

        if (!in_array($this->operator, $this->validOperators)) {
            throw new mzzInvalidParameterException('Некорректное значение оператора', $this->operator);
        }

        if (isset($this->leftSideOperators[$this->operator])) {
            $arg = $this->leftSideOperators[$this->operator] ? $this->cast($this->arguments[0]) : $this->arguments[0];
            return $this->operator . ' ' . $arg;
        }

        $args = array_map(array($this, 'cast'), $this->arguments);
        return implode(' ' . $this->operator . ' ', $args);
    }

    /**
     * Получение аргументов оператора
     *
     * @return string|array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Необходимая нормализация операндов
     *
     * @param string|object $arg
     * @return string
     */
    private function cast($arg)
    {
        if ($arg instanceof sqlOperator) {
            $arg = $this->setPriority($arg->toString($this->simpleSelect));
        } elseif($arg instanceof sqlFunction) {
            $arg = $arg->toString($this->simpleSelect);
        } else if (!is_numeric($arg)) {
            $arg = $this->simpleSelect->quoteField($arg);
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
        if (in_array($this->operator, array('*', '/', '-', 'DIV', 'MOD', '<', '>', '=', '!=', '<=', '>='))) {
            $arg = '(' . $arg . ')';
        }

        return $arg;
    }

    public function getFieldName()
    {
        $name = 'op_' . $this->operator;

        foreach ($this->arguments as $key => $argument) {
            if ($argument instanceof sqlFunction || $argument instanceof sqlOperator) {
                $name .= '_' . implode('_', $argument->getArguments());
            } else {
                $name .= '_' . (is_int($key) ? '' :  $key . '_') . $argument;
            }
        }

        return $name;
    }
}

?>