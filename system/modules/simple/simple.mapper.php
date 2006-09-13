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
 * simpleMapper: ���������� ����� ������� � Mapper
 *
 * @package simple
 * @version 0.2.2
 */
abstract class simpleMapper //implements iCacheable
{
    /**
     * ������ �� ������ ���� ������
     *
     * @var object
     */
    protected $db;

    /**
     * ��� ������� ������ (���������� �� �����, ������, ���������)
     *
     * @var string
     */
    protected $table;

    /**
     * ��� ������� ��������� (���������� �� �����, ������, relation-���������)
     *
     * @var string
     */
    protected $relationTable;

    /**
     * Relation-��������
     *
     * @var string
     */
    protected $relationPostfix = 'rel';

    /**
     * ������
     *
     * @var string
     */
    protected $section;

    /**
     * ��� ������
     *
     * @var string
     */
    protected $name;

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className;

    /**
     * ������ ��� �������� ������ �� ��������� 1:1
     * ���� ��� ���������� ���� � �������� �������
     *
     * @var array
     */
    protected $owns;

    protected $ownsMany;
    protected $hasMany;

    /**
     * ������ ��� �������� ������ �� ��������� 1:1
     * ���� ��� ���������� � �������� ������� ���
     *
     * @var array
     */
    protected $has;

    /**
     * ������ �� ������ cache
     *
     * @var object
     */
    //protected $cache;

    /**
     * ������ ���������� �������
     *
     * @var array
     */
    //protected $cacheable = array();

    /**
     * �������� ����� �������
     *
     * @var string
     */
    protected $tablePostfix = null;

    /**
     * �������� �������� ����� �������
     *
     * @var string
     */
    protected $tableKey = 'id';

    /**
    * ����� �������, ������������ �� ��������� ������ (��� ����� LIMIT)
    *
    * @var integer
    */
    protected $count;

    /**
     * ������, ������������ ��� ������������� ������
     * � �������� �������� ������������� ������
     *
     * @var pager
     */
    protected $pager;

    /**
     * �����������
     *
     * @param string $section ������
     */
    public function __construct($section, $alias = 'default')
    {
        $this->db = DB::factory($alias);
        $this->section = $section;
        $this->table = $this->section() . '_' .$this->className . $this->tablePostfix;
        $this->relationTable = $this->section() . '_' .$this->name() . '_' . $this->relationPostfix;
    }

    /**
     * ���������� ��� ������
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * ���������� ������
     *
     * @return string
     */
    public function section()
    {
        return $this->section;
    }

    /**
     * ��������� ������� ������� $object � �������.
     * ������ �������������� �� ������� � ������, ������� ����������
     * � ����� self::insertDataModify(), ����� ������������ �
     * ����������� SQL-������ ��� ���������� �������� �������.
     * � ���������� ������������ ���������� ������ � ������ �������
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

            $row = $this->searchByField($this->tableKey, $id);

            $this->createItemFromRow($row, $object);
        }
    }

    /**
     * ��������� ���������� ������� $object � �������.
     * ������ �������������� �� ������� � ������, ������� ����������
     * � ����� self::updateDataModify(), ����� ������������ �
     * ����������� SQL-������ ��� ���������� �������� ����������.
     * � ���������� ������������ ���������� ������ � ������ �������
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

            $row = $this->searchByField($this->tableKey, $object->getId());

            $this->createItemFromRow($row, $object);

            return $result;
        }

        return false;
    }

    /**
     * ��������� �������� ������� �� ��
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
     * ���� � ������� ������� �������������, �� �����������
     * ���������� �������, ����� ����������� ������� ������� � ��
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
     * ����� ��� ���������� ������, � �������� ������ ������� ��
     *
     * @param object $criteria
     * @param string $table ��� �������, � ������� ����� �������������� ������ �� owns � has
     * @param string $section ��� �������, � ��������� �������� ���������� �������
     */
    private function addJoins($criteria, $table, $section)
    {
        $this->addSelectFields($criteria);

        $owns = $this->getOwns();

        foreach ($owns as $val) {
            $criterion = new criterion($table . '.' . $val['key'], $val['section'] . '_' . $val['table'] . '.' . $val['field'], criteria::EQUAL, true);
            $criteria->addJoin($val['section'] . '_' . $val['table'], $criterion);

            fileLoader::load($this->name . '/mappers/' . $val['mapper']);

            $mapper = new $val['mapper']($val['section']);

            $mapper->addJoins($criteria, $val['table'], $section);
        }

        $has = $this->getHas();

        foreach ($has as $val) {
            $criterion = new criterion($table . '.' . $val['relate'], $val['section'] . '_' . $val['table'] . '.' . $val['field'], criteria::EQUAL, true);
            $criteria->addJoin($val['section'] . '_' . $val['table'], $criterion);

            fileLoader::load($this->name . '/mappers/' . $val['mapper']);

            $mapper = new $val['mapper']($val['section']);

            $mapper->addJoins($criteria, $val['table'], $section);
        }

        $ownsMany = $this->getOwnsMany();

        if (!empty($ownsMany)) {
            $criterion = new criterion($table . '.' . $ownsMany['key'], $ownsMany['section'] . '_' . $ownsMany['table'] . '.' . $ownsMany['field'], criteria::EQUAL, true);
            $criteria->addJoin($ownsMany['section'] . '_' . $ownsMany['table'], $criterion);

            fileLoader::load($this->name . '/mappers/' . $ownsMany['mapper']);

            $mapper = new $ownsMany['mapper']($ownsMany['section']);

            $mapper->addJoins($criteria, $ownsMany['table'], $section);
        }

        $hasMany = $this->getHasMany();

        if (!empty($hasMany)) {
            $criterion = new criterion($table . '.' . $hasMany['relate'], $hasMany['section'] . '_' . $hasMany['table'] . '.' . $hasMany['field'], criteria::EQUAL, true);
            $criteria->addJoin($hasMany['section'] . '_' . $hasMany['table'], $criterion);

            fileLoader::load($this->name . '/mappers/' . $hasMany['mapper']);

            $mapper = new $hasMany['mapper']($hasMany['section']);

            $mapper->addJoins($criteria, $hasMany['table'], $section);
        }
    }

