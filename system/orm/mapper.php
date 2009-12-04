<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * mapper: implementation of the Data Mapper pattern
 *
 * @package system
 * @subpackage orm
 * @version 0.2
 */
abstract class mapper
{
    const TABLE_KEY_DELIMITER = '___';

    protected $map = array();

    protected $pk;

    /**
     * connection to database
     *
     * @var object
     */
    private $db = null;

    /**
     * Alias for db connection
     *
     * @var string
     */
    protected $db_alias = null;

    /**
     * relation
     *
     * @var relation
     */
    protected $relations;

    private $observers = array();

    protected $module;
    protected $class;
    protected $table;
    protected $table_prefix = null;

    public function __construct()
    {
        foreach ($this->map as $key => $value) {
            if (isset($value['options'])) {
                if (in_array('pk', $value['options'])) {
                    $this->pk = $key;
                    break;
                }
            }
        }

        $this->relations = new relation($this);

        if (is_null($this->db_alias)) {
            $this->db_alias = fDB::DEFAULT_CONFIG_NAME;
        }

        if (is_null($this->class)) {
            $this->class = $this->table;
        }

        if (is_null($this->table_prefix)) {
            $this->table_prefix = $this->db()->getTablePrefix();
        }
    }

    /**
     * retrieve entity by criteria
     *
     * @param criteria $criteria
     * @return entity
     */
    public function searchOneByCriteria(criteria $criteria)
    {
        $criteria->limit(1);
        $stmt = $this->searchByCriteria($criteria);

        if ($row = $stmt->fetch()) {
            $row = $this->parseRow($row);

            return $this->createItemFromRow($row);
        }

        return null;
    }

    /**
     * retrieve collection of entities by criteria
     *
     * @param criteria $criteria
     * @return collection
     */
    public function searchAllByCriteria(criteria $criteria)
    {
        $stmt = $this->searchByCriteria($criteria);

        $rows = array();

        $accessor = $this->map[$this->pk]['accessor'];

        while ($row = $stmt->fetch()) {
            $row = $this->parseRow($row);
            $item = $this->createItemFromRow($row);

            $rows[$item->$accessor()] = $item;
        }

        $collection = new collection($rows, $this);

        $this->notify('postCollectionSelect', $collection);

        return $collection;
    }

    /**
     * retrieve entity by primary key
     *
     * @param mixed $key
     * @return entity
     */
    public function searchByKey($key)
    {
        $criteria = new criteria();

        if (is_array($key)) {
            $criteria->where($this->pk, $key, criteria::IN);
            return $this->searchAllByCriteria($criteria);
        } else {
            return $this->searchOneByField($this->pk, $key);
        }
    }

    /**
     * retrieve collection of entities by field value
     *
     * @param string $name
     * @param mixed $value
     * @return collection
     */
    public function searchAllByField($name, $value)
    {
        $criteria = new criteria();
        $criteria->where($name, $value);
        return $this->searchAllByCriteria($criteria);
    }

    /**
     * retrieve entity by field value
     *
     * @param string $name
     * @param mixed $value
     * @return entity
     */
    public function searchOneByField($name, $value)
    {
        $data = array($name, $value);
        if ($this->notify('preSearchOneByField', $data)) {
            return $data;
        }

        $criteria = new criteria();
        $criteria->where($name, $value);
        $criteria->limit(1);
        return $this->searchOneByCriteria($criteria);
    }

    /**
     * retrieve collection of all existing entities
     *
     * @param string $name
     * @param mixed $value
     * @return collection
     */
    public function searchAll()
    {
        return $this->searchAllByCriteria(new criteria());
    }

    public function save(entity $object)
    {
        //@todo: проверка на тип

        if ($object->state() == entity::STATE_NEW) {
            return $this->insert($object);
        } elseif ($object->state()) {
            return $this->update($object);
        }
    }

    private function insert(entity $object)
    {
        $data = $object->exportChanged();
        $this->replaceRelated($data, $object);

        $this->notify('preInsert', $data);

        $criteria = new criteria($this->table());

        $this->notify('preSqlInsert', $criteria);

        $insert = new simpleInsert($criteria);

        $this->db()->query($insert->toString($data));
        $last_id = $this->db()->lastInsertId();
        if ($last_id == 0) {
            $last_id = $data[$this->pk];
        }
        $this->notify('postSqlInsert', $object);

        $object->import($this->searchByKey($last_id)->export());

        $object->state(entity::STATE_CLEAN);

        $this->notify('postInsert', $object);
    }

