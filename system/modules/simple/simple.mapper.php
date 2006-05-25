<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
fileLoader::load('db/sqlFunction');
/**
 * simpleMapper: ���������� ����� ������� � Mapper
 *
 * @package simple
 * @version 0.2
 */

abstract class simpleMapper implements iCacheable
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
    protected $cache;

    /**
     * ������ ���������� �������
     *
     * @var array
     */
    protected $cacheable = array();

    /**
     * �������� ����� �������
     *
     * @var string
     */
    protected $tablePostfix = null;

    /**
     * �����������
     *
     * @param string $section ������
     */
    public function __construct($section)
    {
        $this->db = DB::factory();
        $this->section = $section;
        $this->table = $this->name() . '_' .$this->section() . $this->tablePostfix;
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
        $fields = $object->export();

        if (sizeof($fields) > 0) {
            $this->insertDataModify($fields);

            $field_names = '`' . implode('`, `', array_keys($fields)) . '`';
            $markers = "";
            foreach(array_keys($fields) as $val) {
                if($fields[$val] instanceof sqlFunction) {
                    $markers .= $fields[$val]->toString() . ', ';
                    unset($fields[$val]);
                } else {
                    $markers .= ':' . $val . ', ';
                }
            }
            $markers = substr($markers, 0, -2);

            $stmt = $this->db->prepare('INSERT INTO `' . $this->table . '` (' . $field_names . ') VALUES (' . $markers . ')');

            $stmt->bindArray($fields);

            $id = $stmt->execute();

            $fields['id'] = $id;

            $object->import($fields);
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
                    $query .= '`' . $val . '` = ' . $fields[$val]->toString() . ', ';
                    unset($fields[$val]);
                } else {
                    $query .= '`' . $val . '` = :' . $val . ', ';
                }
            }
            $query = substr($query, 0, -2);
            $stmt = $this->db->prepare('UPDATE  `' . $this->table . '` SET ' . $query . ' WHERE `id` = :id');

            $stmt->bindArray($fields);
            $stmt->bindParam(':id', $object->getId(), PDO::PARAM_INT);


            $object->import($fields);

            return $stmt->execute();
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
        $stmt = $this->db->prepare('DELETE FROM `' . $this->table . '` WHERE `id` = :id');
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
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` WHERE `" . $name .  "` = :" . $name);
        $stmt->bindParam(':' . $name, $value);
        $stmt->execute();
        return $stmt;
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
}

?>