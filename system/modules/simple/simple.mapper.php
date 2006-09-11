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
        $this->table = $this->name() . '_' .$this->section() . $this->tablePostfix;
        $this->relationTable = $this->name() . '_' .$this->section() . '_' . $this->relationPostfix;
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
            //$bindFields = $fields; // ����� ��� ������???
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
     * ���� � ���������� ���� ������ �� �������� ����� ����
     * � ��� ��������
     *
     * @param string $name ��� ����
     * @param string $value �������� ����
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
     * ���� � ���������� ��� ������ �� �������� ����� ����
     * � ��� ��������
     *
     * @param string $name ��� ����
     * @param string $value �������� ����
     * @return array ������ � ���������
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
     * ����� ������ ����� ��������� �������� � ������������ ���������� ������� �������� ������������� �������
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
     * ���������� Map
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

    public function convertArgsToId($args)
    {
        return (int)$args;
    }
}

?>