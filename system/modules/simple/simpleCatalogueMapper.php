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
 * simpleCatalogueMapper: маппер
 *
 * @package modules
 * @subpackage simple
 * @version 0.1.3
 */

abstract class simpleCatalogueMapper extends simpleMapper
{
    private $tableData = '';
    private $tableTypes = '';
    private $tableProperties = '';
    private $tableTypesProps = '';

    private $tmpPropsData = array();
    private $tmpTitlesData = array();

    public function __construct($section)
    {
        parent::__construct($section);

        $this->tableData = $this->table . '_data';
        $this->tableTypes = $this->table . '_types';
        $this->tableProperties = $this->table . '_properties';
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
        return $this->db->getRow('SELECT * FROM `' . $this->tableTypes . '` WHERE `id` = ' . (int) $id, PDO::FETCH_ASSOC);
    }
    
    public function getProperty($id)
    {
        return $this->db->getRow('SELECT * FROM `' . $this->tableProperties . '` WHERE `id` = ' . (int) $id, PDO::FETCH_ASSOC);
    }
    
    public function getProperties($id)
    {
        $stmt = $this->db->prepare('SELECT `p`.* FROM `' . $this->tableTypesProps . '` `tp` INNER JOIN `' . $this->tableProperties . '` `p` ON `p`.`id` = `tp`.`property_id` WHERE `tp`.`type_id` = :type_id');
        $stmt->bindParam('type_id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addType($name, $title, Array $properties = array())
    {
        $stmt = $this->db->prepare('INSERT INTO `' . $this->tableTypes . '` VALUES ("", :name, :title)');
        $stmt->bindParam('name', $name);
        $stmt->bindParam('title', $title);
        $type_id = $stmt->execute();
        
        foreach($properties as $id){
            //todo коряво как-то... может всё в один запрос?
            $this->addPropertyToType($type_id, $id);
        }
    }

    public function addPropertyToType($type_id, $prop_id)
    {
        $stmt = $this->db->prepare('INSERT INTO `' . $this->tableTypesProps . '` VALUES ("", :type_id, :prop_id)');
        $stmt->bindParam('type_id', $type_id);
        $stmt->bindParam('prop_id', $prop_id);
        return $stmt->execute();
    }

	public function updateType($type_id, $name, $title, Array $properties = array())
    {
        $stmt = $this->db->prepare('UPDATE `' . $this->tableTypes . '` SET `name` = :name, `title` = :title WHERE `id` = :id');
        $stmt->bindParam('id', $type_id);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('title', $title);
        $stmt->execute();
		
		$stmt = $this->db->prepare('DELETE FROM `' . $this->tableTypesProps . '` WHERE `type_id` = :id');
		$stmt->bindParam('id', $type_id);
		$stmt->execute();
		
		foreach($properties as $id){
            //todo два раза повторяется... надо в отдельный метод?
            $this->addPropertyToType($type_id, $id);
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
    
    public function addProperty($name, $title)
    {
        $stmt = $this->db->prepare('INSERT INTO `' . $this->tableProperties . '` VALUES ("", :name, :title)');
        $stmt->bindParam('name', $name);
        $stmt->bindParam('title', $title);
        return $stmt->execute();
    }
    
    public function updateProperty($id, $name, $title)
    {
        $stmt = $this->db->prepare('UPDATE `' . $this->tableProperties . '` SET `name` = :name, `title` = :title WHERE `id` = :id ');
        $stmt->bindParam('id', $id);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('title', $title);
        return $stmt->execute();
    }
    
    public function deleteProperty($id)
    {
        $stmt = $this->db->prepare('DELETE FROM `' . $this->tableProperties . '` WHERE `id` = :id');
        $stmt->bindParam('id', $id);
        $stmt->execute();
        
        $stmt = $this->db->prepare('DELETE FROM `' . $this->tableTypesProps . '` WHERE `property_id` = :id');
        $stmt->bindParam('id', $id);
        $stmt->execute();
    }
    
    protected function searchByCriteria(criteria $criteria)
    {
        $keys = $criteria->keys();
        $map = array_keys($this->getMap());

        foreach ($keys as $val) {
            if (!in_array($val, $map)) {
                $criterion = $criteria->getCriterion($val);
                $value = $criterion->getValue();
                $criteria->add('p.name', $val)->add('d.value', $value);
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
        $properties->clearSelectFields();
        $properties->clearGroupBy();
        $properties->addSelectField($this->className . '.id')->addSelectField('p.name')->addSelectField('p.title')->addSelectField('d.value');
        $properties->setOrderByFieldAsc('id');

        $select = new simpleSelect($properties);
        $stmt = $this->db->query($select->toString());

        //echo '<br><pre>'; var_dump($select->toString()); echo '<br></pre>';

        $prev_id = 0;

        while ($row = $stmt->fetch()) {
            $this->tmpPropsData[$row['id']][$row['name']] = $row['value'];
            $this->tmpTitlesData[$row['id']][$row['name']] = $row['title'];
        }

        return $result;
    }

    public function createItemFromRow($row)
    {
        $object = $this->create();
        $object->import($row);
        $object->importProperties($this->tmpPropsData[$row[$this->tableKey]]);
        $object->importTitles($this->tmpTitlesData[$row[$this->tableKey]]);
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
                    $this->db->query($qry = 'REPLACE INTO `' . $this->tableData . '` SET `value` = ' . $this->db->quote($data[$key]) . ', `property_type` = ' . $val . ', `id` = ' . $object->getId());
                }

                $object->importProperties($result + $object->exportOldProperties());
            }
        }
    }
}

?>