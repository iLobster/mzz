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
 * criterion: класс, хранящий информацию о критерии непосредственно
 * является "вложенным" по отношению к классу criteria
 *
 * @see criteria
 * @package system
 * @subpackage db
 * @version 0.2.2
 */

class criterion
{
    /**
     * Константа, определяющая логическую операцию "ИЛИ" в синтаксисе SQL
     *
     */
    const C_OR = 'OR';

    /**
     * Константа, определяющая логическую операцию "И" в синтаксисе SQL
     *
     */
    const C_AND = 'AND';

    /**
     * Имя таблицы, которое будет подставлено для текущей инстанции criterion'а. Используется в методе generate
     *
     * @see criterion::generate()
     * @var string
     */
    private $defaultTable;
    
    /**
     * Имя алиаса, которое будет подставлено для текущей инстанции criterion'а. Используется в методе generate
     *
     * @see criterion::generate()
     * @var string
     */
    private $defaultAlias;

    /**
     * Алиас<br>
     * Извлекается автоматически из имени поля - как часть поля до первого знака "." (точка)
     *
     * @var string
     */
    private $alias;

    /**
     * Флаг, обозначающий что второй аргумент конструктора $value является также полем, а не просто строковой константой
     *
     * @see criterion::__construct()
     * @var boolean
     */
    private $isField;

    /**
     * Имя поля
     *
     * @var string
     */
    private $field;

    /**
     * Значение поля
     *
     * @var string
     */
    private $value;

    /**
     * Тип сравнения<br>
     * Все типы определены константами класса criteria
     *
     * @see criteria
     * @var string
     */
    private $comparsion;

    /**
     * Объект класса simpleSelect, через который происходит экранирование полей, таблиц, алиасов и значений
     *
     * @var simpleSelect
     */
    private $simpleSelect;

    /**
     * Массив, хранящий дополнительные операции сравнения
     *
     * @var array
     */
    private $clauses = array();

    /**
     * Является ли значение инстанцией sqlFunction
     *
     * @var boolean
     */
    private $isFunction = false;

    /**
     * Является ли первый аргумент (поле) функцией или оператором
     *
     * @var boolean
     */
    private $fieldIsFunction = false;

    /**
     * Массив, хранящий типы логических объединений (И/ИЛИ) между дополнительными операциями сравнения
     *
     * @var array
     */
    private $conjunctions = array();

    /**
     * Присутствуют ли в критерионе условия, объёдиненные через OR (требуют дополнительных скобок в результате)
     *
     * @var boolean
     */
    private $hasOr = false;

    /**
     * Конструктор
     *
     * @see criteria
     * @see criterion::getQuotedValue()
     * @param string $field имя поля
     * @param string $value значение
     * @param string $comparsion тип сравнения
     * @param boolean $isField флаг, обозначающий, что $value - это имя поля, а не строковая константа
     */
    public function __construct($field = null, $value = null, $comparsion = criteria::EQUAL, $isField = null)
    {
        list($this->field, $this->alias) = $this->splitNameAndAlias($field);

        $this->isField = $isField;
        $this->value = $value;
        $this->comparsion = $comparsion;
    }

    /**
     * Разделение на алиас и имя
     *
     * @param string $name
     * @return array
     */
    private function splitNameAndAlias($name)
    {
        $alias = null;

        if (is_string($name) && ($dotpos = strpos($name, '.')) !== false) {
            $alias = substr($name, 0, $dotpos);
            $name = substr($name, $dotpos + 1);
        }

        return array($name, $alias);
    }

