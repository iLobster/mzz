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

fileLoader::load('db/sqlFunction');
fileLoader::load('db/sqlOperator');
fileLoader::load('db/simpleSelect');
fileLoader::load('acl');

/**
 * simpleMapper: реализация общих методов у Mapper
 *
 * @package modules
 * @subpackage simple
 * @version 0.3.13
 */

abstract class simpleMapper
{
    /**
     * Константа, определяющая разделитель между именем сущности и именем поля в алиасах для полей в запросах
     *
     */
    const TABLE_KEY_DELIMITER = '___';

    /**
     * Ссылка на объект Базы Данных
     *
     * @var object
     */
    protected $db;

    /**
     * Имя таблицы модуля (состоит из секция_имяКласса)
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

    private $langFields = array();

    private $langTablePostfix = '_lang';

    private $langIdField = 'lang_id';

    /**
     * Свойство для хранения информации об отношениях
     *
     * @var array
     */
    protected $relations;

    /**
     * Поле в таблице для хранения уникального идентификатора доменного объекта
     * Если это поле используется в других целях переопределяйте его в наследуемом классе
     *
     * @var string
     */
    protected $obj_id_field = "obj_id";

    /**
     * Объект класса simpleSelect, через который происходит экранирование полей, таблиц, алиасов и значений
     *
     * @var simpleSelect
     */
    protected $simpleSelect;

    /**
     * Объект класса simpleSelect, через который происходит экранирование полей, таблиц, алиасов и значений
     *
     * @var string
     */
    protected $simpleSelectName = 'simpleSelect';

    /**
     * Алиас соединения к БД
     *
     * @var string
     */
    protected $dbAlias = 'default';

    /**
     * Конструктор
     *
     * @param string $section секция
     */
    public function __construct($section)
    {
        $this->db = DB::factory($this->dbAlias);
        $this->section = $section;

        $this->table = $this->section . '_' .$this->className;

        if (!class_exists($this->simpleSelectName)) {
            fileLoader::load('db/' . $this->simpleSelectName);
        }

        $this->simpleSelect = new $this->simpleSelectName(new criteria());
    }

