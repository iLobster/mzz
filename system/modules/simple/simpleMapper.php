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
 * simpleMapper: ���������� ����� ������� � Mapper
 *
 * @package modules
 * @subpackage simple
 * @version 0.3.6
 */

abstract class simpleMapper
{
    /**
     * ���������, ������������ ����������� ����� ������ �������� � ������ ���� � ������� ��� ����� � ��������
     *
     */
    const TABLE_KEY_DELIMITER = '___';

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
     * Map. �������� ���������� � ����� (����� ���������, ����� ���������, ���������, ...).
     *
     * @var array
     */
    protected $map;

    /**
     * �������� ��� �������� ���������� �� ����������
     *
     * @var array
     */
    protected $relations;

    /**
     * ���� � ������� ��� �������� ����������� �������������� ��������� �������
     * ���� ��� ���� ������������ � ������ ����� ��������������� ��� � ����������� ������
     *
     * @var string
     */
    protected $obj_id_field = "obj_id";

    /**
     * �����������
     *
     * @param string $section ������
     */
    public function __construct($section)
    {
        $this->db = DB::factory();
        $this->section = $section;

        $this->table = $this->section . '_' .$this->className;
    }

    /**
     * ���������� �������
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * ���������� ���� �������
     *
     * @return string
     */
    public function getTableKey()
    {
        return $this->tableKey;
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
     * ���� � ������� ������� �������������, �� �����������
     * ���������� �������, ����� ����������� ������� ������� � ��
     *
     * @param object $object
     * @param user $user ������������, ������� ����� ��������������� � ACL ��� �������� �������
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
     * ��������� ������� ������� $object � �������.
     * ������ �������������� �� ������� � ������, ������� ����������
     * � ����� self::insertDataModify(), ����� ������������ �
     * ����������� SQL-������ ��� ���������� �������� �������.
     * � ���������� ������������ ���������� ������ � ������ �������
     *
     * @param simple $object
     * @param user $user ������������, ������� ����� ��������������� � ACL ��� �������� �������
     */
    protected function insert(simple $object, $user = null)
    {
        $toolkit = systemToolkit::getInstance();
        $object->setObjId($toolkit->getObjectId());

        $fields =& $object->export();

        if (sizeof($fields) > 1) {
            $this->replaceRelated($fields, $object);
            $this->insertDataModify($fields);

            $field_names = '`' . implode('`, `', array_keys($fields)) . '`';
            $markers = "";

            foreach (array_keys($fields) as $val) {
                if($fields[$val] instanceof sqlFunction) {
                    $fields[$val] = $fields[$val]->toString();
                    $markers .= $fields[$val] . ', ';
                    unset($fields[$val]);
                } elseif($fields[$val] instanceof sqlOperator){
                    $fields[$val] = $fields[$val]->toString();
                    $markers .= $fields[$val] . ', ';
                    unset($fields[$val]);
                } else {
                    $markers .= ':' . $val . ', ';
                }
            }
            $markers = substr($markers, 0, -2);

            $stmt = $this->db->prepare('INSERT INTO `' . $this->table . '` (' . $field_names . ') VALUES (' . $markers . ')');

            $stmt->bindValues($fields);

            $id = $stmt->execute();

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

            $object->import($data);

            if (!is_null($user)) {
                $tmp = $toolkit->setUser($user);
            }

            $this->register($object->getObjId());

            if (!is_null($user)) {
                $toolkit->setUser($tmp);
            }
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
        $fields =& $object->export();

        $this->replaceRelated($fields, $object);

        if (sizeof($fields) > 0) {
            $this->updateDataModify($fields);

            $query = '';
            foreach (array_keys($fields) as $val) {
                if($fields[$val] instanceof sqlFunction) {
                    $fields[$val] = $fields[$val]->toString();
                    $query .= '`' . $val . '` = ' . $fields[$val] . ', ';
                    unset($fields[$val]);
                } else if($fields[$val] instanceof sqlOperator){
                    $fields[$val] = $fields[$val]->toString();
                    $query .= '`' . $val . '` = ' . $fields[$val] . ', ';
                    unset($fields[$val]);
                } else {
                    $query .= '`' . $val . '` = :' . $val . ', ';
                }
            }
            $query = substr($query, 0, -2);

            if ($query) {
                $stmt = $this->db->prepare('UPDATE  `' . $this->table . '` SET ' . $query . ' WHERE `' . $this->tableKey . '` = :id');

                $stmt->bindValues($fields);
                $stmt->bindValue(':id', $object->getId(), PDO::PARAM_INT);
                $result = $stmt->execute();
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

            $object->import($data);

            return true;
        }

        return false;
    }

    /**
     * ����� ���������� ������� � ACL (��� ��������)
     *
     * @param integer $obj_id ���������� ������������� �������
     * @param string $section ��� �������
     * @param string $className ��� ������
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
     * ��������� �������� ������� �� ��
     *
     * @param integer $id
     * @return mixed
     */
    public function delete($id)
    {
        $toolkit = systemToolkit::getInstance();
        $object = $this->searchOneByField($this->tableKey, $id);

        if ($object) {
            $acl = new acl($toolkit->getUser());
            $acl->delete($object->getObjId());
        }

        $stmt = $this->db->prepare('DELETE FROM `' . $this->table . '` WHERE `' . $this->tableKey . '` = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }


    /**
     * ����� ��� ��������� ������� ������� � ������� ��� ������ �����
     *
     * @param array $array
     * @param string $name ��� �������������� ��
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
     * ����� ��� ���������� � ������ �������������
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

            $criteria->addJoin($val['table'], $joinCriterion, $key, $val['join_type']);
        }
    }

    /**
     * ����� ������ �� ����� �������
     *
     * @param integer $id ������������� ������
     * @return object simple
     */
    public function searchByKey($id)
    {
        return $this->searchOneByField($this->tableKey, $id);
    }

    /**
     * ����� ������� �� ������ �������
     *
     * @param array $keys ������������� ������
     * @return object simple
     */
    public function searchByKeys($ids)
    {
        $criteria = new criteria();
        $criteria->add($this->tableKey, $ids, criteria::IN);

        return $this->searchAllByCriteria($criteria);
    }

    /**
     * ����� ������� �� ��������
     *
     * @param criteria $criteria �������� ��������
     * @return object PDOStatement
     */
    protected function searchByCriteria(criteria $criteria_outer)
    {
        $criteria = new criteria();
        $this->addJoins($criteria);
        $criteria->setTable($this->table, $this->className);

        $criteria->append($criteria_outer);

        // ���� ���� ������� - �� ��������� ������ ��� LIMIT � �������� ��������� ����� ������� � �������
        if ($this->pager) {
            $this->count($criteria);
        }

        $this->addOrderBy($criteria);

        $select = new simpleSelect($criteria);
        //echo '<br><pre>'; var_dump($select->toString()); echo '<br></pre>';
        $stmt = $this->db->query($select->toString());

        return $stmt;
    }

    protected function count($criteria)
    {
        $criteriaForCount = clone $criteria;
        $criteriaForCount->clearSelectFields()->addSelectField('COUNT(*)', 'cnt');
        $selectForCount = new simpleSelect($criteriaForCount);
        $stmt = $this->db->query($selectForCount->toString());
        $count = $stmt->fetch();

        $this->pager->setCount($count['cnt']);

        $criteria->append($this->pager->getLimitQuery());

        $this->removePager();
    }

    /**
     * ����� ���������� � �������� �������� ������ ���������� �� map
     *
     * @param criteria $criteria
     */
    protected function addOrderBy($criteria)
    {
        // ��������� ����������
        $orderBy = array();
        foreach ($this->map as $key => $val) {
            if (isset($val['orderBy'])) {
                if (!is_numeric($val['orderBy'])) {
                    throw new mzzInvalidParameterException('�������� orderBy � ' . $this->className . '.ini ������ ���� ����� ������', $val['orderBy']);
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
     * ���������� �������� ������, ������� ����������� ������������� ������
     *
     * @return object
     */
    public function create()
    {
        $object = new $this->className($this, $this->getMap());
        $object->section($this->section());
        return $object;
    }

    /**
     * ��������� ������� �� ������� �������� ������
     *
     * @param array $row ������ � �������
     * @return object
     */
    public function createItemFromRow($row)
    {
        $object = $this->create();
        $object->import($row);
        return $object;
    }

    /**
     * ����� ����� ������ �� ��������� ��������
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
     * ���� � ���������� ���� ������ �� �������� ����� ����
     * � ��� ��������
     *
     * @param string $name ��� ����
     * @param string $value �������� ����
     * @return object
     */
    public function searchOneByField($name, $value)
    {
        $criteria = new criteria();
        $criteria->add($name, $value);
        return $this->searchOneByCriteria($criteria);
    }

    /**
     * ����� ���� ������� �� ��������� ��������
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
            $result[$data[$this->tableKey]] = $this->createItemFromRow($data);
        }

        return $result;
    }

    /**
     * ����� ���� �������
     *
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
        foreach ($map as $key => $val) {
            if (!isset($val['hasMany'])) {
                $criteria->addSelectField($alias . '.' . $key, $alias . self::TABLE_KEY_DELIMITER . $key);
            }
        }
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
        $criteria = new criteria();
        $criteria->add($name, $value);
        return $this->searchAllByCriteria($criteria);
    }

    /**
     * ���������� Map
     *
     * @param boolean $refresh ��� �������� true ���������� ���������� map
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

    /**
     * ����� ���������� ���������� ���� obj_id � ����� ������
     *
     * @param array $map
     */
    public function addObjId(&$map)
    {
        if (!isset($map[$this->obj_id_field])) {
            $map['obj_id'] = array('name' => $this->obj_id_field, 'accessor' => 'getObjId', 'mutator' => 'setObjId', 'once' => 'true');
        }
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
     * ���������� �������� � �������� $fields ����� ���������� � ��
     *
     * @param array $fields
     */
    protected function selectDataModify(&$fields)
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

    public function removePager()
    {
        $this->pager = null;
    }

    /**
     * ����� ��������� map
     *
     * @param array $map
     */
    public function setMap($map)
    {
        $this->map = $map;
    }

    /**
     * ����� ��� ������� ������� ������ � ������
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
     * ����� ��������� ������ �� ���������� ���� owns
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
     * ����� ��� ��������� ������ �� ���������� ���� hasMany
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
     * ����� ��������� ������ � ������ ����������� ����
     *
     * @param string $key
     * @return array|boolean ������ ������ ��� false, ���� ������� �� �������
     */
    private function getRelationInfo($key)
    {
        $this->getHasMany();
        $this->getOwns();
        return isset($this->relations['hasMany'][$key]) ? $this->relations['hasMany'][$key] : (isset($this->relations['owns'][$key]) ? $this->relations['owns'][$key] : false);
    }

    /**
     * �����, ���������� ��������� ������� �� ������
     *
     * @param array $fields
     */
    private function replaceRelated(&$fields, $object)
    {
        $map = $this->getMap();
        $saved = array();

        // ��������� ���������� ����
        foreach ($fields as $key => $val) {
            $owns = $this->getOwns();
            $hasMany = $this->getHasMany();
            // ���� �� ������� ���� ���� �����
            if (!is_scalar($val) && isset($owns[$key])) {
                $sectionName = $owns[$key]['section'];
                $className = $owns[$key]['class'];
                $fieldName = $owns[$key]['key'];
                $moduleName = $owns[$key]['module'];

                // �������� ������ ������
                $toolkit = systemToolkit::getInstance();
                $mapper = $toolkit->getMapper($moduleName, $className, $sectionName);

                // ��������� ��������� ������
                $mapper->save($val);

                // �������� ����� ���������� �������
                $relatedMap = $mapper->getMap();

                // �� ���������� ����� �������� ��� ��������� � ������, �� �������� �������� ������, �� ������� ��������� ���� ������ � �������
                $accessor = $relatedMap[$fieldName]['accessor'];

                // ������ ����� ����������� ��������� � �������� ������ �� ������
                $fields[$key] = $val->$accessor();

                // ��������, ��� ��� ���� ��� ���� ���������
                $saved[$key] = true;
            } elseif (isset($map[$key]['hasMany'])) {
                $accessor = $map[$key]['accessor'];
                $oldData = $object->$accessor();

                $oldObjIds = array();
                foreach ($oldData as $subval) {
                    $oldObjIds[$subval->getObjId()] = $subval->getId();
                }

                // ���������� ������, ������� ��� � ����� �������
                foreach ($val as $subkey => $subval) {
                    if (isset($oldObjIds[$subval->getObjId()])) {
                        unset($oldObjIds[$subval->getObjId()]);
                    }
                }

                $sectionName = $hasMany[$key]['section'];
                $className = $hasMany[$key]['class'];
                $fieldName = $hasMany[$key]['key'];
                $moduleName = $hasMany[$key]['module'];
                $fieldName = $hasMany[$key]['key'];
                $thisField = $hasMany[$key]['field'];

                // �������� ������ ������
                $toolkit = systemToolkit::getInstance();
                $mapper = $toolkit->getMapper($moduleName, $className, $sectionName);

                // �������� ����� ���������� �������
                $relatedMap = $mapper->getMap();

                // �� ���������� ����� �������� ��� �������� � ������, �� �������� ������������� ������, �� ������� ���������� ���� ������ � �������
                $mutator = $relatedMap[$fieldName]['mutator'];

                // �������� ��� ���������, �� �������� ������������ �������� ����, �� �������� ���������� ����������
                $accessor = $map[$thisField]['accessor'];

                // ������� ��� ������ ������� ��� � ����� �������
                foreach ($oldObjIds as $subval) {
                    $mapper->delete($subval);
                }

                // ��������� ��� ����� ������
                foreach ($val as $subval) {
                    $subval->$mutator($object->$accessor());
                    $mapper->save($subval);
                }

                // ������� ������
                unset($fields[$key]);

                // ��������, ��� ��� ���� ��� ���� ���������
                $saved[$key] = true;
            }
        }

        $old =& $object->exportOld();

        $toolkit = systemToolkit::getInstance();

        // ��������� �� ����, ������� �������� �� ����
        // ������� ��� ����, ������� � ������� ���� �� ����������
        foreach ($old as $key => $val) {
            // ���� ���� �������� �������� ��� �������� � ��� �� ���� ��������� - �� ��������� ���
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
     * ����� ��� �������� �����������, ��������������� ������ 404
     *
     * @return simpleController
     *
     * @todo �������� - ��������� ��� �����
     */
    public function get404()
    {
        fileLoader::load('simple/simple404Controller');
        return new simple404Controller();
    }

    /**
     * ���������� �������, ����������� � ������ �����
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
     * ����������� ����� ��� ��������� Obj_id ����������� �������� �� ����������
     *
     * @param array $args
     */
    abstract public function convertArgsToId($args);
}

?>