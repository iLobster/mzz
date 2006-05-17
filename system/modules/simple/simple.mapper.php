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
/**
 * simpleMapper: ���������� ����� ������� � Mapper
 *
 * @package simple
 * @version 0.1
 */

abstract class simpleMapper
{
    protected $db;
    protected $table;
    protected $section;
    protected $name;
    protected $className;

    /**
     * �������� ��� ����� �������
     *
     * @var string
     */
    protected $tablePostfix = null;

    public function __construct($section)
    {
        $this->db = DB::factory();
        $this->section = $section;
        $this->table = $this->getName() . '_' .$this->getSection() . $this->tablePostfix;
    }

    protected function getName()
    {
        return $this->name;
    }

    protected function getSection()
    {
        return $this->section;
    }

    protected function insert($object)
    {
        $fields = $object->export();
        if (sizeof($fields) > 0) {

            $field_names = '`' . implode('`, `', array_keys($fields)) . '`';
            $markers  = ':' . implode(', :', array_keys($fields));

            $stmt = $this->db->prepare('INSERT INTO `' . $this->table . '` (' . $field_names . ') VALUES (' . $markers . ')');

            $stmt->bindArray($fields);

            $id = $stmt->execute();

            $fields['id'] = $id;

            $object->import($fields);
        }
    }

    protected function update($object)
    {
        $fields = $object->export();
        if (sizeof($fields) > 0) {

            $query = '';
            foreach(array_keys($fields) as $val) {
                $query .= '`' . $val . '` = :' . $val . ', ';
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

    public function delete($object)
    {
        $stmt = $this->db->prepare('DELETE FROM `' . $this->table . '` WHERE `id` = :id');
        $stmt->bindParam(':id', $object->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function save($object)
    {
        if ($object->getId()) {
            $this->update($object);
        } else {
            $this->insert($object);
        }
    }

    protected function getMap()
    {
        if (empty($this->map)) {
            $mapFileName = fileLoader::resolve($this->getName() . '/maps/' . $this->className . '.map.ini');
            $this->map = parse_ini_file($mapFileName, true);
        }
        return $this->map;
    }
}

?>