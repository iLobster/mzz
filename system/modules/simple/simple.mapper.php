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
    //protected $relationTable;

    /**
     * Relation-постфикс
     *
     * @var string
     */
    //protected $relationPostfix = 'rel';

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
     * Массив для хранения данных об отношении 1:1
     * Поле для связывания есть в основной таблице
     *
     * @var array
     */
    protected $owns;

    /**
     * Массив для хранения данных об отношении 1:1
     * Поля для связывания в основной таблице нет
     *
     * @var array
     */
    protected $has;

    /**
     * Свойство для хранения данных об отношении типа ownsMany
     *
     * @var string
     */
    protected $ownsMany;

    /**
     * Свойство для хранения данных об отношении типа hasMany
     *
     * @var string
     */
    protected $hasMany;

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
    //protected $tablePostfix = null;

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
     * @param string $alias
     */
    public function __construct($section, $alias = 'default')
    {
        $this->db = DB::factory($alias);
        $this->section = $section;
        $this->table = $this->section() . '_' .$this->className; // . $this->tablePostfix;
        //$this->relationTable = $this->section() . '_' .$this->name() . '_' . $this->relationPostfix;
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
            $has = $this->getHas();
            $owns = $this->getOwns();
            $hasMany = $this->getHasMany();
            $ownsMany = $this->getOwnsMany();
            $common = array_merge($has, $owns, array(0 => $hasMany), array(0 => $ownsMany));

            $raw_data = array();

            foreach ($common as $key => $val) {
                if (isset($val['key']) && !empty($fields[$val['key']])) {
                    $key = $val['key'];
                    $module = isset($val['module']) ? $val['module'] : $this->name;

                    fileLoader::load($module . '/mappers/' . $val['mapper']);

                    $mapper = new $val['mapper']($val['section']);

                    $mapper->save($fields[$key]);

                    $map = $fields[$key]->map();
                    $accessor = $map[$val['field']]['accessor'];

                    $raw_data[$key] = $fields[$key]->$accessor();
                }
            }


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

            $split = $raw_data + $fields;

            $stmt->bindArray($split);
            $id = $stmt->execute($this->db->getAlias());

            $row = $this->searchByField($this->tableKey, $id);

            $this->createItemFromRow($row, $object);
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
            $has = $this->getHas();
            $owns = $this->getOwns();
            $hasMany = $this->getHasMany();
            $ownsMany = $this->getOwnsMany();
            $common = array_merge($has, $owns, array(0 => $hasMany), array(0 => $ownsMany));

            $raw_data = array();

            foreach ($common as $key => $val) {
                if (isset($val['key']) && !empty($fields[$val['key']])) {
                    $key = $val['key'];
                    $module = isset($val['module']) ? $val['module'] : $this->name;

                    fileLoader::load($module . '/mappers/' . $val['mapper']);

                    $mapper = new $val['mapper']($val['section']);

                    $mapper->save($fields[$key]);

                    $map = $fields[$key]->map();
                    $accessor = $map[$val['field']]['accessor'];

                    $raw_data[$key] = $fields[$key]->$accessor();
                }
            }

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

            $split = $raw_data + $fields;

            $stmt->bindArray($split);
            $stmt->bindParam(':id', $object->getId(), PDO::PARAM_INT);
            $result = $stmt->execute();

            $row = $this->searchByField($this->tableKey, $object->getId());

            $this->createItemFromRow($row, $object);

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
        $this->setMap($object->map());
        if ($object->getId()) {
            $this->update($object);
        } else {
            $this->insert($object);
        }
    }

    /**
     * Метод для добавления таблиц, с которыми связан текущий ДО
     *
     * @param object $criteria
     * @param string $table имя таблицы, к которой будут присоединяться другие из owns и has
     * @param string $section имя раздела, в контексте которого происходят выборки
     */
    private function addJoins($criteria, $table, $section)
    {
        $this->addSelectFields($criteria);

        $owns = $this->getOwns();

        foreach ($owns as $val) {
            $criterion = new criterion($table . '.' . $val['key'], $val['section'] . '_' . $val['table'] . '.' . $val['field'], criteria::EQUAL, true);
            $criteria->addJoin($val['section'] . '_' . $val['table'], $criterion);

            $module = isset($val['module']) ? $val['module'] : $this->name;

            fileLoader::load($module . '/mappers/' . $val['mapper']);

            $mapper = new $val['mapper']($val['section']);

            $mapper->addJoins($criteria, $val['table'], $section);
        }

        $has = $this->getHas();

        foreach ($has as $val) {
            $criterion = new criterion($table . '.' . $val['relate'], $val['section'] . '_' . $val['table'] . '.' . $val['field'], criteria::EQUAL, true);
            $criteria->addJoin($val['section'] . '_' . $val['table'], $criterion);

            $module = isset($val['module']) ? $val['module'] : $this->name;

            fileLoader::load($module . '/mappers/' . $val['mapper']);

            $mapper = new $val['mapper']($val['section']);

            $mapper->addJoins($criteria, $val['table'], $section);
        }

        $ownsMany = $this->getOwnsMany();
        // проверяем - есть ли отношения типа ownsMany
        if (!empty($ownsMany)) {
            $criterion = new criterion($table . '.' . $ownsMany['key'], $ownsMany['section'] . '_' . $ownsMany['table'] . '.' . $ownsMany['field'], criteria::EQUAL, true);
            $criteria->addJoin($ownsMany['section'] . '_' . $ownsMany['table'], $criterion);

            $module = isset($ownsMany['module']) ? $ownsMany['module'] : $this->name;

            fileLoader::load($module . '/mappers/' . $ownsMany['mapper']);

            $mapper = new $ownsMany['mapper']($ownsMany['section']);

            $mapper->addJoins($criteria, $ownsMany['table'], $section);

        } else {
            // или hasMany
            $hasMany = $this->getHasMany();

            if (!empty($hasMany)) {
                $criterion = new criterion($table . '.' . $hasMany['relate'], $hasMany['section'] . '_' . $hasMany['table'] . '.' . $hasMany['field'], criteria::EQUAL, true);
                $criteria->addJoin($hasMany['section'] . '_' . $hasMany['table'], $criterion);

                $module = isset($hasMany['module']) ? $hasMany['module'] : $this->name;

                fileLoader::load($module . '/mappers/' . $hasMany['mapper']);

                $mapper = new $hasMany['mapper']($hasMany['section']);

                $mapper->addJoins($criteria, $hasMany['table'], $section);
            }
        }
    }

    public function searchByCriteria(criteria $criteria)
    {
        $criteria->setTable($this->table);

        // добавляем в запрос нужные объединения
        $this->addJoins($criteria, $this->table, $this->section);

        $select = new simpleSelect($criteria);
        //var_dump($select->toString());
        $stmt = $this->db->query($select->toString());
        $row = $stmt->fetchAll();
        $result = array();

        // меняем формат данных, чтобы удобнее было работать:
        // # => (класс1 => данные1, класс2 => данные2), ...
        foreach ($row as $key => $val) {
            foreach ($val as $subkey => $subval) {
                if (!is_numeric($subkey)) {
                    $uscorePos = strpos($subkey, '_');
                    $className = substr($subkey, 0, $uscorePos);
                    $keyName = substr($subkey, $uscorePos + 1);
                    $result[$key][$className][$keyName] = $subval;
                }
            }
        }

        return $result;
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

        $result = $this->searchByCriteria($criteria);

        // считаем число данных, если бы не было ограничения LIMIT в запросе (используется в пейджинге). Придётся заменить этот блок кода на обычный запрос без FOUND_ROWS
        /*$criteria_count = new criteria();
        $criteria_count->addSelectField('FOUND_ROWS()', 'count');
        $select_count = new simpleSelect($criteria_count);

        $this->count = $this->db->getOne($select_count->toString());

        if (!empty($this->pager)) {
        $this->pager->setCount($this->count);
        } */

        return $result;
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

    public function searchOneByCriteria($criteria)
    {
        $row = $this->searchByCriteria($criteria);

        $ownsMany = $this->getOwnsMany();
        $hasMany = $this->getHasMany();

        $item = !empty($hasMany) ? $hasMany : $ownsMany;

        if (!empty($item)) {
            $tmp = array();
            foreach ($row as $key => $val) {
                $tmp[] = $val[$item['table']];
            }
            $row[0][$item['table']] = $tmp;
            unset($row[1]);
        }

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
        $criteria = new criteria();
        $criteria->add($name, $value);

        return $this->searchAllByCriteria($criteria);
    }

    public function searchAllByCriteria($criteria)
    {
        $row = $this->searchByCriteria($criteria);
        $result = array();

        $ownsMany = $this->getOwnsMany();
        $hasMany = $this->getHasMany();

        $item = !empty($hasMany) ? $hasMany : $ownsMany;

        if (!empty($item)) {
            $last_obj_id = 0;
            $obj_ids = array();
            $tmp = array();
            foreach ($row as $key => $val) {
                if ($last_obj_id != $val[$this->className]['obj_id']) {

                    $this->collectAndDelete($last_obj_id, $row, $item, $tmp, $obj_ids);

                    unset($tmp);
                    $tmp = array();
                    unset($obj_ids);
                    $obj_ids = array();
                    $last_obj_id = $val[$this->className]['obj_id'];
                }
                $tmp[] = $val[$item['table']];
                $obj_ids[] = $key;
            }

            $this->collectAndDelete($last_obj_id, $row, $item, $tmp, $obj_ids);
        }

        foreach ($row as $val) {
            $result[] = $this->createItemFromRow(array(0 => $val));
        }

        return $result;
    }

    /**
     * Метод, предназначенный для сборки данных присоединяемых таблиц в отношениях ownsMany и hasMany
     *
     * @param integer $last_obj_id obj_id последнего просмотренного объекта
     * @param array $row исходные (сырые) данные
     * @param array $item массив с информацией об объединении (имя таблицы, маппер, поле, ...)
     * @param array $tmp массив для временного хранения собранных данных
     * @param array $obj_ids массив с obj_id просмотренных записей
     */
    private function collectAndDelete($last_obj_id, &$row, $item, $tmp, $obj_ids)
    {
        if ($last_obj_id != 0) {
            $row[$obj_ids[0]][$item['table']] = $tmp;
            foreach ($obj_ids as $subkey => $id) {
                if ($subkey > 0) {
                    unset($row[$id]);
                }
            }
        }
    }

    /**
     * метод поиска полей связанных объектов и присваивание вложенного объекта свойству родительского объекта
     *
     * @param array $f
     * @param string $parent
     * @return array
     */
    public function fill($row)
    {
        //var_dump($row);
        foreach (array($this->getOwns(), $this->getHas()) as $item) {
            foreach ($item as $val) {
                $mapper = new $val['mapper']($this->section);
                $row[0][$this->className][$val['key']] = $mapper->createItemFromRow($row);
            }
        }

        $ownsMany = $this->getOwnsMany();
        $hasMany = $this->getHasMany();

        $item = !empty($hasMany) ? $hasMany : $ownsMany;

        if (!empty($item)) {
            $mapper = new $item['mapper']($this->section);
            if (isset($row[0][$this->className][$item['key']])) {
                unset($row[0][$this->className][$item['key']]);
            }
            //var_dump($item);
            //var_dump($row[0]);
            foreach ($row[0][$item['table']] as $key => $val) {
                $row[0][$this->className][$item['key']][] = $mapper->createItemFromRow(array(0 => array($item['table'] => $val)));
            }
        }
        $map = $this->getMap();

        $result = array();

        foreach ($map as $key => $val) {
            $result[$key] = $row[0][$this->className][$key];
        }

        return $result;
    }

    /**
     * Создает ДО из массива
     *
     * @param array $row
     * @return object
     */
    protected function createItemFromRow($row, $domainObject = null)
    {
        if (empty($domainObject)) {
            $map = $this->getMap();
            $domainObject = new $this->className($map);
        }
        $row = $this->fill($row);
        $domainObject->import($row);
        return $domainObject;
    }

    /**
     * Метод для установки содержимого map-файла (используется для тестирования)
     *
     * @param array $map
     */
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
            $this->map['obj_id']  = array('name' => 'obj_id', 'accessor' => 'getObjId', 'mutator' => 'setObjId');
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
     * Метод для преобразования пути до конкретного объекта в obj_id
     *
     * @param unknown_type $args
     * @return unknown
     */
    public function convertArgsToId($args)
    {
        return (int)$args;
    }

    /**
     * Метод для добавления в $criteria перечисления всех выбираемых полей
     *
     * @param object $criteria
     */
    private function addSelectFields($criteria)
    {
        $map = $this->getMap();
        foreach ($map as $key => $val) {
            if (!isset($val['has']) && !isset($val['hasMany'])) {
                $criteria->addSelectField($this->table . '.' . $key, $this->className . '_' . $key);
            }
        }
    }

    /**
     * Метод получения массива с информацией о присоединяемых таблицах, тип owns
     *
     * @return array
     */
    private function getOwns()
    {
        if (empty($this->owns)) {
            $this->owns = array();

            $map = $this->getMap();
            foreach ($map as $key => $val) {
                if (isset($val['owns'])) {
                    $tableName = substr($val['owns'], 0, strpos($val['owns'], '.'));
                    $foreignKeyName = substr(strrchr($val['owns'], '.'), 1);
                    $className = $tableName . 'Mapper';

                    $joinSection = isset($val['section']) ? $val['section'] : $this->section;

                    $data = array('table' => $tableName, 'field' => $foreignKeyName, 'mapper' => $className, 'key' => $key, 'section' => $joinSection);

                    if (isset($val['module'])) {
                        $data['module'] = $val['module'];
                    }

                    $this->owns[] = $data;
                }
            }
        }

        return $this->owns;
    }

    /**
     * Метод получения массива с информацией о присоединяемых таблицах, тип рфы
     *
     * @return array
     */
    private function getHas()
    {
        if (empty($this->has)) {
            $this->has = array();

            $map = $this->getMap();
            foreach ($map as $key => $val) {
                if (isset($val['has'])) {
                    $parts = explode('->', $val['has'], 2);

                    $relationField = $parts[0];

                    $parts = explode('.', $parts[1], 2);

                    $tableName = $parts[0];
                    $foreignKeyName = $parts[1];
                    $className = $tableName . 'Mapper';

                    $joinSection = isset($val['section']) ? $val['section'] : $this->section;

                    $data = array('table' => $tableName, 'field' => $foreignKeyName, 'mapper' => $className, 'key' => $key, 'relate' => $relationField, 'section' => $joinSection);

                    if (isset($val['module'])) {
                        $data['module'] = $val['module'];
                    }

                    $this->has[] = $data;
                }
            }
        }

        return $this->has;
    }

    private function getOwnsMany()
    {
        if (empty($this->ownsMany)) {
            $map = $this->getMap();
            foreach ($map as $key => $val) {
                if (isset($val['ownsMany'])) {
                    $tableName = substr($val['ownsMany'], 0, strpos($val['ownsMany'], '.'));
                    $foreignKeyName = substr(strrchr($val['ownsMany'], '.'), 1);
                    $className = $tableName . 'Mapper';

                    $joinSection = isset($val['section']) ? $val['section'] : $this->section;

                    $data = array('table' => $tableName, 'field' => $foreignKeyName, 'mapper' => $className, 'key' => $key, 'section' => $joinSection);

                    if (isset($val['module'])) {
                        $data['module'] = $val['module'];
                    }

                    $this->ownsMany = $data;

                    break;
                }
            }
        }

        return $this->ownsMany;
    }

    private function getHasMany()
    {
        if (empty($this->hasMany)) {
            $map = $this->getMap();
            foreach ($map as $key => $val) {
                if (isset($val['hasMany'])) {
                    $parts = explode('->', $val['hasMany'], 2);

                    $relationField = $parts[0];

                    $parts = explode('.', $parts[1], 2);

                    $tableName = $parts[0];
                    $foreignKeyName = $parts[1];
                    $className = $tableName . 'Mapper';

                    $joinSection = isset($val['section']) ? $val['section'] : $this->section;

                    $data = array('table' => $tableName, 'field' => $foreignKeyName, 'mapper' => $className, 'key' => $key, 'relate' => $relationField, 'section' => $joinSection);
                    //var_dump($data);

                    if (isset($val['module'])) {
                        $data['module'] = $val['module'];
                    }

                    $this->hasMany = $data;

                    break;
                }
            }

            if (!empty($this->hasMany)) {
                $ownsMany = $this->getOwnsMany();
                if (!empty($ownsMany)) {
                    throw new mzzRuntimeException('Отношения hasMany и ownsMany не могут быть использованы в одной таблице одновременно');
                }
            }
        }

        return $this->hasMany;
    }
}

?>