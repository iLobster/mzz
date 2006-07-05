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
 * @package simple
 * @version $Id$
*/

fileLoader::load('db/sqlFunction');

/**
 * simpleMapper: реализация общих методов у Mapper
 *
 * @package simple
 * @version 0.2.1
 */
abstract class simpleMapper //implements iCacheable
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
     * Имя таблицы отношений (собирается из имени, секции, relation-постфикса)
     *
     * @var string
     */
    protected $relationTable;

    /**
     * Relation-постфикс
     *
     * @var string
     */
    protected $relationPostfix = 'rel';

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
    //protected $cache;

    /**
     * Массив кешируемых методов
     *
     * @var array
     */
    //protected $cacheable = array();

    /**
     * Постфикс имени таблицы
     *
     * @var string
     */
    protected $tablePostfix = null;

    /**
    * Число записей, возвращённых за последний запрос (без учёта LIMIT)
    *
    * @var integer
    */
    protected $count;

    /**
     * объект, используемый для постраничного вывода
     * и хранения настроек постраничного вывода
     *
     * @var pager
     */
    protected $pager;

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
        $this->relationTable = $this->name() . '_' .$this->section() . '_' . $this->relationPostfix;
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
            //$bindFields = $fields; // зачем эта строка???
            $this->insertDataModify($fields);

            $field_names = '`' . implode('`, `', array_keys($fields)) . '`';
            $markers = "";
            foreach(array_keys($fields) as $val) {
                if($fields[$val] instanceof sqlFunction) {
                    $fields[$val] = $fields[$val]->toString();
                    $markers .= $fields[$val] . ', ';
                } else {
                    $markers .= ':' . $val . ', ';
                }
            }
            $markers = substr($markers, 0, -2);

            $stmt = $this->db->prepare('INSERT INTO `' . $this->table . '` (' . $field_names . ') VALUES (' . $markers . ')');

            $stmt->bindArray($fields);

            $id = $stmt->execute();

            $stmt = $this->searchByField('id', $id);
            $fields = $stmt->fetch();

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
            //$bindFields = $fields; // зачем эта строка???
            $this->updateDataModify($fields);
            $query = '';
            foreach(array_keys($fields) as $val) {
                if($fields[$val] instanceof sqlFunction) {
                    $fields[$val] = $fields[$val]->toString();
                    $query .= '`' . $val . '` = ' . $fields[$val] . ', ';
                } else {
                    $query .= '`' . $val . '` = :' . $val . ', ';
                }
            }
            $query = substr($query, 0, -2);
            $stmt = $this->db->prepare('UPDATE  `' . $this->table . '` SET ' . $query . ' WHERE `id` = :id');

            $stmt->bindArray($fields);
            $stmt->bindParam(':id', $object->getId(), PDO::PARAM_INT);
            $result = $stmt->execute();

            $stmt = $this->searchByField('id', $object->getId());
            $fields = $stmt->fetch();

            $object->import($fields);

            return $result;
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
        $qry = "SELECT SQL_CALC_FOUND_ROWS * FROM `" . $this->table . "` WHERE `" . $name .  "` = :" . $name;
        if (!empty($this->pager)) {
            $qry .= $this->pager->getLimitQuery();
        }

        $stmt = $this->db->prepare($qry);
        $stmt->bindParam(':' . $name, $value);
        $stmt->execute();

        $statement = $this->db->query('SELECT FOUND_ROWS() AS `count`');
        $res = $statement->fetchAll();
        $statement->closeCursor();
        $this->count = $res[0]['count'];

        if (!empty($this->pager)) {
            $this->pager->setCount($res[0]['count']);
        }

        return $stmt;
    }

    /**
     * Ищет и возвращает одну запись по заданому имени поля
     * и его значению
     *
     * @param string $name имя поля
     * @param string $value значение поля
     * @return object
     */
    public function searchOneByField($name, $value)
    {
        $stmt = $this->searchByField($name, $value);
        $row = $stmt->fetch();

        if ($row) {
            return $this->createItemFromRow($row);
        }
        return null;
    }

    /**
     * Ищет и возвращает все записи по заданому имени поля
     * и его значению
     *
     * @param string $name имя поля
     * @param string $value значение поля
     * @return array массив с объектами
     */
    public function searchAllByField($name, $value)
    {
        $stmt = $this->searchByField($name, $value);
        $result = array();

        while ($row = $stmt->fetch()) {
            $result[] = $this->createItemFromRow($row);
        }

        return $result;
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

    /**
     * установка объекта пейджера
     *
     * @param pager $pager
     */
    public function setPager($pager)
    {
        $this->pager = $pager;
    }
}

?>