    /**
     * Возвращает таблицу
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Возвращает ключ таблицы
     *
     * @return string
     */
    public function getTableKey()
    {
        return $this->tableKey;
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
     * Получение имени класса, обслуживаемого маппером
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Использовать или нет obj_id
     *
     * @return boolean
     */
    public function isObjIdEnabled()
    {
        return !is_null($this->obj_id_field);
    }

    /**
     * Если у объекта имеется идентификатор, то выполняется
     * обновление объекта, иначе выполняется вставка объекта в БД
     *
     * @param object $object
     * @param user $user пользователь, который будет зарегистрирован в ACL как владелец объекта
     */
    public function save($object, $user = null)
    {
        if ($object->getId()) {
            $this->update($object);
        } else {
            $this->insert($object, $user);
        }
    }

    /**
     * Выполняет вставку объекта $object в таблицу.
     * Данные экспортируются из объекта в массив, который передается
     * в метод self::insertDataModify(), после генерируется и
     * выполняется SQL-запрос для совершения операции вставки.
     * В завершении возвращается переданный объект с новыми данными
     *
     * @param simple $object
     * @param user $user пользователь, который будет зарегистрирован в ACL как владелец объекта
     */
    protected function insert(simple $object, $user = null)
    {
        $toolkit = systemToolkit::getInstance();

        if ($this->isObjIdEnabled()) {
            $object->setObjId($toolkit->getObjectId());
        }

        $fields_lang_independent =& $object->export();

        if (sizeof($fields_lang_independent) > 1) {
            $this->replaceRelated($fields_lang_independent, $object);
            $this->insertDataModify($fields_lang_independent);

            $lang_fields = $this->getLangFields();
            $markers = '';
            $markers_lang = '';
            $field_names = '';
            $field_names_lang = '';
            foreach (array_keys($fields_lang_independent) as $val) {
                if (in_array($val, $lang_fields)) {
                    $markers_string =& $markers_lang;
                    $field_names_link =& $field_names_lang;
                } else {
                    $markers_string =& $markers;
                    $field_names_link =& $field_names;
                }

                $field_names_link .= $this->simpleSelect->quoteField($val) . ', ';

                if($fields_lang_independent[$val] instanceof sqlFunction || $fields_lang_independent[$val] instanceof sqlOperator) {
                    $fields_lang_independent[$val] = $fields_lang_independent[$val]->toString($this->simpleSelect);
                    $markers_string .= $fields_lang_independent[$val] . ', ';
                    unset($fields_lang_independent[$val]);
                } else {
                    $markers_string .= ':' . $val . ', ';
                }
            }

            $field_names = substr($field_names, 0, -2);

            $markers = substr($markers, 0, -2);

            // перемещаем языкозависимые поля из общего массива
            $fields_lang_dependent = array();
            foreach ($lang_fields as $item) {
                $fields_lang_dependent[$item] = $fields_lang_independent[$item];
                unset($fields_lang_independent[$item]);
            }

            //$field_names = implode(', ', array_map(array($this->simpleSelect, 'quoteField'), array_keys($fields_lang_independent)));

            // вставляем языконезависимые данные
            $stmt = $this->db->prepare('INSERT INTO ' . $this->simpleSelect->quoteTable($this->table) . ' (' . $field_names . ') VALUES (' . $markers . ')');
            $stmt->bindValues($fields_lang_independent);
            $id = $stmt->execute();

            if ($lang_fields) {
                $fields_lang_dependent[$this->langIdField] = $this->getLangId();
                $fields_lang_dependent[$this->tableKey] = $id;

                //$field_names_lang .= $this->simpleSelect->quoteField($this->langIdField);

                $markers_lang .= ':' . $this->langIdField . ', :' . $this->tableKey;

                $field_names_lang = implode(', ', array_map(array($this->simpleSelect, 'quoteField'), array_keys($fields_lang_dependent)));

                // вставляем языкозависимые данные
                $stmt_i18n = $this->db->prepare('INSERT INTO ' . $this->simpleSelect->quoteTable($this->table . $this->langTablePostfix) . ' (' . $field_names_lang . ') VALUES (' . $markers_lang . ')');
                $stmt_i18n->bindValues($fields_lang_dependent);
                $stmt_i18n->execute();
            }

            $criteria = new criteria();
            $this->selectDataModify($selectFields);

            if (is_array($selectFields)) {
                foreach ($selectFields as $key => $val) {
                    $criteria->addSelectField($val, $key);
                }
            }

            $criteria->add($this->className . '.' . $this->tableKey, $id);

            $stmt = $this->searchByCriteria($criteria);

            $fields = $stmt->fetch();

            $data = $this->fillArray($fields);

            $this->afterInsert($data);

            $object->import($data);

            if (!is_null($user)) {
                $tmp = $toolkit->setUser($user);
            }

            if ($this->isObjIdEnabled()) {
                $this->register($object->getObjId());
            }

            if (!is_null($user)) {
                $toolkit->setUser($tmp);
            }
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
            $this->updateDataModify($fields);

            $lang_fields = $this->getLangFields();

            $query = '';
            $query_lang = '';
            foreach (array_keys($fields) as $val) {
                if (in_array($val, $lang_fields)) {
                    $query_string =& $query_lang;
                } else {
                    $query_string =& $query;
                }

                if($fields[$val] instanceof sqlFunction || $fields[$val] instanceof sqlOperator) {
                    $fields[$val] = $fields[$val]->toString($this->simpleSelect);
                    $query_string .= $this->simpleSelect->quoteField($val) . ' = ' . $fields[$val] . ', ';
                    unset($fields[$val]);
                } else {
                    $query_string .= $this->simpleSelect->quoteField($val) . ' = :' . $val . ', ';
                }
            }
            $query = substr($query, 0, -2);

            // перемещаем языкозависимые поля из общего массива
            $fields_lang_dependent = array();
            foreach ($lang_fields as $item) {
                $fields_lang_dependent[$item] = $fields[$item];
                unset($fields[$item]);
            }

            if ($query) {
                $stmt = $this->db->prepare('UPDATE ' . $this->simpleSelect->quoteTable($this->table) . ' SET ' . $query . ' WHERE ' . $this->simpleSelect->quoteField($this->tableKey) . ' = :id');

                $stmt->bindValues($fields);
                $stmt->bindValue(':id', $object->getId(), PDO::PARAM_INT);
                $result = $stmt->execute();
            }

            if ($lang_fields) {
                $query_lang = substr($query_lang, 0, -2);

                $fields_lang_dependent[$this->langIdField] = $this->getLangId();
                $fields_lang_dependent[$this->tableKey] = $object->getId();
                $stmt_i18n = $this->db->prepare('UPDATE ' . $this->simpleSelect->quoteTable($this->table . $this->langTablePostfix) . ' SET ' . $query_lang . ' WHERE ' . $this->simpleSelect->quoteField($this->tableKey) . ' = :id AND ' . $this->simpleSelect->quoteField($this->langIdField) . ' = :lang_id');
                $stmt_i18n->bindValues($fields_lang_dependent);
                $stmt_i18n->execute();
            }

            $criteria = new criteria();
            $this->selectDataModify($selectFields);

            if(is_array($selectFields)) {
                foreach ($selectFields as $key => $val) {
                    $criteria->addSelectField($val, $key);
                }
            }

            $criteria->add($this->tableKey, $object->getId());
            $stmt = $this->searchByCriteria($criteria);

            $fields = $stmt->fetch();

            $data = $this->fillArray($fields);

            $this->afterUpdate($data);

            $object->import($data);

            return true;
        }

        return false;
    }

    /**
     * Метод регистраци объекта в ACL (при создании)
     *
     * @param integer $obj_id уникальный идентификатор объекта
     * @param string $section имя раздела
     * @param string $className имя класса
     */
    public function register($obj_id, $section = null, $className = null)
    {
        if (is_null($className)) {
            $className = $this->className;
        }

        if (is_null($section)) {
            $section = $this->section();
        }

        $toolkit = systemToolkit::getInstance();
        $acl = new acl($toolkit->getUser());
        $acl->register($obj_id, $className, $section);
    }

    /**
     * Выполняет удаление объекта из БД
     *
     * @param integer|simple $id
     * @return mixed
     */
    public function delete($id)
    {
        if ($id instanceof simple) {
            $id = $id->getId();
        } elseif (!is_scalar($id)) {
            throw new mzzRuntimeException('Wrong id or object');
        }

        $toolkit = systemToolkit::getInstance();
        $object = $this->searchOneByField($this->tableKey, $id);

        if ($object && $this->isObjIdEnabled()) {
            $acl = new acl($toolkit->getUser());
            $acl->delete($object->getObjId());
        }

        $stmt = $this->db->prepare('DELETE FROM ' . $this->simpleSelect->quoteTable($this->table) . ' WHERE ' . $this->simpleSelect->quoteField($this->tableKey) . ' = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // если есть языкозависимые поля - то удаляем и их из связанной таблицы
        if ($this->getLangFields()) {
            $stmt_i18n = $this->db->prepare('DELETE FROM ' . $this->simpleSelect->quoteTable($this->table . $this->langTablePostfix) . ' WHERE ' . $this->simpleSelect->quoteField($this->tableKey) . ' = :id');
            $stmt_i18n->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_i18n->execute();
        }

        return $stmt->execute();
    }


    /**
     * Метод для изменения формата массива в удобную для работы форму
     *
     * @param array $array
     * @param string $name имя запрашиваемого ДО
     * @return array
     */
    public function fillArray(&$array, $name = null)
    {
        $tmp = array();
        foreach ($array as $key => $val) {
            $exploded = explode(self::TABLE_KEY_DELIMITER, $key, 2);
            if (isset($exploded[1])) {
                list($class, $field) = $exploded;
                $tmp[$class][$field] = $val;
            }
        }

        $toolkit = systemToolkit::getInstance();

        foreach ($this->getOwns() as $key => $val) {
            $mapper = $toolkit->getMapper($val['module'], $val['class'], $val['section']);
            $tmp[$this->className][$key] = $mapper->createItemFromRow($tmp[$key]);
        }

        return is_null($name) ? $tmp[$this->className] : $tmp[$name];
    }


    /**
     * Метод для добавления в запрос присоединений
     *
     * @param criteria $criteria
     */
    protected function addJoins(criteria $criteria)
    {
        $toolkit = systemToolkit::getInstance();

        $this->addSelectFields($criteria, $this->getMap(), $this->table, $this->className);

        foreach ($this->getOwns() as $key => $val) {
            $mapper = $toolkit->getMapper($val['module'], $val['class'], $val['section']);

            $this->addSelectFields($criteria, $mapper->getMap(), $val['class'], $key);

            $joinCriterion = new criterion($this->className . '.' . $key, $key . '.' . $val['key'], criteria::EQUAL, true);

            //$criteria->addJoin($val['table'], $joinCriterion, $key, $val['join_type']);
            $criteria->addJoin($mapper->getTable(), $joinCriterion, $key, $val['join_type']);
        }
    }

    /**
     * Поиск записи по ключу таблицы
     *
     * @param integer $id идентификатор записи
     * @return object simple
     */
    public function searchByKey($id)
    {
        return $this->searchOneByField($this->tableKey, $id);
    }

    /**
     * Поиск записей по ключам таблицы
     *
     * @param array $keys идентификатор записи
     * @return object simple
     */
    public function searchByKeys($ids)
    {
        $criteria = new criteria();
        $criteria->add($this->tableKey, $ids, criteria::IN);

        return $this->searchAllByCriteria($criteria);
    }

    /**
     * Поиск записей по критерию
     *
     * @param criteria $criteria заданный критерий
     * @return object PDOStatement
     */
    protected function searchByCriteria(criteria $criteria_outer)
    {
        $criteria = new criteria();
        $this->addJoins($criteria);
        $criteria->setTable($this->table, $this->className);

        $criteria->append($criteria_outer);

        // если есть пейджер - то посчитать записи без LIMIT и передать найденное число записей в пейджер
        if ($this->pager) {
            $this->count($criteria);
        }

        $this->addLangCriteria($criteria);

        $this->addOrderBy($criteria);

        $select = new $this->simpleSelectName($criteria);
        //echo '<br><pre>'; var_dump($select->toString()); echo '<br></pre>';
        $stmt = $this->db->query($select->toString());

        return $stmt;
    }

    private function addLangCriteria(criteria $criteria)
    {
        $lang_id = $this->getLangId();
        $lang_fields = $this->getLangFields();
        // если есть языкозависимые поля
        if (sizeof($lang_fields)) {
            $lang_tablename = $this->table . $this->langTablePostfix;
            $alias = $this->className . $this->langTablePostfix;

            // добавляем объединение с таблицей интернационализации
            $criterion = new criterion($this->className . '.' . $this->tableKey, $alias . '.' . $this->tableKey, criteria::EQUAL, true);
            $criterion->addAnd(new criterion($alias . '.' . $this->langIdField, $lang_id));

            $criteria->addJoin($lang_tablename, $criterion, $alias, criteria::JOIN_INNER);
        }
    }

    protected function count($criteria)
    {
        $criteriaForCount = clone $criteria;
        $criteriaForCount->clearSelectFields()->addSelectField(new sqlFunction('count', '*', true), 'cnt');
        $selectForCount = new simpleSelect($criteriaForCount);

        $this->pager->setCount($this->db->getOne($selectForCount->toString()));

        $criteria->append($this->pager->getLimitQuery());

        $this->removePager();
    }

    /**
     * Метод добавления к текущему критерию правил сортировки из map
     *
     * @param criteria $criteria
     */
    protected function addOrderBy($criteria)
    {
        // добавляем сортировку
        $orderBy = array();
        foreach ($this->map as $key => $val) {
            if (isset($val['orderBy'])) {
                if (!is_numeric($val['orderBy'])) {
                    throw new mzzInvalidParameterException('Параметр orderBy в ' . $this->className . '.ini должен быть целым числом', $val['orderBy']);
                }

                $orderBy[$val['orderBy']] = array('field' => $key, 'direction' => (isset($val['orderByDirection']) ? strtolower($val['orderByDirection']) : 'asc'));
            }
        }

        ksort($orderBy);

        foreach ($orderBy as $val) {
            if (isset($val['direction']) && $val['direction'] === 'desc') {
                $criteria->setOrderByFieldDesc($val['field']);
            } else {
                $criteria->setOrderByFieldAsc($val['field']);
            }
        }
    }

    /**
     * Возвращает Доменный Объект, который обслуживает запрашиваемый маппер
     *
     * @return object
     */
    public function create()
    {
        if (!$this->map) {
            $this->map = $this->getMap();
        }

        $object = new $this->className($this, $this->map);
        $object->section($this->section());
        return $object;
    }

    /**
     * Заполняет данными из массива доменный объект
     *
     * @param array $row массив с данными
     * @return object
     */
    public function createItemFromRow($row)
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
            $this->createItemFromRow($data);

            $key = $data[$this->tableKey];

            if ($key instanceof simple) {
                $owns = $this->getOwns();
                if (isset($owns[$this->tableKey])) {
                    $foreign_key = $owns[$this->tableKey]['key'];
                    $foreign_map = $key->getMap();
                    $accessor = $foreign_map[$foreign_key]['accessor'];

                    $key = $key->$accessor();
                }
            }

            $result[$key] = $this->createItemFromRow($data);
        }

        return $result;
    }

