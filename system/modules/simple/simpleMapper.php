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
     * Свойство для хранения информации об отношениях
     *
     * @var array
     */
    protected $relations;

    /**
     * Конструктор
     *
     * @param string $section секция
     * @param string $alias название соединения с бд
     */
    public function __construct($section, $alias = 'default')
    {
        $this->db = DB::factory($alias);
        $this->section = $section;
        $this->table = $this->section . '_' .$this->className;
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

        $fields =& $object->export();

        if (sizeof($fields) > 1) {
            $this->replaceRelated($fields, $object);

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

            $data = $this->fillArray($fields);

            $object->import($data);
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
        $fields =& $object->export();

        $this->replaceRelated($fields, $object);

        if (sizeof($fields) > 0) {
            //$bindFields = $fields; // зачем эта строка???
            //$this->replaceRelated($fields, $object);

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

            if ($query) {
                $stmt = $this->db->prepare('UPDATE  `' . $this->table . '` SET ' . $query . ' WHERE `' . $this->tableKey . '` = :id');

                $stmt->bindArray($fields);
                $stmt->bindParam(':id', $object->getId(), PDO::PARAM_INT);
                $result = $stmt->execute();
            }

            $stmt = $this->searchByField($this->tableKey, $object->getId());
            $fields = $stmt->fetch();

            $data = $this->fillArray($fields);

            $object->import($data);

            return true;
            //return $result;
        }

        return false;
    }

    /**
     * Метод для изменения формата массива в удобную для работы форму
     *
     * @param array $array
     * @return array
     */
    public function fillArray(&$array)
    {
        $tmp = array();
        foreach ($array as $key => $val) {
            list($class, $field) = explode('_', $key, 2);
            $tmp[$class][$field] = $val;
        }

        $toolkit = systemToolkit::getInstance();

        foreach ($this->getOwns() as $key => $val) {
            $mapper = $toolkit->getMapper($val['module'], $val['class'], $val['section']);
            $tmp[$this->name][$key] = $mapper->createItemFromRow($tmp[$val['class']]);
        }

        return $tmp[$this->name];
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
     * Метод для добавления в запрос присоединений
     *
     * @param criteria $criteria
     */
    protected function addJoins(criteria $criteria)
    {
        $toolkit = systemToolkit::getInstance();

        $this->addSelectFields($criteria, $this->getMap(), $this->table, $this->name);

        foreach ($this->getOwns() as $key => $val) {
            $mapper = $toolkit->getMapper($val['module'], $val['class'], $val['section']);

            $this->addSelectFields($criteria, $mapper->getMap(), $val['class'], $val['class']);

            $joinCriterion = new criterion($key, $val['class'] . '.' . $val['key'], criteria::EQUAL, true);
            $criteria->addJoin($val['table'], $joinCriterion, $val['class']);
        }
    }

    /**
     * Поиск записей по критерию
     *
     * @param criteria $criteria заданный критерий
     * @return object PDOStatement
     */
    protected function searchByCriteria(criteria $criteria)
    {
        $this->addJoins($criteria);

        $criteria->setTable($this->table);

        // если есть пейджер - то посчитать записи без LIMIT и передать найденное число записей в пейджер
        if ($this->pager) {
            $criteriaForCount = clone $criteria;
            $criteriaForCount->clearSelectFields()->addSelectField('COUNT(*)', 'cnt');
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
            $data = $this->fillArray($row);

            return $this->createItemFromRow($data);
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
            $data = $this->fillArray($row);
            $result[] = $this->createItemFromRow($data);
        }

        return $result;
    }

    private function addSelectFields(criteria $criteria, $map, $table, $alias)
    {
        foreach ($map as $key => $val) {
            if (!isset($val['hasMany'])) {
                $criteria->addSelectField($table . '.' . $key, $alias . '_' . $key);
            }
        }
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
    protected function getMap($refresh = false)
    {
        if ($refresh) {
            unset($this->map);
        }
        if (empty($this->map)) {
            $mapFileName = fileLoader::resolve($this->name() . '/maps/' . $this->className . '.map.ini');
            $this->map = parse_ini_file($mapFileName, true);
            $this->map['obj_id'] = array('name' => 'obj_id', 'accessor' => 'getObjId', 'mutator' => 'setObjId', 'once' => 'true');
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

    private function explodeRelateData($val)
    {
        list($tableName, $fieldName) = explode('.', $val['relate'], 2);
        $className = $tableName;
        if (isset($val['do'])) {
            $className =  $val['do'];
        }
        $sectionName = isset($val['section']) ? $val['section'] : $this->section();
        $moduleName = isset($val['module']) ? $val['module'] : $this->name();
        return array($tableName, $fieldName, $className, $sectionName, $moduleName);
    }

    private function getOwns()
    {
        if (!isset($this->relations['owns'])) {
            $this->relations['owns'] = array();
            foreach ($this->getMap() as $key => $val) {
                if (isset($val['owns'])) {
                    $val['relate'] = $val['owns'];
                    list($tableName, $fieldName, $className, $sectionName, $moduleName) = $this->explodeRelateData($val);

                    $this->relations['owns'][$key] = array('section' => $sectionName, 'table' => $sectionName . '_' . $tableName, 'key' => $fieldName, 'module' => $moduleName, 'class' => $className);
                }
            }
        }

        return $this->relations['owns'];
    }

    private function getHasMany()
    {
        if (!isset($this->relations['hasMany'])) {
            $this->relations['hasMany'] = array();
            foreach ($this->getMap() as $key => $val) {
                if (isset($val['hasMany'])) {
                    list($field, $tmp) = explode('->', $val['hasMany'], 2);
                    $val['relate'] = $tmp;
                    list($tableName, $fieldName, $className, $sectionName, $moduleName) = $this->explodeRelateData($val);

                    $this->relations['hasMany'][$key] = array('section' => $sectionName, 'table' => $sectionName . '_' . $tableName, 'key' => $fieldName, 'module' => $moduleName, 'class' => $className, 'field' => $field);
                }
            }
        }

        return $this->relations['hasMany'];
    }

    private function getRelationInfo($key)
    {
        $this->getHasMany();
        $this->getOwns();
        return isset($this->relations['hasMany'][$key]) ? $this->relations['hasMany'][$key] : (isset($this->relations['owns'][$key]) ? $this->relations['owns'][$key] : false);
    }

    /**
     * Метод, заменяющий связанные объекты на строки
     *
     * @param array $fields
     */
    private function replaceRelated(&$fields, $object)
    {
        $map = $this->getMap();
        $saved = array();

        // обновляем измененные поля
        foreach ($fields as $key => $val) {
            $owns = $this->getOwns();
            $hasMany = $this->getHasMany();
            // если по данному полю есть связь
            if (!is_scalar($val) && isset($owns[$key])) {
                $sectionName = $owns[$key]['section'];
                $className = $owns[$key]['class'];
                $fieldName = $owns[$key]['key'];
                $moduleName = $owns[$key]['module'];

                // получаем нужный маппер
                $toolkit = systemToolkit::getInstance();
                $mapper = $toolkit->getMapper($moduleName, $className, $sectionName);

                // сохраняем связанный объект
                $mapper->save($val);

                // получаем схему связанного объекта
                $relatedMap = $mapper->getMap();

                // из полученной схемы получаем имя акцессора к методу, по которому получаем данные, по которым связыываем этот объект с главным
                $accessor = $relatedMap[$fieldName]['accessor'];

                // делаем вызов полученного акцессора и заменяем объект на строку
                $fields[$key] = $val->$accessor();

                // отмечаем, что это поле уже было сохранено
                $saved[$key] = true;
            } elseif (isset($map[$key]['hasMany'])) {
                $accessor = $map[$key]['accessor'];
                $oldData = $object->$accessor();

                $oldObjIds = array();
                foreach ($oldData as $subval) {
                    $oldObjIds[$subval->getObjId()] = $subval->getId();
                }

                // определяем записи, которых нет в новом массиве
                foreach ($val as $subkey => $subval) {
                    if (isset($oldObjIds[$subval->getObjId()])) {
                        unset($oldObjIds[$subval->getObjId()]);
                    }
                }

                $sectionName = $hasMany[$key]['section'];
                $className = $hasMany[$key]['class'];
                $fieldName = $hasMany[$key]['key'];
                $moduleName = $hasMany[$key]['module'];

                // получаем нужный маппер
                $toolkit = systemToolkit::getInstance();
                $mapper = $toolkit->getMapper($moduleName, $className, $sectionName);

                // удаляем все записи которых нет в новом массиве
                foreach ($oldObjIds as $subval) {
                    $mapper->delete($subval);
                }

                // сохраняем все новые записи
                foreach ($val as $subval) {
                    $mapper->save($subval);
                }

                // удаляем данные
                unset($fields[$key]);

                // отмечаем, что это поле уже было сохранено
                $saved[$key] = true;
            }
        }

        $old =& $object->exportOld();

        $toolkit = systemToolkit::getInstance();

        // обновляем те поля, которые изменены не были
        // обходим все поля, которые в объекте были до сохранения
        foreach ($old as $key => $val) {
            // если поле является объектом или массивом и ещё не было сохранено - то сохраняем его
            if (!isset($saved[$key]) && !is_scalar($val) && !is_null($val)) {
                $info = $this->getRelationInfo($key);
                $sectionName = $info['section'];
                $className = $info['class'];
                $fieldName = $info['key'];
                $moduleName = $info['module'];

                $mapper = $toolkit->getMapper($moduleName, $className, $sectionName);

                if (is_array($val)) {
                    foreach ($val as $subval) {
                        $mapper->save($subval);
                    }
                } else {
                    $mapper->save($val);
                }
            }
        }
    }

    public function convertArgsToId($args)
    {
        return (int)$args;
    }
}

?>