    /**
     * ���� ������ �� ���� $name �� ��������� $value
     * � ���������� ��������� ������
     *
     * @param string $name ��� ����
     * @param string $value �������� ����
     * @return object
     */
    public function searchByField($name, $value)
    {
        $criteria = new criteria($this->table);
        $criteria->enableCount();
        $criteria->add($this->table . '.' . $name, $value);

        $this->addJoins($criteria, $this->table, $this->section);

        $select = new simpleSelect($criteria);
        //var_dump($select->toString());
        $stmt = $this->db->query($select->toString());
        $row = $stmt->fetchAll();
        $result = array();

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

        $criteria_count = new criteria();
        $criteria_count->addSelectField('FOUND_ROWS()', 'count');
        $select_count = new simpleSelect($criteria_count);

        $this->count = $this->db->getOne($select_count->toString());

        if (!empty($this->pager)) {
            $this->pager->setCount($this->count);
        }

        return $result;
    }

    /**
     * ���� � ���������� ���� ������ �� �������� ����� ����
     * � ��� ��������
     *
     * @param string $name ��� ����
     * @param string $value �������� ����
     * @return object
     */
    public function searchOneByField($name, $value)
    {
        $row = $this->searchByField($name, $value);
        //var_dump($row);

        $ownsMany = $this->getOwnsMany();
        if (!empty($ownsMany)) {
            $tmp = array();
            foreach ($row as $key => $val) {
                $tmp[] = $val[$ownsMany['table']];
            }
            $row[0][$ownsMany['table']] = $tmp;
            unset($row[1]);
        }
        //var_dump($row);
        if ($row) {
            return $this->createItemFromRow($row);
        }
        return null;
    }

    /**
     * ���� � ���������� ��� ������ �� �������� ����� ����
     * � ��� ��������
     *
     * @param string $name ��� ����
     * @param string $value �������� ����
     * @return array ������ � ���������
     */
    public function searchAllByField($name, $value)
    {
        $row = $this->searchByField($name, $value);
        $result = array();

        $ownsMany = $this->getOwnsMany();

        if (!empty($ownsMany)) {
            $last_obj_id = 0;
            $obj_ids = array();
            foreach ($row as $key => $val) {
                if ($last_obj_id != $val[$this->className]['obj_id']) {
                    if ($last_obj_id != 0) {
                        $row[$obj_ids[0]][$ownsMany['table']] = $tmp;
                        foreach ($obj_ids as $subkey => $id) {
                            if ($subkey > 0) {
                                unset($row[$id]);
                            }
                        }
                    }
                    unset($tmp);
                    $tmp = array();
                    unset($obj_ids);
                    $obj_ids = array();
                    $last_obj_id = $val[$this->className]['obj_id'];
                }
                $tmp[] = $val[$ownsMany['table']];
                $obj_ids[] = $key;
            }

            if ($last_obj_id != 0) {
                $row[$obj_ids[0]][$ownsMany['table']] = $tmp;
                foreach ($obj_ids as $subkey => $id) {
                    if ($subkey > 0) {
                        unset($row[$id]);
                    }
                }
            }
        }

        $hasMany = $this->getHasMany();

        if (!empty($hasMany)) {
            $last_obj_id = 0;
            $obj_ids = array();

            foreach ($row as $key => $val) {
                if ($last_obj_id != $val[$this->className]['obj_id']) {
                    if ($last_obj_id != 0) {
                        $row[$obj_ids[0]][$hasMany['table']] = $tmp;
                        foreach ($obj_ids as $subkey => $id) {
                            if ($subkey > 0) {
                                unset($row[$id]);
                            }
                        }
                    }
                    unset($tmp);
                    $tmp = array();
                    unset($obj_ids);
                    $obj_ids = array();
                    $last_obj_id = $val[$this->className]['obj_id'];
                }
                $tmp[] = $val[$hasMany['table']];
                $obj_ids[] = $key;
            }

            if ($last_obj_id != 0) {
                $row[$obj_ids[0]][$hasMany['table']] = $tmp;
                foreach ($obj_ids as $subkey => $id) {
                    if ($subkey > 0) {
                        unset($row[$id]);
                    }
                }
            }
        }



        //var_dump($row);exit;
        foreach ($row as $val) {
            $result[] = $this->createItemFromRow(array(0 => $val));
        }

        return $result;
    }

