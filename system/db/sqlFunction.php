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
 * sqlFunction: SQL-функция
 *
 * @package system
 * @subpackage db
 * @version 0.2.1
*/

class sqlFunction
{
    /**
     * Имя функции
     */
    protected $function = null;

    /**
     * Аргументы
     */
    protected $arguments = null;

    /**
     * Поле, определяющее является 2ой аргумент полем или строковой константой
     *
     * @var boolean
     */
    protected $isField = false;

    /**
     * Объект класса simpleSelect, через который происходит экранирование полей, таблиц, алиасов и значений
     *
     * @var simpleSelect
     */
    protected $simpleSelect;

    /**
     * Аргументы
     *
     * @var string
     */
    protected $argumentsString = '';

    /**
     * Ресурс БД
     *
     * @var object
     */
    protected $db;

    /**
     * Конструктор
     *
     * @param string $function имя функции
     * @param mixed $arguments аргументы, возможна передача массива и объектов sqlFunction
     * @param bool $isField является ли аргумент полем
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
     * Возвращает sql функцию
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
     * Получение аргументов функции
     *
     * @return string|array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Возвращает поля функции и имя функции, объединённые знаком "_"
     *
     * @return string|null
     * @toDo в совокупности с criteria 380 что выдавать надо?
     */
    public function getFieldName()
    {
        $name = $this->function;

        if (is_array($this->arguments)) {
            foreach ($this->arguments as $argument) {
                if ($argument instanceof sqlFunction || $argument instanceof sqlOperator) {
                    $name .= '_' . implode('_', $argument->getArguments());
                } else {
                    $name .= '_' . $argument;
                }
            }
        } else {
            $name .= '_' . $this->arguments;
        }

        return $name;
    }

    /**
     * Обрамляет значение в кавычки если оно не null, число или число с
     * плавающей точкой
     *
     * @param mixed $value значение аргумента
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