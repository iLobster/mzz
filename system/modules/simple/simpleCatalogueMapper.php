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
 * @version 0.1.1
 */

abstract class simpleCatalogueMapper extends simpleMapper
{
    private $tableData = '';
    private $tableTypes = '';
    private $tableProperties = '';
    private $tableTypesProps = '';

    private $tmpPropsData = array();

    public function __construct($section)
    {
        parent::__construct($section);

        $this->tableData = $this->table . '_data';
        $this->tableTypes = $this->table . '_types';
        $this->tableProperties = $this->table . '_properties';
        $this->tableTypesProps = $this->table . '_types_props';
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
        $properties->addSelectField($this->className . '.id')->addSelectField('p.name')->addSelectField('d.value');
        $properties->setOrderByFieldAsc('id');

        $select = new simpleSelect($properties);
        $stmt = $this->db->query($select->toString());
        //echo '<br><pre>'; var_dump($select->toString()); echo '<br></pre>';

        $prev_id = 0;

        while ($row = $stmt->fetch()) {
            $this->tmpPropsData[$row['id']][$row['name']] = $row['value'];
        }

        return $result;
    }

    public function createItemFromRow($row)
    {
        $object = $this->create();
        $object->import($row);
        $object->importProperties($this->tmpPropsData[$row[$this->tableKey]]);
        return $object;
    }
}

?>