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
 * @version 0.1.4
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
     * Алиас<br>
     * Извлекается автоматически из имени поля - как часть поля до первого знака "." (точка)
     *
     * @var string
     */
    private $alias;

    /**
     * Флаг, обозначающий что второй аргумент конструктора $value является также полем, а не просто строковой константой<br>
     * Установка флага в true в результате приведёт к тому, что второй операнд будет обрамлён в "`" (обратная кавычка, back tick) и к нему будет добавлен алиас, если таковой имеется
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
     * Класс для хранения объекта работы с БД
     *
     * @var object
     */
    private $db;

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
     * Массив, хранящий типы логических объединений (И/ИЛИ) между дополнительными операциями сравнения
     *
     * @var array
     */
    private $conjunctions = array();

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
     * Метод, по вызову которого из данных генерируется часть запроса
     *
     * @param string|array $defaultTable имя таблицы, которое будет подставлено, если алиас не определён
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
            // для конструкции `field` IN ('val1', 'val2')
            if ($this->comparsion === criteria::IN || $this->comparsion === criteria::NOT_IN) {
                if (is_array($this->value) && sizeof($this->value)) {
                    $result .= $this->getQuoutedAlias() . '`' . $this->field . '` ' . $this->comparsion . ' (';
                    // тут наверное нужно проверять ещё и sizeof($this->value)
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
     * Метод для получения значения
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
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