    private function update(entity $object)
    {
        $accessor = $this->map[$this->pk]['accessor'];

        $this->notify('preUpdate', $object);
        $data = $object->exportChanged();
        $this->replaceRelated($data, $object);
        $this->notify('preUpdate', $data);

        if ($data) {
            $criteria = new criteria($this->table());
            $criteria->where($this->pk, $object->$accessor());

            $this->notify('preSqlUpdate', $criteria);

            $update = new simpleUpdate($criteria);

            $this->db()->query($update->toString($data));
        }

        $object->import($this->searchByKey($object->$accessor())->export());
        $object->state(entity::STATE_CLEAN);

        $this->notify('postUpdate', $object);
    }

    public function delete($object)
    {
        if (!($object instanceof entity)) {
            $object = $this->searchByKey($object);
        }

        $this->notify('preDelete', $object);

        $criteria = new criteria($this->table());
        $accessor = $this->map[$this->pk]['accessor'];
        $criteria->where($this->pk, $object->$accessor());

        if (!$this->notify('preSqlDelete', $criteria)) {
            $this->relations->delete($object);

            $delete = new simpleDelete($criteria);
            $this->db()->query($delete->toString());

            $tmp = array(
                $this->pk() => null);
            $object->merge($tmp);
        }

        $object->state(entity::STATE_NEW);

        $this->notify('postDelete', $object);
    }

    public function plugin($name)
    {
        if (!isset($this->observers[$name])) {
            throw new mzzRuntimeException('The specified "' . $name . '" plugin doesn\'t attached to current mapper');
        }

        return $this->observers[$name];
    }

    public function plugins($name)
    {
        $name .= 'Plugin';
        if (!class_exists($name)) {
            fileLoader::load('orm/plugins/' . $name);
        }

        $this->attach(new $name());
    }

    public function isAttached($name)
    {
        return isset($this->observers[$name]);
    }

    public function attach(observer $observer, $name = null)
    {
        $observer->setMapper($this);
        if (is_null($name)) {
            $name = $observer->getName();
        }

        $this->observers[$name] = $observer;
    }

    public function detach($name)
    {
        if ($this->isAttached($name)) {
            unset($this->observers[$name]);
        }
    }

    public function notify($type, & $data)
    {
        $result = false;
        foreach ($this->observers as $observer) {
            if (is_callable(array(
                $observer,
                $type))) {
                $result |= $observer->$type($data);
            }
        }

        if (is_callable(array(
            $this,
            $type))) {
            $this->$type($data);
        }

        return $result;
    }

    /**
     * creating a new instance of a domain object
     *
     * @return entity
     */
    public function create()
    {
        $object = new $this->class($this);
        $this->notify('preCreate', $object);
        return $object;
    }

    /**
     * lazy accessor to the database connection
     *
     * @return fPdo
     */
    public function db()
    {
        if (is_null($this->db)) {
            $this->db = fDB::factory($this->db_alias);
        }

        return $this->db;
    }

    public function setDBAlias($alias)
    {
        $oldAlias = $this->db_alias;
        $this->db_alias = $alias;
        $this->db = fDB::factory($alias);
        return $oldAlias;
    }