    /**
     * ����� ������ ����� ��������� �������� � ������������ ���������� ������� �������� ������������� �������
     *
     * @param array $f
     * @param string $parent
     * @return array
     */
    public function fill($row)
    {

        $owns = $this->getOwns();

        foreach ($owns as $val) {
            $mapper = new $val['mapper']($this->section);
            $row[0][$this->className][$val['key']] = $mapper->createItemFromRow($row);
        }

        $has = $this->getHas();

        foreach ($has as $val) {
            $mapper = new $val['mapper']($this->section);
            $row[0][$this->className][$val['key']] = $mapper->createItemFromRow($row);
        }

        $ownsMany = $this->getOwnsMany();

        if (!empty($ownsMany)) {
            $mapper = new $ownsMany['mapper']($this->section);
            //var_dump($mapper);
            unset($row[0][$this->className][$ownsMany['key']]);
            foreach ($row[0][$ownsMany['table']] as $key => $val) {
                $row[0][$this->className][$ownsMany['key']][] = $mapper->createItemFromRow(array(0 => array($ownsMany['table'] => $val)));
            }
        }

        $hasMany = $this->getHasMany();

        if (!empty($hasMany)) {
            $mapper = new $hasMany['mapper']($this->section);
            foreach ($row[0][$hasMany['table']] as $key => $val) {
                $row[0][$this->className][$hasMany['key']][] = $mapper->createItemFromRow(array(0 => array($hasMany['table'] => $val)));
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
     * ������� �� �� �������
     *
     * @param array $row
     * @return object
     */
    protected function createItemFromRow($row, $domainObject = null)
    {
        //var_dump($row);
        if (empty($domainObject)) {
            $map = $this->getMap();
            $domainObject = new $this->className($map);
        }
        //var_dump($row);
        $row = $this->fill($row);
        //var_dump($row);
        $domainObject->import($row);
        return $domainObject;
    }

    /**
     * ����� ��� ��������� ����������� map-����� (������������ ��� ������������)
     *
     * @param array $map
     */
    public function setMap($map)
    {
        $this->map = $map;
    }

    /**
     * ���������� Map
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
     * ���������� ����������� ����������� ��� �������������� ������
     *
     * @param string $name ��� ������
     * @return boolean ����������� �����������
     */
    public function isCacheable($name)
    {
        return in_array($name, $this->cacheable);
    }

    /**
     * ��������� ������ �� ������ cache
     *
     * @package cache $cache
     */
    public function injectCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * ���������� �������� � �������� $fields ����� ����������� � ��
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
    }

    /**
     * ���������� �������� � �������� $fields ����� �������� � ��
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
    }

    /**
     * ��������� ������� ��������
     *
     * @param pager $pager
     */
    public function setPager($pager)
    {
        $this->pager = $pager;
    }

    /**
     * ����� ��� �������������� ���� �� ����������� ������� � obj_id
     *
     * @param unknown_type $args
     * @return unknown
     */
    public function convertArgsToId($args)
    {
        return (int)$args;
    }

    /**
     * ����� ��� ���������� � $criteria ������������ ���� ���������� �����
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
     * ����� ��������� ������� � ����������� � �������������� ��������, ��� owns
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

                    $this->owns[] = array('table' => $tableName, 'field' => $foreignKeyName, 'mapper' => $className, 'key' => $key, 'section' => $joinSection);
                }
            }
        }

        return $this->owns;
    }

    /**
     * ����� ��������� ������� � ����������� � �������������� ��������, ��� ���
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

                    $this->has[] = array('table' => $tableName, 'field' => $foreignKeyName, 'mapper' => $className, 'key' => $key, 'relate' => $relationField, 'section' => $joinSection);
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

                    $this->ownsMany = array('table' => $tableName, 'field' => $foreignKeyName, 'mapper' => $className, 'key' => $key, 'section' => $joinSection);

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

                    $this->hasMany = array('table' => $tableName, 'field' => $foreignKeyName, 'mapper' => $className, 'key' => $key, 'relate' => $relationField, 'section' => $joinSection);

                    break;
                }
            }
        }

        return $this->hasMany;
    }
}

?>