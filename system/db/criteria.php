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
fileLoader::load('db/sqlFunction');
fileLoader::load('db/sqlOperator');

/**
 * critera: класс, используемый для хранения данных о критериях выборки
 *
 * @package system
 * @subpackage db
 * @version 0.2.3
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
     * Константа, определяющая оператор "IN"
     *
     */
    const NOT_IN = 'NOT IN';

    /**
     * Константа, определяющая оператор "LIKE"
     *
     */
    const LIKE = 'LIKE';

    /**
     * Константа, определяющая оператор "NOT LIKE"
     *
     */
    const NOT_LIKE = 'NOT LIKE';

    /**
     * Константа, определяющая оператор "BETWEEN"
     *
     */
    const BETWEEN = 'BETWEEN';

    /**
     * Константа, определяющая оператор "NOT BETWEEN"
     *
     */
    const NOT_BETWEEN = 'NOT BETWEEN';

    /**
     * Константа, определяющая конструкцию для полнотекстового поиска
     *
     */
    const FULLTEXT = 'MATCH (%s) AGAINST (%s)';

    /**
     * Константа, определяющая конструкцию для полнотекстового поиска в булевом режиме
     *
     */
    const FULLTEXT_BOOLEAN = 'MATCH (%s) AGAINST (%s IN BOOLEAN MODE)';

    /**
     * Константа, определяющая сравнение "IS NULL"
     *
     */
    const IS_NULL = 'IS NULL';

    /**
     * Константа, определяющая сравнение "IS NOT NULL"
     *
     */
    const IS_NOT_NULL = 'IS NOT NULL';

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
     * Константы, определяющая конструкцию CASE WHERE ... THEN ... END
     *
     */
    const CASEWHERE = 'CASE %s %s END';

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
     * Массив в котором хранятся данные об условиях в HAVING
     *
     * @var array
     */
    private $havingMap = array();

    /**
     * Массив для хранения правил сортировки выборки
     *
     * @var array
     */
    private $orderBy = array();

    /**
     * Массив для хранения различных параметров полей, по которым производится сортировка (например, алиас)
     *
     * @var array
     */
    private $orderBySettings = array();

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
    public function add($field, $value = null, $comparsion = criteria::EQUAL)
    {
        if ($field instanceof criterion) {
            if (!is_null($name = $field->getField())) {
                if ($name instanceof sqlFunction) {
                    $name = $name->getFieldName();
                }
                $this->map[$name] = $field;
            } else {
                $this->map[] = $field;
            }
        } else {
            $this->map[$field] = new criterion($field, $value, $comparsion);
        }

        return $this;
    }

    /**
     * Метод для добавления ещё одного условия в HAVING
     *
     * @see criterion
     * @param string|object $field имя поля или объект класса criterion
     * @param string $value значение. не используется если в качестве $field передаётся criterion
     * @param string $comparsion тип сравнения. не используется если в качестве $field передаётся criterion
     * @return criteria текущий объект
     */
    public function addHaving($field, $value = null, $comparsion = criteria::EQUAL)
    {
        if ($field instanceof criterion) {
            if (!is_null($name = $field->getField())) {
                if ($name instanceof sqlFunction) {
                    $name = $name->getFieldName();
                }
                $this->havingMap[$name] = $field;
            } else {
                $this->havingMap[] = $field;
            }
        } else {
            if ($field instanceof sqlFunction ) {
                $fieldname = $field->getFieldName();
            } else {
                $fieldname = $field;
            }
            $this->havingMap[$fieldname] = new criterion($field, $value, $comparsion);
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
        if ($selectFields = $criteria->getSelectFields()) {
            $this->selectFields = array_merge($this->selectFields, $selectFields);
        }

        if ($aliases = $criteria->getSelectFieldAlias()) {
            $this->selectFieldsAliases = array_merge($this->selectFieldsAliases, $aliases);
        }

        if ($joins = $criteria->getJoins()) {
            $this->joins = array_merge($this->joins, $joins);
        }

        if ($map = $criteria->getCriterion()) {
            $this->map = array_merge($this->map, $map);
        }

        if ($havingMap = $criteria->getHaving()) {
            $this->havingMap = array_merge($this->havingMap, $havingMap);
        }

        if ($limit = $criteria->getLimit()) {
            $this->limit = $limit;
        }

        if ($offset = $criteria->getOffset()) {
            $this->offset = $offset;
        }

        if ($orderBy = $criteria->getOrderByFields()) {
            $this->orderBy = array_merge($this->orderBy, $orderBy);
        }

        if ($orderBySettings = $criteria->getOrderBySettings()) {
            $this->orderBySettings = array_merge($this->orderBySettings, $orderBySettings);
        }

        if ($groupBy = $criteria->getGroupBy()) {
            $this->groupBy = array_merge($this->groupBy, $groupBy);
        }

        if ($distinct = $criteria->getDistinct()) {
            $this->distinct = $distinct;
        }

        $base = $this->getTable();
        $outer = $criteria->getTable();
        if (!is_scalar($outer['table']) && !is_null($outer['table'])) {
            $this->setTable($outer['table'], $base['alias']);
            //алиас не трогаем
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
    public function getCriterion($key = null)
    {
        if (isset($this->map[$key])) {
            return $this->map[$key];
        }
        return $this->map;
    }

    /**
     * Метод получения конкретного объекта criterion в having по имени ключа
     *
     * @param string $key имя ключа
     * @return object|null искомый объект, либо null в противном случае
     */
    public function getHaving($key = null)
    {
        if (isset($this->havingMap[$key])) {
            return $this->havingMap[$key];
        }
        return $this->havingMap;
    }

    /**
     * Установка поля по которому будет производиться сортировка выборки. Направление ASC
     *
     * @param string $field имя поля
     * @param boolean $alias
     * @return criteria текущий объект
     */
    public function setOrderByFieldAsc($field, $alias = true)
    {
        $this->setOrderBy($field, 'ASC', $alias);
        return $this;
    }

    /**
     * Установка поля по которому будет производиться сортировка выборки. Направление DESC
     *
     * @param string $field имя поля
     * @param boolean $alias
     * @return criteria текущий объект
     */
    public function setOrderByFieldDesc($field, $alias = true)
    {
        $this->setOrderBy($field, 'DESC', $alias);
        return $this;
    }

    /**
     * Установка поля по которому будет производться сортировка
     *
     * @param string $field
     * @param string $direction
     * @param boolean $alias
     */
    private function setOrderBy($field, $direction, $alias)
    {
        $this->orderBy[] = $field;
        $this->setOrderBySetting($alias, $direction);
    }

    /**
     * Получение опций сортировки
     *
     * @return array
     */
    public function getOrderBySettings()
    {
        return $this->orderBySettings;
    }

    /**
     * Установка опций для сортировки
     *
     * @param string $alias
     */
    private function setOrderBySetting($alias, $direction)
    {
        $this->orderBySettings[] = array('alias' => $alias, 'direction' => $direction);
    }

    /**
     * Метод получения полей, по которым производится сортировка
     *
     * @return array
     */
    public function getOrderByFields()
    {
        return $this->orderBy;
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
     * @return criteria сам объект
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
     * @return criteria сам объект
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Метод очистки числа выбираемых записей
     *
     * @return criteria сам объект
     */
    public function clearLimit()
    {
        $this->limit = 0;
        return $this;
    }

    /**
     * Метод очистки сдвига
     *
     * @return criteria сам объект
     */
    public function clearOffset()
    {
        $this->offset = 0;
        return $this;
    }

    /**
     * Метод очистки правил сортировок
     *
     * @return criteria сам объект
     */
    public function clearOrder()
    {
        $this->orderBy = array();
        $this->orderBySettings = array();
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
        if ($field instanceof sqlFunction || $field instanceof sqlOperator) {
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
    public function getSelectFieldAlias($field = null)
    {
        if ($field) {
            if ($field instanceof sqlFunction || $field instanceof sqlOperator) {
                $name = $field->getFieldName();
            } else {
                $name = $field;
            }
            return isset($this->selectFieldsAliases[$name]) ? $this->selectFieldsAliases[$name] : null;
        }

        return $this->selectFieldsAliases;
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
            $arr['alias'] = $alias;
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

    /**
     * Отладка критерии
     * Критерия конвертируется в SQL-запрос
     *
     * @param boolean $as_string возвращать строку SQL-запроса, но не выводить на экран
     * @return string SQL-запрос
     */
    public function debug($as_string = false)
    {
        $s = new simpleSelect($this);

        if (!$as_string) {
            echo "<pre>";
            var_dump($s->toString());
            echo "</pre>";
        }

        return $s->toString();
    }


}

?>