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
 * @version $Id$
 */

fileLoader::load('db/criterion');

/**
 * critera: класс, используемый для хранения данных о критериях выборки
 *
 * @package system
 * @subpackage db
 * @version 0.1.7
 */

class criteria
{
    /**
     * Константа, определяющая тип сравнения "=" (равно)
     *
     */
    const EQUAL = "=";

    /**
     * Константа, определяющая тип сравнения "<>" (не равно)
     *
     */
    const NOT_EQUAL = '<>';

    /**
     * Константа, определяющая тип сравнения ">" (больше)
     *
     */
    const GREATER = '>';

    /**
     * Константа, определяющая тип сравнения "<" (меньше)
     *
     */
    const LESS = '<';

    /**
     * Константа, определяющая тип сравнения ">=" (больше либо равно)
     *
     */
    const GREATER_EQUAL = '>=';

    /**
     * Константа, определяющая тип сравнения "<=" (меньше либо равно)
     *
     */
    const LESS_EQUAL = '<=';

    /**
     * Константа, определяющая оператор "IN"
     *
     */
    const IN = 'IN';

    /**
     * Константа, определяющая оператор "LIKE"
     *
     */
    const LIKE = 'LIKE';

    /**
     * Константа, определяющая оператор "BETWEEN"
     *
     */
    const BETWEEN = 'BETWEEN';

    /**
     * Константа, определяющая конструкцию для полнотекстового поиска
     *
     */
    const FULLTEXT = 'MATCH (%s) AGAINST (%s)';

    /**
     * Константа, определяющая сравнение "IS NULL"
     *
     */
    const IS_NULL = 'IS NULL';

    /**
     * Константа, определяющая тип объединения INNER
     *
     */
    const JOIN_INNER = 'INNER';

    /**
     * Константа, определяющая тип объединения LEFT
     *
     */
    const JOIN_LEFT = 'LEFT';

    /**
     * Массив для хранения присоединяемых к основной таблиц
     *
     * @var array
     */
    private $joins = array();

    /**
     * Имя основной таблицы
     *
     * @var string|array
     */
    private $table;

    /**
     * Массив в котором хранятся данные об условиях выборки
     *
     * @var array
     */
    private $map = array();

    /**
     * Массив для хранения правил сортировки выборки
     *
     * @var array
     */
    private $orderBy = array();

    /**
     * Массив для хранения полей для группировки
     *
     * @var array
     */
    private $groupBy = array();

    /**
     * Массив для хранения имён полей для выборки
     *
     * @var array
     */
    private $selectFields = array();

    /**
     * Массив для хранения алиасов к выбираемым полям
     *
     * @var array
     */
    private $selectFieldsAliases = array();

    /**
     * Число записей для выборки
     *
     * @var integer
     */
    private $limit = 0;

    /**
     * Смещение, начиная с котрого будет начинаться выборка
     *
     * @var integer
     */
    private $offset = 0;

    /**
     * Флаг, добавляющий DISTINCT в запрос
     *
     * @var boolean
     */
    private $distinct = false;

    /**
     * Конструктор
     *
     * @param string $table имя основной таблицы, из которой будет производиться выборка
     */
    public function __construct($table = null, $alias = null)
    {
        if ($table) {
            $this->setTable($table, $alias);
        }
    }

    /**
     * Установка имени основной таблицы
     *
     * @param string $table
     * @param string $alias алиас, который будет присвоен таблице
     * @return criteria текущий объект
     */
    public function setTable($table, $alias = null)
    {
        if (!empty($alias)) {
            $this->table = array('table' => $table, 'alias' => $alias);
        } else {
            $this->table = $table;
        }
        return $this;
    }

    /**
     * Получение имени основной таблицы
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Метод для добавления ещё одного условия выборки
     *
     * @see criterion
     * @param string|object $field имя поля или объект класса criterion
     * @param string $value значение. не используется если в качестве $field передаётся criterion
     * @param string $comparsion тип сравнения. не используется если в качестве $field передаётся criterion
     * @return criteria текущий объект
     */
    public function add($field, $value = null, $comparsion = null)
    {
        if ($field instanceof criterion) {
            if (!is_null($field->getField())) {
                $this->map[$field->getField()] = $field;
            } else {
                $this->map[] = $field;
            }
        } else {
            $this->map[$field] = new criterion($field, $value, $comparsion);
        }

        return $this;
    }

    /**
     * Метод для добавления данных из передаваемого объекта criteria к текущему<br>
     * Часть данных добавляется, часть заменяется
     *
     * @param criteria $criteria
     */
    public function append(criteria $criteria)
    {
        if ($limit = $criteria->getLimit()) {
            $this->limit = $limit;
        }
        if ($offset = $criteria->getOffset()) {
            $this->offset = $offset;
        }
        if ($orderBy = $criteria->getOrderByFields()) {
            $this->orderBy += $orderBy;
        }
    }

    /**
     * Метод для получения имён полей
     *
     * @return array
     */
    public function keys()
    {
        return array_keys($this->map);
    }

    /**
     * Метод удаления одного из критериев выборки
     *
     * @param имя ключа $key
     * @return criteria текущий объект
     */
    public function remove($key)
    {
        unset($this->map[$key]);
        return $this;
    }

