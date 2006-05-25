<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
fileLoader::load('db/sqlFunction');
/**
 * simpleMapper: реализация общих методов у Mapper
 *
 * @package simple
 * @version 0.2
 */

abstract class simpleMapper implements iCacheable
{
    /**
     * Ссылка на объект Базы Данных
     *
     * @var object
     */
    protected $db;

    /**
     * Имя таблицы модуля (собирается из имени, секции, постфикса)
     *
     * @var string
     */
    protected $table;

    /**
     * Секция
     *
     * @var string
     */
    protected $section;

    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name;

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className;

    /**
     * Ссылка на объект cache
     *
     * @var object
     */
    protected $cache;

    /**
     * Массив кешируемых методов
     *
     * @var array
     */
    protected $cacheable = array();

    /**
     * Постфикс имени таблицы
     *
     * @var string
     */
    protected $tablePostfix = null;

    /**
     * Конструктор
     *
     * @param string $section секция
     */
    public function __construct($section)
    {
        $this->db = DB::factory();
        $this->section = $section;
        $this->table = $this->name() . '_' .$this->section() . $this->tablePostfix;
    }

    /**
     * Возвращает имя модуля
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Возвращает секцию
     *
     * @return string
     */
    public function section()
    {
        return $this->section;
    }

    /**
     * Выполняет вставку объекта $object в таблицу.
     * Данные экспортируются из объекта в массив, который передается
     * в метод self::insertDataModify(), после генерируется и
     * выполняется SQL-запрос для совершения операции вставки.
     * В завершении возвращается переданный объект с новыми данными
     *
     * @param simple $object
     */
    protected function insert(simple $object)
    {
        $fields = $object->export();

        if (sizeof($fields) > 0) {
            $this->insertDataModify($fields);

            $field_names = '`' . implode('`, `', array_keys($fields)) . '`';
            $markers = "";
            foreach(array_keys($fields) as $val) {
                if($fields[$val] instanceof sqlFunction) {
                    $markers .= $fields[$val]->toString() . ', ';
                    unset($fields[$val]);
                } else {
                    $markers .= ':' . $val . ', ';
                }
            }
            $markers = substr($markers, 0, -2);

            $stmt = $this->db->prepare('INSERT INTO `' . $this->table . '` (' . $field_names . ') VALUES (' . $markers . ')');

            $stmt->bindArray($fields);

            $id = $stmt->execute();

            $fields['id'] = $id;

            $object->import($fields);
        }
    }

    /**
     * Выполняет обновление объекта $object в таблице.
     * Данные экспортируются из объекта в массив, который передается
     * в метод self::updateDataModify(), после генерируется и
     * выполняется SQL-запрос для совершения операции обновления.
     * В завершении возвращается переданный объект с новыми данными
     *
     * @param simple $object
     */
    protected function update(simple $object)
    {
        $fields = $object->export();

        if (sizeof($fields) > 0) {
            $this->updateDataModify($fields);

            $query = '';
            foreach(array_keys($fields) as $val) {
                if($fields[$val] instanceof sqlFunction) {
                    $query .= '`' . $val . '` = ' . $fields[$val]->toString() . ', ';
                    unset($fields[$val]);
                } else {
                    $query .= '`' . $val . '` = :' . $val . ', ';
                }
            }
            $query = substr($query, 0, -2);
            $stmt = $this->db->prepare('UPDATE  `' . $this->table . '` SET ' . $query . ' WHERE `id` = :id');

            $stmt->bindArray($fields);
            $stmt->bindParam(':id', $object->getId(), PDO::PARAM_INT);


            $object->import($fields);

            return $stmt->execute();
        }

        return false;
    }

    /**
     * Выполняет удаление объекта из БД
     *
     * @param integer $id
     * @return mixed
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM `' . $this->table . '` WHERE `id` = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Если у объекта имеется идентификатор, то выполняется
     * обновление объекта, иначе выполняется вставка объекта в БД
     *
     * @param object $object
     */
    public function save($object)
    {
        if ($object->getId()) {
            $this->update($object);
        } else {
            $this->insert($object);
        }
    }

    /**
     * Ищет запись по полю $name со значением $value
     * и возвращает результат поиска
     *
     * @param string $name имя поля
     * @param string $value значения поля
     * @return object
     */
    public function searchByField($name, $value)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` WHERE `" . $name .  "` = :" . $name);
        $stmt->bindParam(':' . $name, $value);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Возвращает Map
     *
     * @return array
     */
    protected function getMap()
    {
        if (empty($this->map)) {
            $mapFileName = fileLoader::resolve($this->name() . '/maps/' . $this->className . '.map.ini');
            $this->map = parse_ini_file($mapFileName, true);
        }
        return $this->map;
    }

    /**
     * возвращает возможность кеширования для запрашиваемого метода
     *
     * @param string $name имя метода
     * @return boolean возможность кеширования
     */
    public function isCacheable($name)
    {
        return in_array($name, $this->cacheable);
    }

    /**
     * Установка ссылки на объект cache
     *
     * @package cache $cache
     */
    public function injectCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * Выполнение операций с массивом $fields перед обновлением в БД
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
    }

    /**
     * Выполнение операций с массивом $fields перед вставкой в БД
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
    }
}

?>