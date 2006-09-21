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
fileLoader::load('db/simpleSelect');

/**
 * simpleMapper: реализация общих методов у Mapper
 *
 * @package modules
 * @subpackage simple
 * @version 0.3
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
     * Название праймари ключа таблицы
     *
     * @var string
     */
    protected $tableKey = 'id';

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
     * Map. Содержит информацию о полях (метод изменения, метод получения, отношения, ...).
     *
     * @var array
     */
    protected $map;

    /**
     * массив для хранения мапперов
     *
     * @todo подумать на тему того, что можно сделать глобальный регистри для этого
     * @var array
     */
    protected $mappers;

    /**
     * Конструктор
     *
     * @param string $section секция
     */
    public function __construct($section)
    {
        $this->db = DB::factory();
        $this->section = $section;
        $this->table = $this->name() . '_' .$this->className;
        //$this->relationTable = $this->name() . '_' .$this->section() . '_' . $this->relationPostfix;
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
        $toolkit = systemToolkit::getInstance();
        $object->setObjId($toolkit->getObjectId());

        $fields = $object->export();

        if (sizeof($fields) > 0) {
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

            $stmt = $this->searchByField($this->tableKey, $id);
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
            $this->replaceRelated($fields);

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
            $stmt = $this->db->prepare('UPDATE  `' . $this->table . '` SET ' . $query . ' WHERE `' . $this->tableKey . '` = :id');

            $stmt->bindArray($fields);
            $stmt->bindParam(':id', $object->getId(), PDO::PARAM_INT);
            $result = $stmt->execute();

            $stmt = $this->searchByField($this->tableKey, $object->getId());
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
        $stmt = $this->db->prepare('DELETE FROM `' . $this->table . '` WHERE `' . $this->tableKey . '` = :id');
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
     * Поиск записей по критерию
     *
     * @param criteria $criteria заданный критерий
     * @return object PDOStatement
     */
    public function searchByCriteria(criteria $criteria)
    {
        $criteria->setTable($this->table);

        // если есть пейджер - то посчитать записи без LIMIT и передать найденное число записей в пейджер
        if ($this->pager) {
            $criteriaForCount = clone $criteria;
            $criteriaForCount->addSelectField('COUNT(*)', 'cnt');
            $selectForCount = new simpleSelect($criteriaForCount);
            $stmt = $this->db->query($selectForCount->toString());
            $count = $stmt->fetch();

            $this->pager->setCount($count['cnt']);

            $criteria->append($this->pager->getLimitQuery());
        }

        $select = new simpleSelect($criteria);

        $stmt = $this->db->query($select->toString());

        return $stmt;
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
        $criteria = new criteria();
        $criteria->add($name, $value);
        return $this->searchByCriteria($criteria);
    }

    /**
     * Возвращает Доменный Объект, который обслуживает запрашиваемый маппер
     *
     * @return object
     */
    public function create()
    {
        $object = new $this->className($this->getMap());
        $object->section($this->section());
        return $object;
    }

    /**
     * Заполняет данными из массива доменный объект
     *
     * @param array $row массив с данными
     * @return object
     */
    protected function createItemFromRow($row)
    {
        $object = $this->create();
        $object->import($row);
        return $object;
    }

    /**
     * Поиск одной записи по заданному критерию
     *
     * @param criteria $criteria
     * @return array
     */
    public function searchOneByCriteria(criteria $criteria)
    {
        $stmt = $this->searchByCriteria($criteria);
        $row = $stmt->fetch();

        if ($row) {
            return $this->createItemFromRow($row);
        }
        return null;
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
        $criteria = new criteria();
        $criteria->add($name, $value);
        return $this->searchOneByCriteria($criteria);
    }

    /**
     * Поиск всех записей по заданному критерию
     *
     * @param criteria $criteria
     * @return array
     */
    public function searchAllByCriteria(criteria $criteria)
    {
        $stmt = $this->searchByCriteria($criteria);
        $result = array();

        while ($row = $stmt->fetch()) {
            $result[] = $this->createItemFromRow($row);
        }

        return $result;
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
        $criteria = new criteria();
        $criteria->add($name, $value);
        return $this->searchAllByCriteria($criteria);
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

    /**
     * Метод установки map
     *
     * @param array $map
     */
    public function setMap($map)
    {
        $this->map = $map;
    }

    /**
     * Метод, заменяющий связанные объекты на строки
     *
     * @param unknown_type $fields
     */
    private function replaceRelated(&$fields)
    {
        $map = $this->getMap();

        foreach ($fields as $key => $val) {
            // если по данному полю есть связь
            if (!is_scalar($val) && isset($map[$key]['owns'])) {
                $arr = explode('.', $map[$key]['owns'], 2);
                $className = $arr[0];
                $fieldName = $arr[1];
                $sectionName = isset($map[$key]['section']) ? $map[$key]['section'] : $this->section();
                $moduleName = isset($map[$key]['module']) ? $map[$key]['module'] : $this->name();
                $mapperName = $className . 'Mapper';

                if (!isset($this->mappers[$mapperName][$sectionName])) {
                    fileLoader::load($moduleName . '/mappers/' . $mapperName);
                    $mapper = new $mapperName($sectionName);
                    $this->mappers[$mapperName][$sectionName] = $mapper;
                }

                // сохраняем связанный объект
                $mapper->save($val);

                // получаем схему связанного объекта
                $relatedMap = $mapper->getMap();

                // из полученной схемы получаем имя акцессора к методу, по которому получаем данные, по которым связыываем этот объект с главным
                $accessor = $relatedMap[$fieldName]['accessor'];

                // делаем вызов полученного акцессора и заменяем объект на строку
                $fields[$key] = $val->$accessor();
            }
        }
    }

    public function convertArgsToId($args)
    {
        return (int)$args;
    }
}

?>