    /**
     * Поиск всех записей
     *
     * @param criteria $orderCriteria
     * @return PDOStatement
     */
    public function searchAll($orderCriteria = null)
    {
        $criteria = new criteria();
        if (!is_null($orderCriteria)) {
            $criteria->append($orderCriteria);
        }
        return $this->searchAllByCriteria($criteria);
    }

    private function addSelectFields(criteria $criteria, $map, $table, $alias)
    {
        $lang_fields = $this->getLangFields();

        foreach ($map as $key => $val) {
            if (!isset($val['hasMany'])) {
                if (in_array($key, $lang_fields)) {
                    $criteria->addSelectField($alias . $this->langTablePostfix . '.' . $key, $alias . self::TABLE_KEY_DELIMITER . $key);
                } else {
                    $criteria->addSelectField($alias . '.' . $key, $alias . self::TABLE_KEY_DELIMITER . $key);
                }
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
     * @param boolean $refresh при значении true происходит обновление map
     * @return array
     */
    public function getMap($refresh = false)
    {
        if (empty($this->map) || $refresh) {
            $mapFileName = fileLoader::resolve($this->name() . '/maps/' . $this->className . '.map.ini');
            $this->map = parse_ini_file($mapFileName, true);
            $this->addObjId($this->map);
        }
        return $this->map;
    }

    protected function getLangId()
    {
        return systemToolkit::getInstance()->getLang();
    }

    public function getLangFields()
    {
        if (empty($this->langFields)) {
            $map = $this->getMap();
            foreach ($map as $item) {
                if (!empty($item['lang'])) {
                    $this->langFields[] = $item['name'];
                }
            }
        }

        return $this->langFields;
    }

    /**
     * Метод добавления служебного поля obj_id к схеме данных
     *
     * @param array $map
     */
    public function addObjId(&$map)
    {
        if (!isset($map[$this->obj_id_field]) && $this->isObjIdEnabled()) {
            $map[$this->obj_id_field] = array('name' => $this->obj_id_field, 'accessor' => 'getObjId', 'mutator' => 'setObjId', 'once' => 'true');
        }
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
     * Выполнение операций с массивом $fields после обновления в БД
     *
     * @param array $fields
     */
    protected function selectDataModify(&$fields)
    {
    }

    /**
     * Хук, вызываемый сразу же после добавления объекта в БД
     *
     * @param array $fields
     */
    protected function afterInsert(&$fields)
    {
    }

    /**
     * Хук, вызываемый сразу же после обновления объекта в БД
     *
     * @param array $fields
     */
    protected function afterUpdate(&$fields)
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

    public function removePager()
    {
        $this->pager = null;
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
     * Метод для разбора массива данных о связях
     *
     * @param array $val
     * @return array
     */
    private function explodeRelateData($val)
    {
        list($tableName, $fieldName) = explode('.', $val['relate'], 2);
        $className = $tableName;

        if (isset($val['do'])) {
            $className =  $val['do'];
        }

        $sectionName = isset($val['section']) ? $val['section'] : $this->section();
        $moduleName = isset($val['module']) ? $val['module'] : $this->name();

        $join_type = criteria::JOIN_LEFT;
        if (isset($val['join_type'])) {
            $valid_join_types = array('left', 'inner');
            if (array_search($val['join_type'], $valid_join_types)) {
                $join_type = criteria::JOIN_INNER;
            }
        }

        return array($tableName, $fieldName, $className, $sectionName, $moduleName, $join_type);
    }

    /**
     * Метод получения данных об отношениях типа owns
     *
     * @return array
     */
    private function getOwns()
    {
        if (!isset($this->relations['owns'])) {
            $this->relations['owns'] = array();
            foreach ($this->getMap() as $key => $val) {
                if (isset($val['owns'])) {
                    $val['relate'] = $val['owns'];
                    list($tableName, $fieldName, $className, $sectionName, $moduleName, $joinType) = $this->explodeRelateData($val);

                    $this->relations['owns'][$key] = array('section' => $sectionName, 'table' => $sectionName . '_' . $tableName, 'key' => $fieldName, 'module' => $moduleName, 'class' => $className, 'join_type' => $joinType);
                }
            }
        }

        return $this->relations['owns'];
    }

    /**
     * Метод для получения данных об отношениях типа hasMany
     *
     * @return array
     */
    public function getHasMany()
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

    /**
     * Метод получения данных о связях конкретного поля
     *
     * @param string $key
     * @return array|boolean массив данных или false, если таковых не имеется
     */
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

                // проверяем что передан объект нужного типа
                if (!($val instanceof $className)) {
                    $mutator = $map[$key]['mutator'];
                    throw new mzzInvalidParameterException('С помощью мутатора ' . $mutator . ' должен быть передан объект типа ' . $className . ', однако передан объект', $val);
                }

                // получаем нужный маппер
                //$toolkit = systemToolkit::getInstance();
                //$mapper = $toolkit->getMapper($moduleName, $className, $sectionName);
                $mapper = $val->getMapper();

                // сохраняем связанный объект
                $mapper->save($val);

                // получаем схему связанного объекта
                $relatedMap = $mapper->getMap();

                // из полученной схемы получаем имя акцессора к методу, по которому получаем данные, по которым связываем этот объект с главным
                $accessor = $relatedMap[$fieldName]['accessor'];

                // делаем вызов полученного акцессора и заменяем объект на строку
                $fields[$key] = $val->$accessor();

                // отмечаем, что это поле уже было сохранено
                $saved[$key] = true;
            } elseif (isset($map[$key]['hasMany'])) {
                // проверяем что передан массив
                if (!is_array($val)) {
                    $mutator = $map[$key]['mutator'];
                    throw new mzzInvalidParameterException('С помощью мутатора ' . $mutator . ' должен быть передан массив, однако передано ', $val);
                }

                $accessor = $map[$key]['accessor'];
                $oldData = $object->$accessor();

                $oldObjIds = array();
                foreach ($oldData as $subval) {
                    $oldObjIds[$subval->getId()] = $subval->getId();
                }

                $sectionName = $hasMany[$key]['section'];
                $className = $hasMany[$key]['class'];
                $fieldName = $hasMany[$key]['key'];
                $moduleName = $hasMany[$key]['module'];
                $thisField = $hasMany[$key]['field'];

                // определяем записи, которых нет в новом массиве
                foreach ($val as $subkey => $subval) {
                    // проверяем что каждый из элементов массива нужного типа
                    if (!($subval instanceof $className)) {
                        throw new mzzInvalidParameterException('Ожидается элемент массива типа ' . $className . ', однако передан объект', $subval);
                    }

                    if (isset($oldObjIds[$subval->getId()])) {
                        unset($oldObjIds[$subval->getId()]);
                    }
                }

                // получаем нужный маппер
                /*$toolkit = systemToolkit::getInstance();
                $mapper = $toolkit->getMapper($moduleName, $className, $sectionName);*/
                $mapper = $subval->getMapper();

                // получаем схему связанного объекта
                $relatedMap = $mapper->getMap();

                // из полученной схемы получаем имя мутатора к методу, по которому устанавливаем данные, по которым связыываем этот объект с главным
                $mutator = $relatedMap[$fieldName]['mutator'];

                // получаем имя акцессора, по которому возвращается значение поля, по которому происходит связывание
                $accessor = $map[$thisField]['accessor'];

                // удаляем все записи которых нет в новом массиве
                foreach ($oldObjIds as $subval) {
                    $mapper->delete($subval);
                }

                // сохраняем все новые записи
                foreach ($val as $subval) {
                    $subval->$mutator($object->$accessor());
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

    /**
     * Метод для возврата контроллера, обрабатывающего ошибку 404
     *
     * @return simpleController
     *
     * @todo подумать - насколько это плохо
     */
    public function get404()
    {
        fileLoader::load('simple/simple404Controller');
        return new simple404Controller();
    }

    /**
     * Возвращает объекты, находящиеся в данной папке
     *
     * @return array
     */
    public function getItems($id)
    {
        $mapper = systemToolkit::getInstance()->getMapper($this->name, $this->itemName, $this->section);

        if (!empty($this->pager)) {
            $mapper->setPager($this->pager);
        }

        $result = $mapper->searchByFolder($id);

        $this->pager = null;

        return $result;
    }

    /**
     * Абстрактный метод для получения Obj_id конкретного элемента по аргументам
     *
     * @param array $args
     */
    abstract public function convertArgsToObj($args);
}

?>