    public function table($withPrefix = true)
    {
        return ($withPrefix ? $this->table_prefix : '') . $this->table;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function setModule($module)
    {
        $this->module = $module;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function map($map = null)
    {
        if (!is_null($map)) {
            $old = $this->map;
            $this->map = $map;
            return $old;
        }

        return $this->map;
    }

    public function pk()
    {
        return $this->pk;
    }

    public function hasOption($field, $name)
    {
        return isset($this->map[$field]['options']) && in_array($name, $this->map[$field]['options']);
    }

    /**
     * searching data with the criteria
     *
     * @param criteria $criteria
     * @return fPdoStatement
     */
    private function searchByCriteria(criteria $searchCriteria)
    {
        $criteria = new criteria();

        $this->notify('preSelect', $criteria);

        $criteria->table($this->table(), $this->table(false));
        $this->addSelectFields($criteria);

        $this->relations->add($criteria, $this);

        $criteria->append($searchCriteria);

        $this->addOrderBy($criteria);

        $this->notify('preSqlSelect', $criteria);

        $select = new simpleSelect($criteria);

        //echo '<pre>'; var_dump($select->toString()); echo '</pre>';

        return $this->db()->query($select->toString());
    }

    public function addSelectFields(criteria $criteria, $mapper = null, $alias = null)
    {
        if (is_null($mapper)) {
            $mapper = $this;
        }

        if (is_null($alias)) {
            $alias = $mapper->table(false);
        }

        foreach ($this->getSelectFields($mapper) as $field) {
            $criteria->select($alias . '.' . $field, $alias . self::TABLE_KEY_DELIMITER . $field);
        }
    }

    public function addOrderBy(criteria $criteria)
    {
        $orderBy = array();
        foreach ($this->map() as $key => $val) {
            if (isset($val['orderBy'])) {
                $direction = 'asc';
                if (isset($val['orderByDirection']) && in_array(strtolower($val['orderByDirection']), array('asc', 'desc'))) {
                    $direction = strtolower($val['orderByDirection']);
                }

                $orderBy[$key] = array('key' => $key, 'direction' => $direction);
            }
        }

        ksort($orderBy);

        foreach ($orderBy as $val) {
            $val['direction'] == 'asc' ? $criteria->orderByAsc($val['key']) : $criteria->orderByDesc($val['key']);;
        }
    }

    private function getSelectFields(mapper $mapper)
    {
        $dont_select = array_merge(array_keys($mapper->relations->oneToMany()), array_keys($mapper->relations->manyToMany()), array_keys($mapper->relations->oneToOneBack()));

        foreach ($mapper->map() as $key => $val) {
            if (isset($val['options']) && in_array('fake', $val['options'])) {
                $dont_select[] = $key;
            }
        }

        return array_diff(array_keys($mapper->map()), $dont_select);
    }

    private function parseRow($row)
    {
        $tmp = array();
        foreach ($row as $key => $val) {
            $exploded = explode(self::TABLE_KEY_DELIMITER, $key);
            list ($class, $field) = $exploded;
            $tmp[$class][$field] = $val;
        }

        $this->relations->retrieve($tmp);

        return $tmp[$this->table(false)];
    }

    public function createItemFromRow($row)
    {
        if ($this->notify('processRow', $row)) {
            return $row;
        }

        if (is_null($row[$this->pk])) {
            return null;
        }

        $object = $this->create();
        $object->merge($row);
        $object->state(entity::STATE_CLEAN);

        $this->notify('postCreate', $object);

        return $object;
    }

    public function getRelations()
    {
        return $this->relations;
    }

    public function replaceRelated(&$dataChanged, entity $object)
    {
        if ($this->relations) {
            $data = $object->export();

            $oneToOne = $this->relations->oneToOne();

            // traverse all one-to-one related fields and if changed - replace them with scalar foreign_key values
            foreach ($oneToOne as $key => $val) {
                if (isset($data[$key]) && $data[$key] instanceof entity) {
                    // if nested related objects are not clean - mark current object as dirty and save related
                    if ($data[$key]->state() != entity::STATE_CLEAN) {
                        $object->state(entity::STATE_DIRTY);
                        $val['mapper']->save($data[$key]);
                        $dataChanged[$key] = $data[$key];
                    }
                }

                // if changed related field is not scalar - replace it with scalar
                if (isset($dataChanged[$key]) && $dataChanged[$key] instanceof entity) {
                    // if changed related field is not clean too - save it
                    if ($dataChanged[$key]->state() != entity::STATE_CLEAN) {
                        $val['mapper']->save($dataChanged[$key]);
                    }
                    $accessor = $val['methods'][0];
                    $dataChanged[$key] = $dataChanged[$key]->$accessor();
                }
            }

            if ($object->state() != entity::STATE_NEW) {
                foreach ($this->relations->oneToOneBack() as $key => $value) {
                    if (isset($dataChanged[$key])) {
                        $accessor = $value['methods'][0];
                        $mutator = $value['methods'][1];

                        if ($dataChanged[$key]->$accessor() != $data[$value['local_key']]) {
                            $dataChanged[$key]->$mutator($data[$value['local_key']]);
                            $value['mapper']->save($dataChanged[$key]);
                            $data[$key] = $dataChanged[$key];
                            unset($dataChanged[$key]);
                        }
                    }
                }
            }

            $oneToMany = $this->relations->oneToMany();
            foreach ($oneToMany as $key => $value) {
                if (isset($data[$key]) && $data[$key] instanceof collection) {
                    $data[$key]->save();
                }
            }

            $manyToMany = $this->relations->manyToMany();
            foreach ($manyToMany as $key => $value) {
                if (isset($data[$key]) && $data[$key] instanceof collection) {
                    $data[$key]->save();
                }
            }

            $object->import($data);
        }
    }

    public function load($field, $data, $args = array())
    {
        if (is_a($data[$field], 'lazy')) {
            return $data[$field]->load($args);
        }

        return $this->relations->load($field, $data, $this);
    }
}

?>