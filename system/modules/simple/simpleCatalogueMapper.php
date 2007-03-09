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

fileLoader::load('simple/simpleCatalogue');

/**
 * simpleCatalogueMapper: ������
 *
 * @package modules
 * @subpackage simple
 * @version 0.1.5
 */

abstract class simpleCatalogueMapper extends simpleMapper
{
    private $tableData = '';
    private $tableTypes = '';
    private $tableProperties = '';
    private $tablePropertiesTypes = '';
    private $tableTypesProps = '';

    private $tmpPropsData = array();
    private $tmpServiceData = array();

    public function __construct($section)
    {
        parent::__construct($section);

        $this->tableData = $this->table . '_data';
        $this->tableTypes = $this->table . '_types';
        $this->tableProperties = $this->table . '_properties';
        $this->tablePropertiesTypes = $this->table . '_properties_types';
        $this->tableTypesProps = $this->table . '_types_props';
    }

    public function getAllTypes()
    {
        return $this->db->getAll('SELECT * FROM `' . $this->tableTypes . '`', PDO::FETCH_ASSOC);
    }

    public function getAllProperties()
    {
        return $this->db->getAll('SELECT * FROM `' . $this->tableProperties . '`', PDO::FETCH_ASSOC);
    }

    public function getType($id)
    {
        return $this->db->getRow('SELECT * FROM `' . $this->tableTypes . '` WHERE `id` = ' . (int)$id, PDO::FETCH_ASSOC);
    }

    public function getProperty($id)
    {
        return $this->db->getRow('SELECT * FROM `' . $this->tableProperties . '` WHERE `id` = ' . (int)$id, PDO::FETCH_ASSOC);
    }

