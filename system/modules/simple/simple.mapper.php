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
 * @package simple
 * @version 0.2.2
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
     * Конструктор
     *
     * @param string $section секция
     */
    public function __construct($section, $alias = 'default')
    {
        $this->db = DB::factory($alias);
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
            $id = $stmt->execute($this->db->getAlias());

            $stmt = $this->searchByField($this->tableKey, $id);
            $fields = $stmt->fetch();

            $f = array();
            foreach ($fields as $key => $val) {
                $f[$this->className][str_replace($this->className . '_', '', $key)] = $val;
            }
            //var_dump($fields);

            //var_dump($f);
            //echo "<pre>"; print_r($f); echo "</pre>";


            $object->import($f[$this->className]);
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
            $stmt = $this->db->prepare('UPDATE  `' . $this->table . '` SET ' . $query . ' WHERE `' . $this->tableKey . '` = :id');

            $stmt->bindArray($fields);
            $stmt->bindParam(':id', $object->getId(), PDO::PARAM_INT);
            $result = $stmt->execute();

            $stmt = $this->searchByField($this->tableKey, $object->getId());

            $fields = $stmt->fetch();

            $f = array();
            foreach ($fields as $key => $val) {
                $f[$this->className][str_replace($this->className . '_', '', $key)] = $val;
            }

            $object->import($f[$this->className]);

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

    public function generateJoins($criteria, $val, $key, $table, $section)
    {
        $owns = isset($val['owns']) ? $val['owns'] : $val['ownsMany'];

        $tableName = substr($owns, 0, strpos($owns, '.'));
        $foreignKeyName = substr(strrchr($owns, '.'), 1);
        $className = $tableName . 'Mapper';

        $criterion = new criterion($table . '.' . $key, $section . '_' . $tableName . '.' . $foreignKeyName, criteria::EQUAL, true);
        $criteria->addJoin($section . '_' . $tableName, $criterion);

        fileLoader::load($this->name . '/mappers/' . $className);

        $mapper = new $className($section);
        $submap = $mapper->getMap();
        foreach ($submap as $key => $val) {
            $criteria->addSelectField($section . '_' . $tableName . '.' . $key, $tableName . '_' . $key);
            if (isset($val['owns']) || isset($val['ownsMany'])) {
                $this->generateJoins($criteria, $val, $key, $this->table, $this->section);
            }
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
        $criteria = new criteria($this->table);
        $criteria->enableCount();

        $map = $this->getMap();

        foreach ($map as $key => $val) {
            $criteria->addSelectField($this->table . '.' . $key, $this->className . '_' . $key);
            if (isset($val['owns']) || isset($val['ownsMany'])) {
                $this->generateJoins($criteria, $val, $key, $this->table, $this->section);
            }
        }

        $criteria->add($this->table . '.' . $name, $value);
        //echo "<pre> criteria "; var_dump($criteria); echo "</pre>";

        $select = new simpleSelect($criteria);
        //var_dump($select->toString());echo '<= select->toString <br>';
        $stmt = $this->db->query($select->toString());


        $criteria_count = new criteria();
        $criteria_count->addSelectField('FOUND_ROWS()', 'count');
        $select_count = new simpleSelect($criteria_count);

        $this->count = $this->db->getOne($select_count->toString());


        if (!empty($this->pager)) {
            $this->pager->setCount($this->count);
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

        //$prev_obj_id = 0;
        while ($row = $stmt->fetch()) {
            $f = array();
            foreach ($row as $key => $val) {
                $uscorePos = strpos($key, '_');
                $className = substr($key, 0, $uscorePos);
                $keyName = substr($key, $uscorePos + 1);

                $f[$className][$keyName] = $val;
            }

            $f = $this->fill($f, $this->className);
            //var_dump($f);
            //echo '<br><br><br>';

        }

        if (isset($f)) {
            return $this->createItemFromRow($f[$this->className]);
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
            $f = array();
            foreach ($row as $key => $val) {
                $uscorePos = strpos($key, '_');
                $className = substr($key, 0, $uscorePos);
                $keyName = substr($key, $uscorePos + 1);

                /*if ($className == $this->className) {
                $f[$keyName] = $val;
                }*/
                $f[$className][$keyName] = $val;

                //$f[$className][$keyName] = $val;
            }
            $f = $this->fill($f, $this->className);

            $result[] = $this->createItemFromRow($f[$this->className]);
        }

        return $result;
    }

    /**
     * метод поиска полей связанных объектов и присваивание вложенного объекта свойству родительского объекта
     *
     * @param array $f
     * @param string $parent
     * @return array
     */
    public function fill($f, $parent)
    {
        foreach ($this->getMap() as $key => $val) {
            if (isset($val['owns']) || isset($val['ownsMany'])) {
                $uscorePos = strpos($key, '_');
                $className = substr($key, 0, $uscorePos);
                $keyName = substr($key, $uscorePos + 1);

                $mapperName = $className . 'Mapper';

                //fileLoader::load($this->name)

                $mapper = new $mapperName($this->section);

                $item = $mapper->createItemFromRow($f[$className]);

                if (isset($val['owns'])) {
                    $f[$parent][$key] = $item;
                } else {
                    if (!is_array($f[$parent][$key])) {
                        unset($f[$parent][$key]);
                    }
                    $f[$parent][$key][] = $item;
                }
            }
        }

        return $f;
    }

    public function setMap($map)
    {
        $this->map = $map;
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
            //$this->map['obj_id'] = array('accessor' => 'getObjId', 'mutator' => 'setObjId', 'once' => 'true');
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

    public function convertArgsToId($args)
    {
        return (int)$args;
    }
}

?>