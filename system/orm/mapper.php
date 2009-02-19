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

fileLoader::load('orm/entity');
fileLoader::load('orm/relation');
fileLoader::load('orm/lazy');
fileLoader::load('orm/collection');
fileLoader::load('orm/observer');
fileLoader::load('db/simpleSelect');
fileLoader::load('db/simpleInsert');
fileLoader::load('db/simpleUpdate');
fileLoader::load('db/simpleDelete');

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

    /**
     * connection to database
     *
     * @var mzzPdo
     */
    private $db;

    private $pk;

    /**
     * relation
     *
     * @var relation
     */
    private $relations;

    private $observers = array();

    protected $class;

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

        if (is_null($this->class)) {
            $this->class = $this->table();
        }
    }

    public function searchOneByCriteria(criteria $criteria)
    {
        $stmt = $this->searchByCriteria($criteria);

        if ($row = $stmt->fetch()) {
            $row = $this->parseRow($row);

            return $this->createItemFromRow($row);
        }

        return null;
    }

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

        return new collection($rows, $this);
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
        $criteria->add($this->pk, $key);
        return $this->searchOneByCriteria($criteria);
    }

    public function searchAllByField($name, $value)
    {
        $criteria = new criteria();
        $criteria->add($name, $value);
        return $this->searchAllByCriteria($criteria);
    }

    public function searchOneByField($name, $value)
    {
        $criteria = new criteria();
        $criteria->add($name, $value);
        return $this->searchOneByCriteria($criteria);
    }

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

        $this->notify('preInsert', $data);

        $criteria = new criteria($this->table);

        $this->notify('preSqlInsert', $criteria);

        $insert = new simpleInsert($criteria);

        $this->db()->query($insert->toString($data));
        $object->import($this->searchByKey($this->db()->lastInsertId())->export());

        $object->state(entity::STATE_CLEAN);

        $this->notify('postInsert', $object);
    }

    private function update(entity $object)
    {
        $accessor = $this->map[$this->pk]['accessor'];

        $this->notify('preUpdate', $object);
        $data = $object->exportChanged();
        $this->notify('preUpdate', $data);

        if ($data) {
            $criteria = new criteria($this->table);
            $criteria->add($this->pk, $object->$accessor());

            $this->notify('preSqlUpdate', $criteria);

            $update = new simpleUpdate($criteria);

            $this->db()->query($update->toString($data));

            $object->import($this->searchByKey($object->$accessor())->export());

            $object->state(entity::STATE_CLEAN);
        }

        $this->notify('postUpdate', $object);
    }

    public function delete($object)
    {
        if (!($object instanceof entity)) {
            $object = $this->searchByKey($object);
        }

        $this->notify('preDelete', $object);

        $criteria = new criteria($this->table);
        $accessor = $this->map[$this->pk]['accessor'];
        $criteria->add($this->pk, $object->$accessor());

        if (!$this->notify('preSqlDelete', $criteria)) {
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
            throw new mzzRuntimeException('The specified plugin doesn\'t attached to current mapper');
        }

        return $this->observers[$name];
    }

    public function plugins($name)
    {
        $tmp = $name;
        $name .= 'Plugin';
        fileLoader::load('orm/plugins/' . $name);
        $this->attach(new $name(), $tmp);
    }

    public function attach(observer $observer, $name = null)
    {
        $observer->setMapper($this);
        if (is_null($name)) {
            $this->observers[] = $observer;
        } else {
            $this->observers[$name] = $observer;
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
        $object = new $this->class();
        $object->setMap($this->map);
        $object->relations($this->relations);
        return $object;
    }

    /**
     * lazy accessor to the database connection
     *
     * @return mzzPdo
     */
    public function db()
    {
        if (!$this->db) {
            $this->db = DB::factory();
        }

        return $this->db;
    }

    public function table()
    {
        return $this->table;
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

    /**
     * searching data with the criteria
     *
     * @param criteria $criteria
     * @return mzzPdoStatement
     */
    private function searchByCriteria(criteria $criteria)
    {
        $this->notify('preSelect', $criteria);

        $criteria->setTable($this->table);
        $this->addSelectFields($criteria);

        $this->relations->add($criteria);

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
            $alias = $mapper->table();
        }

        foreach ($this->getSelectFields($mapper) as $field) {
            $criteria->addSelectField($alias . '.' . $field, $alias . self::TABLE_KEY_DELIMITER . $field);
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

        return $tmp[$this->table];
    }

    public function createItemFromRow($row)
    {
        if (is_null($row[$this->pk])) {
            return null;
        }

        $object = $this->create();
        $object->import($row);
        $object->state(entity::STATE_CLEAN);

        $this->relations->addLazy($object);

        $this->notify('postCreate', $object);

        return $object;
    }
}

?>