    /**
     * Метод получения конкретного объекта criterion по имени ключа
     *
     * @param string $key имя ключа
     * @return object|null искомый объект, либо null в противном случае
     */
    public function getCriterion($key)
    {
        if (isset($this->map[$key])) {
            return $this->map[$key];
        }
        return null;
    }

    /**
     * Установка поля по которому будет производиться сортировка выборки. Направление ASC
     *
     * @param string $field имя поля
     * @return criteria текущий объект
     */
    public function setOrderByFieldAsc($field)
    {
        $field = str_replace('.', '`.`', $field);
        $this->orderBy[] = '`' . $field . '` ASC';
        return $this;
    }

    /**
     * Установка поля по которому будет производиться сортировка выборки. Направление DESC
     *
     * @param string $field имя поля
     * @return criteria текущий объект
     */
    public function setOrderByFieldDesc($field)
    {
        $field = str_replace('.', '`.`', $field);
        $this->orderBy[] = '`' . $field . '` DESC';
        return $this;
    }

    /**
     * Метод получения полей, по которым производится сортировка
     *
     * @return array
     */
    public function getOrderByFields()
    {
        $result = array();

        $table = $this->getTable();
        if (is_array($table) && isset($table['alias'])) {
            $table = $table['alias'];
        }

        $pre = '`' . $table . '`.';

        if ($pre != '``.') {
            foreach ($this->orderBy as $val) {
                $result[] = (strpos($val, '.') === false) ? $pre . $val : $val;
            }
        } else {
            return $this->orderBy;
        }

        return $result;
    }

    /**
     * Метод получения данных о числе выбираемых записей
     *
     * @return integer
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Метод получения данных о сдвиге
     *
     * @return integer
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Метод для установки числа выбираемых записей
     *
     * @param integer $limit
     * @return object сам объект
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Метод установки сдвига
     *
     * @param integer $offset
     * @return object сам объект
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Метод очистки числа выбираемых записей
     *
     * @return object сам объект
     */
    public function clearLimit()
    {
        $this->limit = 0;
        return $this;
    }

    /**
     * Метод очистки сдвига
     *
     * @return object сам объект
     */
    public function clearOffset()
    {
        $this->offset = 0;
        return $this;
    }

    /**
     * Метод для очистки списка полей для выборки
     *
     * @return criteria текущий объект
     */
    public function clearSelectFields()
    {
        $this->selectFields = array();
        return $this;
    }

    /**
     * Метод добавления полей для выборки
     *
     * @param string $field имя поля
     * @param string $alias алиас, который будет присвоен выбираемому полю
     * @return criteria текущий объект
     */
    public function addSelectField($field, $alias = null)
    {
        if ($field instanceof sqlFunction) {
            $this->selectFieldsAliases[$field->getFieldName()] = $alias;
        } else {
            $this->selectFieldsAliases[$field] = $alias;
        }
        $this->selectFields[] = $field;
        return $this;
    }

    /**
     * Метод получения списка выбираемых полей
     *
     * @return array
     */
    public function getSelectFields()
    {
        return $this->selectFields;
    }

    /**
     * Метод получения списка алиасов для конкретного поля
     *
     * @param string $field
     * @return string|null искомый алиас, либо null если алиас не найден
     */
    public function getSelectFieldAlias($field)
    {
        $name = ($field instanceof sqlFunction) ? $field->getFieldName() : $field;
        return isset($this->selectFieldsAliases[$name]) ? $this->selectFieldsAliases[$name] : null;
    }

    /**
     * Метод получения таблиц и условий для объединения
     *
     * @return array
     */
    public function getJoins()
    {
        return $this->joins;
    }

    /**
     * Метод для добавления нового объединения
     *
     * @param string $tablename имя таблицы
     * @param criterion $criterion условие объединения
     * @param string $alias алиас, который будет присвоен присоединяемой таблице
     * @param string $joinType тип объединения
     * @return criteria текущий объект
     */
    public function addJoin($tablename, criterion $criterion, $alias = '', $joinType = self::JOIN_LEFT)
    {
        $arr = array('table' => $tablename, 'criterion' => $criterion);
        $arr['type'] = $joinType;
        if ($alias) {
            $arr['alias'] = '`' . $alias . '`';
        }
        $this->joins[] = $arr;

        return $this;
    }

    /**
     * Метод для добавления нового поля для группировки
     *
     * @param string $field имя поля
     * @return criteria текущий объект
     */
    public function addGroupBy($field)
    {
        $field = '`' . str_replace('.', '`.`', $field) . '`';
        $this->groupBy[] = $field;
        return $this;
    }

    /**
     * Метод получения полей для группировки
     *
     * @return array
     */
    public function getGroupBy()
    {
        return $this->groupBy;
    }

    /**
     * Очистка списка полей для группировки
     *
     * @return criteria текущий объект
     */
    public function clearGroupBy()
    {
        $this->groupBy = array();
        return $this;
    }

    /**
     * Получение значения флага distinct
     *
     * @return boolean
     */
    public function getDistinct()
    {
        return $this->distinct;
    }

    /**
     * Установка значения флага distinct
     *
     * @param boolean $value
     */
    public function setDistinct($value = true)
    {
        $this->distinct = (bool)$value;
    }
}

?>