    /**
     * Метод, по вызову которого из данных генерируется часть запроса
     *
     * @param string $simpleSelect
     * @param string [$defaultTable] имя таблицы, которое будет подставлено, если алиас не определён
     * @param string [$defaultAlias] алиас таблицы, которое будет подставлено, если алиас не определён
     * @return string
     */
    public function generate($simpleSelect, $defaultTable = '', $defaultAlias = '')
    {
        $this->simpleSelect = $simpleSelect;

        $this->defaultTable = $defaultTable;
        $this->defaultAlias = $defaultAlias;

        $result = '';

        if (($this->value instanceof sqlFunction) || ($this->value instanceof sqlOperator)) {
            $this->isFunction = true;
            $this->value = $this->value->toString($this->simpleSelect);
        }

        if (($this->field instanceof sqlFunction) || ($this->field instanceof sqlOperator)) {
            $this->fieldIsFunction = true;
            $this->field = $this->field->toString($this->simpleSelect);
        }

        if (!is_null($this->field)) {
            // для конструкции field IN ('val1', 'val2')
            if ($this->comparsion === criteria::IN || $this->comparsion === criteria::NOT_IN) {
                if (is_array($this->value) && sizeof($this->value)) {
                    $result .= $this->getQuoutedAlias() . $this->getQuotedField() . ' ' . $this->comparsion . ' (';

                    foreach ($this->value as $val) {
                        $result .= $this->simpleSelect->quote($val) . ', ';
                    }
                    $result = substr($result, 0, -2);
                    $result .= ')';
                } else {
                    $result .= 'FALSE';
                }
            } elseif ($this->comparsion === criteria::IS_NULL || $this->comparsion === criteria::IS_NOT_NULL) {
                $result = $this->getQuoutedAlias() . $this->getQuotedField() . ' ' . $this->comparsion;
            } elseif ($this->comparsion === criteria::BETWEEN || $this->comparsion === criteria::NOT_BETWEEN) {
                $result = $this->getQuoutedAlias() . $this->getQuotedField() . ' ' . $this->comparsion . ' ' . $this->simpleSelect->quote($this->value[0]) . ' AND ' . $this->simpleSelect->quote($this->value[1]);
            } elseif ($this->comparsion === criteria::FULLTEXT || $this->comparsion === criteria::FULLTEXT_BOOLEAN) {
                if (is_array($this->field)) {
                    $fields_str = '';
                    foreach ($this->field as $field) {
                        $field = $this->splitNameAndAlias($field);
                        $fields_str .= $this->getQuoutedAlias($field[1]) . $this->simpleSelect->quoteField($field[0]) . ', ';
                    }
                    $fields_str = substr($fields_str, 0, -2);
                } else {
                    $fields_str = $this->getQuoutedAlias(). $this->getQuotedField();
                }

                $result = sprintf($this->comparsion, $fields_str, $this->simpleSelect->quote($this->value));
            } elseif ($this->comparsion === criteria::CASEWHERE) {
                $cases = array();
                foreach ($this->value as $key => $val) {
                    $case = 'WHEN ' . $this->simpleSelect->quote($key) . ' THEN ';
                    if ($val instanceof criterion) {
                        $case .= $val->generate($this->simpleSelect);
                    } elseif ($val instanceof sqlOperator) {
                        $case .= $val->toString($this->simpleSelect);
                    } else {
                        $case .= $this->simpleSelect->quote($val);
                    }

                    $cases[] = $case;
                }

                $result = sprintf($this->comparsion, $this->getQuotedField(), join(' ', $cases));
            } else {
                $result = $this->getQuoutedAlias() . $this->getQuotedField() . ' ' . $this->comparsion . ' ' . $this->getQuotedValue();
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
                $result .= '(' . $this->clauses[$key]->generate($simpleSelect, $defaultTable, $defaultAlias) . ')';
            }
        }

        if ($this->hasOr) {
            $result = '(' . $result . ')';
        }

        return $result;
    }

    /**
     * Метод для добавления к текущему объекту criterion дополнительных условий, связанных логическим оператором И
     *
     * @param criterion $criterion
     * @return criterion текущий объект
     */
    public function addAnd(criterion $criterion)
    {
        $this->clauses[] = $criterion;
        $this->conjunctions[] = self::C_AND;
        return $this;
    }

    /**
     * Метод для добавления к текущему объекту criterion дополнительных условий, связанных логическим оператором ИЛИ
     *
     * @param criterion $criterion
     * @return object текущий объект
     */
    public function addOr(criterion $criterion)
    {
        $this->hasOr = true;
        $this->clauses[] = $criterion;
        $this->conjunctions[] = self::C_OR;
        return $this;
    }

    /**
     * Метод для добавления к текущему объекту criterion дополнительных условий, не связанных никаким логическим оператором
     *
     * @param criterion $criterion
     * @return criterion текущий объект
     */
    public function add(criterion $criterion)
    {
        $this->clauses[] = $criterion;
        $this->conjunctions[] = '';
        return $this;
    }

    /**
     * Метод для получения имени поля
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Метод для получения алиаса<br>
     * Метод использовался исключительно для тестирования
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
     * Метод для получения экранированного алиаса
     *
     * @param string $alias
     * @return string
     */
    private function getQuoutedAlias($alias = null)
    {
        if (is_null($alias)) {
            $alias = $this->alias;
        }

        if (!$this->fieldIsFunction) {
            if (!empty($alias)) {
                return $this->simpleSelect->quoteAlias($alias) . '.';
            } elseif (!empty($this->defaultAlias)) {
                return $this->simpleSelect->quoteAlias($this->defaultAlias) . '.';
            } elseif (!empty($this->defaultTable)) {
                return $this->simpleSelect->quoteAlias($this->defaultTable) . '.';
            }
        }

        return '';
    }

    /**
     * Метод для получения значения
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Получение экранированного значения поля
     *
     * @return string
     */
    private function getQuotedField()
    {
        if ($this->fieldIsFunction) {
            return $this->field;
        }

        return $this->simpleSelect->quoteField($this->field);
    }

    /**
     * Метод для получения экранированного значения<br>
     * Если установлен флаг isField - то возвращается соответствующее имя поля с добавленным алиасом
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
                return $this->simpleSelect->quoteAlias($alias) . '.' . $this->simpleSelect->quoteField($field);
            }
            return $this->simpleSelect->quoteField($this->value);
        } else {
            $value = $this->value;

            if (!is_int($value)) {
                $value = $this->simpleSelect->quote($value);
            }

            return $value;
        }
    }

    /**
     * Получение метода сравнения операндов
     *
     * @return integer
     */
    public function getComparsion()
    {
        return $this->comparsion;
    }

    /**
     * Получение критерионов, связанных по or или and
     *
     * @return criterion
     */
    public function getClauses()
    {
        return array($this->clauses, $this->conjunctions);
    }
}

?>