    public function getProperties($id)
    {
        $stmt = $this->db->prepare('SELECT `p`.* FROM `' . $this->tableTypesProps . '` `tp` INNER JOIN `' . $this->tableProperties . '` `p` ON `p`.`id` = `tp`.`property_id` WHERE `tp`.`type_id` = :type_id');
        $stmt->bindParam('type_id', $id);
        $stmt->execute();
        $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($properties)){
            $properties = $this->getPropertiesTypes( $properties );
        }
        return $properties;
    }

    protected function getPropertiesTypes( $props )
    {
        $props_id = null;
        $properties = array();
        foreach($props as $property){
            $props_id .= $property['id'] . ', ';
            $properties[$property['name']] = $property;
        }
        $props_id = substr($props_id, 0, -2);

        $types = $this->db->getAll($qry = 'SELECT `t`.`name` as `type`, `p`.`name` as `name` FROM `' . $this->tableProperties . '` `p` INNER JOIN `' . $this->tablePropertiesTypes . '` `t` ON `t`.`id` = `p`.`type_id` WHERE `p`.`id` IN (' . $props_id . ')', PDO::FETCH_ASSOC);

        foreach($types as $type){
            $properties[$type['name']]['type'] = $type['type'];
        }
        return $properties;
    }

    public function addType($name, $title, Array $properties)
    {
        $stmt = $this->db->prepare('INSERT INTO `' . $this->tableTypes . '` (`name`, `title`) VALUES (:name, :title)');
        $stmt->bindParam('name', $name);
        $stmt->bindParam('title', $title);
        $typeId = $stmt->execute();

        if(!empty($properties)){
            $this->setPropertiesToType($typeId, $properties);
        }
    }

    public function updateType($typeId, $name, $title, Array $properties)
    {
        $stmt = $this->db->prepare('UPDATE `' . $this->tableTypes . '` SET `name` = :name, `title` = :title WHERE `id` = :id');
        $stmt->bindParam('id', $typeId);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('title', $title);
        $stmt->execute();

        $allProperties = array();
        foreach($this->getProperties($typeId) as $property){
            $allProperties[] = $property['id'];
        }

        $tmpDelete = array_diff($allProperties, $properties);
        $tmpInsert = array_diff($properties, $allProperties);

        if(!empty($tmpDelete)){
            array_map('intval', $tmpDelete);
            $this->db->query('DELETE FROM `' . $this->tableData . '` WHERE `property_type` IN (SELECT `id` FROM `' . $this->tableTypesProps . '` WHERE `type_id` = ' . (int)$typeId . ' AND `property_id` IN (' . implode(', ', $tmpDelete) . '))');
            $query = 'DELETE FROM `' . $this->tableTypesProps . '` WHERE `type_id` = ' . (int)$typeId . ' AND `property_id` IN (' . implode(', ', $tmpDelete) . ')';
            $this->db->query($query);
        }

        if(!empty($tmpInsert)){
            $this->setPropertiesToType($typeId, $tmpInsert);
        }
    }

    public function deleteType($type_id)
    {
        $stmt = $this->db->prepare('DELETE FROM `' . $this->tableTypes . '` WHERE `id` = :id');
        $stmt->bindParam('id', $type_id);
        $stmt->execute();

        $stmt = $this->db->prepare('DELETE FROM `' . $this->tableTypesProps . '` WHERE `type_id` = :id');
        $stmt->bindParam('id', $type_id);
        $stmt->execute();
    }

    public function addProperty($name, $title, $type)
    {
        $stmt = $this->db->prepare('INSERT INTO `' . $this->tableProperties . '` (`name`, `title`, `type_id`) VALUES (:name, :title, :type)');
        $stmt->bindParam('name', $name);
        $stmt->bindParam('title', $title);
        $stmt->bindParam('type', $type);
        return $stmt->execute();
    }

    public function updateProperty($id, $name, $title, $type_id)
    {
        $stmt = $this->db->prepare('UPDATE `' . $this->tableProperties . '` SET `name` = :name, `title` = :title, `type_id` = :type_id WHERE `id` = :id ');
        $stmt->bindParam('id', $id);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('title', $title);
        $stmt->bindParam('type_id', $type_id);
        return $stmt->execute();
    }

    public function deleteProperty($id)
    {
        $stmt = $this->db->prepare('DELETE FROM `' . $this->tableProperties . '` WHERE `id` = :id');
        $stmt->bindParam('id', $id);
        $stmt->execute();

        $stmt = $this->db->prepare('DELETE FROM `' . $this->tableData . '` WHERE `property_type` IN ( SELECT `id` FROM `' . $this->tableTypesProps . '` WHERE `property_id` = :id )');
        $stmt->bindParam('id', $id);
        $stmt->execute();

        $stmt = $this->db->prepare('DELETE FROM `' . $this->tableTypesProps . '` WHERE `property_id` = :id');
        $stmt->bindParam('id', $id);
        $stmt->execute();
    }

    private function setPropertiesToType($typeId, Array $properties)
    {
        array_map('intval', $properties);
        $query = 'INSERT INTO `' . $this->tableTypesProps . '` (`type_id`, `property_id`) VALUES ';
        foreach ($properties as $id) {
            $query .= '(' . (int)$typeId . ', ' . $id . '), ';
        }
        $query = substr($query, 0, -2);
        $this->db->query($query);
    }

    protected function count($criteria)
    {
        $criteriaForCount = clone $criteria;
        $criteriaForCount->clearSelectFields()->addSelectField('COUNT(*)', 'cnt');

        $subselectCriteria = new criteria($criteriaForCount, 'x');
        $subselectCriteria->clearSelectFields()->addSelectField('COUNT(*)', 'cnt');

        $selectForCount = new simpleSelect($subselectCriteria);
        $stmt = $this->db->query($selectForCount->toString());
        $count = $stmt->fetch();

        $this->pager->setCount($count['cnt']);

        $criteria->append($this->pager->getLimitQuery());
    }

    public function getAllPropertiesTypes()
    {
        return $this->db->getAll('SELECT * FROM `' . $this->tablePropertiesTypes . '`', PDO::FETCH_ASSOC);
    }

    private function getPropertyType($name)
    {
        return $this->db->getRow($qry = 'SELECT `t`.`id`, `t`.`name` FROM `' . $this->tableProperties . '` `p` INNER JOIN `' . $this->tablePropertiesTypes . '` `t` ON `t`.`id` = `p`.`type_id` WHERE `p`.`name` = ' . $this->db->quote($name));
    }

    private function getPropertyTypeByTypeprop($id)
    {
        return $this->db->getOne($qry = 'SELECT `t`.`name` FROM `' . $this->tableTypesProps . '` `tp` INNER JOIN `' . $this->tableProperties . '` `p` ON `tp`.`property_id` = `p`.`id` INNER JOIN `' . $this->tablePropertiesTypes .'` `t` ON `t`.`id` = `p`.`type_id` WHERE `tp`.`id` = ' . (int)$id);
    }

    protected function searchByCriteria(criteria $criteria)
    {
        $keys = $criteria->keys();
        $map = array_keys($this->getMap());

        foreach ($keys as $val) {
            if (!in_array($val, $map)) {
                $criterion = $criteria->getCriterion($val);
                $value = $criterion->getValue();

                $type = $this->getPropertyType($val);

                $criteria->add('p.name', $val)->add('d.' . $type['name'], $value);
                $criteria->remove($val);
            }
        }

        $this->tmpPropsData = array();

        $criteria->addJoin($this->tableTypes, new criterion('t.id', $this->className . '.type_id', criteria::EQUAL, true), 't', criteria::JOIN_INNER);
        $criteria->addJoin($this->tableTypesProps, new criterion('tp.type_id', 't.id', criteria::EQUAL, true), 'tp', criteria::JOIN_INNER);
        $criteria->addJoin($this->tableProperties, new criterion('p.id', 'tp.property_id', criteria::EQUAL, true), 'p', criteria::JOIN_INNER);
        $criterion = new criterion('d.property_type', 'tp.id', criteria::EQUAL, true);
        $criterion->addAnd(new criterion('d.id', $this->className . '.' . $this->tableKey, criteria::EQUAL, true));
        $criteria->addJoin($this->tableData, $criterion, 'd', criteria::JOIN_LEFT);
        $criteria->addGroupBy($this->className . '.' . $this->tableKey);

        $result = parent::searchByCriteria($criteria);

        $properties = clone $criteria;

        $properties->setTable($this->table, $this->className);
        $properties->clearSelectFields();
        $properties->clearGroupBy();
        $properties->addSelectField('d.*')->addSelectField($this->className . '.id', 'id')->addSelectField('p.name')->addSelectField('p.title');
        $properties->setOrderByFieldAsc('id');

        // �������� ��� ����������, � ������� �������� ����� ���������� ������ ������ ��� ����������� ��������
        $properties_needed = clone $properties;
        $properties_needed->setDistinct();
        $properties_needed->clearSelectFields()->addSelectField($this->className . '.' . $this->tableKey);
        $properties->addJoin($properties_needed, new criterion('x.' . $this->tableKey, $this->className . '.' . $this->tableKey, criteria::EQUAL, true), 'x', criteria::JOIN_INNER);

        $properties->clearLimit()->clearOffset();

        $select = new simpleSelect($properties);

        $stmt = $this->db->query($select->toString());

        while ($row = $stmt->fetch()) {
            $type = $this->getPropertyTypeByTypeprop($row['property_type']);
            $this->tmpPropsData[$row['id']][$row['name']] = isset($row[$type]) ? $row[$type] : null;
            $this->tmpServiceData[$row['id']]['titles'][$row['name']] = $row['title'];
            $this->tmpServiceData[$row['id']]['types'][$row['name']] = $type;
        }

        return $result;
    }

    public function createItemFromRow($row)
    {
        $object = $this->create();
        $object->import($row);
        $object->importProperties($this->tmpPropsData[$row[$this->tableKey]]);
        $object->importServiceData($this->tmpServiceData[$row[$this->tableKey]]);
        return $object;
    }

    public function save($object, $user = null)
    {
        parent::save($object, $user);
        $data =& $object->exportProperties();

        $properties = array_keys($data);
        $properties_str = '';
        foreach ($properties as $val) {
            $properties_str .= $this->db->quote($val) . ", ";
        }
        $properties_str = substr($properties_str, 0, -2);

        if ($properties_str) {
            $stmt = $this->db->query("SELECT `tp`.`id`, `p`.`name` FROM `" . $this->tableProperties . "` `p` INNER JOIN `" . $this->tableTypesProps . "` `tp` ON `tp`.`property_id` = `p`.`id` AND `tp`.`type_id` = " . (int)$object->getType() . " WHERE `p`.`name` IN (" . $properties_str . ")");

            $properties = array();
            $result = array();
            $ids = '';
            while ($row = $stmt->fetch()) {
                $properties[$row['name']] = $row['id'];
                $result[$row['name']] = $data[$row['name']];
            }

            if (sizeof($properties)) {
                foreach ($properties as $key => $val) {
                    $type = $this->getPropertyType($key);
                    $this->db->query($qry = 'REPLACE INTO `' . $this->tableData . '` SET `' . $type['name'] . '` = ' . $this->db->quote($data[$key]) . ', `property_type` = ' . $val . ', `id` = ' . $object->getId());
                }

                $object->importProperties($result + $object->exportOldProperties());
            }
        }
    }

    public function delete($id)
    {
        parent::delete($id);
        $stmt = $this->db->prepare('DELETE FROM `' . $this->tableData . '` WHERE `id` = :id');
        $stmt->bindParam('id', $id);
        $stmt->execute();
    }
}

?>