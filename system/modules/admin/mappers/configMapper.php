<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('admin/config');

/**
 * configMapper: маппер
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class configMapper extends simpleCatalogueMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'admin';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'config';

    protected $obj_id_field = null;

    public function __construct($section)
    {
        parent::__construct('sys');

        $this->tableData = $this->table . '_data';
        $this->tableTypes = $this->table . '_types';
        $this->tableProperties = $this->table . '_properties';
        $this->tablePropertiesTypes = $this->table . '_properties_types';
        $this->tableTypesProps = $this->table . '_types_props';

        $this->tmptypes = $this->getAllTypes();
    }

    public function searchTypeByName($name)
    {
        $stmt = $this->db->prepare('SELECT * FROM `' . $this->tableTypes . '` WHERE `name` = :name');
        $stmt->bindParam('name', $name);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchBySection($type, $name)
    {
        $criteria = new criteria;
        $criteria->add('type_id', (int)$type)->add('name', $name);

        return $this->searchOneByCriteria($criteria);
    }

    public function getProperties($id)
    {
        if (!isset($this->tmpTypesProps[$id])) {
            $query = 'SELECT `p`.*, `pt`.`name` as `type`, `tp`.`isFull`, `tp`.`isShort`, `tp`.`sort`, NULL as value FROM `' . $this->tableTypesProps . '` `tp` INNER JOIN `' . $this->tableProperties . '` `p` ON `p`.`id` = `tp`.`property_id` INNER JOIN  `' . $this->tablePropertiesTypes . '` `pt` ON `p`.`type_id` = `pt`.`id` WHERE `tp`.`type_id` = :type_id ORDER BY `tp`.`sort` ASC';
            $stmt = $this->db->prepare($query);
            $stmt->bindParam('type_id', $id);
            $stmt->execute();
            $properties_tmp = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $properties = array();
            foreach ($properties_tmp as $props) {
                switch ($props['type']) {
                    case 'select':
                        $props['args'] = unserialize($props['args']);
                        break;
                    case 'dynamicselect':
                        $tmp = unserialize($props['args']);
                        $toolkit = systemToolkit::getInstance();
                        $tmpMapper = $toolkit->getMapper($tmp['module'], $tmp['do'], $tmp['section']);

                        if (!is_callable(array(&$tmpMapper, $tmp['searchMethod']))) {
                            throw new mzzCallbackException(array(&$tmpMapper, $tmp['searchMethod']));
                        }

                        $tmpData = call_user_func_array(array(&$tmpMapper, $tmp['searchMethod']), empty($tmp['params']) ? array() : explode('|', $tmp['params']));
                        $props['args'] = ($tmp['optional']) ? array('' => '') : array();
                        foreach ($tmpData as $tmp_do) {
                            $props['args'][$tmp_do->getId()] = $tmp_do->$tmp['extractMethod']();
                        }
                        break;

                    case 'img':
                        $tmp = unserialize($props['args']);
                        //$tmp = array('section' => 'fileManager', 'folderId' => 1);
                        $toolkit = systemToolkit::getInstance();
                        $tmpMapper = $toolkit->getMapper('fileManager', 'folder', $tmp['section']);

                        if (!is_object($tmpMapper)) {
                            throw new mzzRuntimeException('Не получен маппер для получения каталога изображений');
                        }

                        $tmpData = $tmpMapper->searchByKey($tmp['folderId']);
                        $props['args'] = array();
                        foreach ($tmpData as $tmp_do) {
                            $props['args'][$tmp_do->getId()] = $tmp_do;
                        }
                        break;
                }
                $properties[$props['name']] = $props;
            }
            $this->tmpTypesProps[$id] = $properties;
        }
        return $this->tmpTypesProps[$id];
    }

    public function addProperty($name, $title, $default, $type, $params = array())
    {
        $stmt = $this->db->prepare('INSERT INTO `' . $this->tableProperties . '` (`name`, `title`, `default`, `type_id`, `args`) VALUES (:name, :title, :default, :type, :args)');
        $stmt->bindParam('name', $name);
        $stmt->bindParam('title', $title);
        $stmt->bindParam('type', $type);
        $stmt->bindParam('default', $default);

        $args = isset($params['args']) ? $params['args'] : null;
        $stmt->bindParam('args', $args);

        $propId = $stmt->execute();
        return $propId;
    }

    public function updateProperty($id, $name, $title, $default, $type_id, $params = array())
    {
        $stmt = $this->db->prepare('UPDATE `' . $this->tableProperties . '` SET `name` = :name, `title` = :title, `default` = :default, `type_id` = :type_id, `args` = :args WHERE `id` = :id ');
        $stmt->bindParam('id', $id);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('title', $title);
        $stmt->bindParam('default', $default);
        $stmt->bindParam('type_id', $type_id);
        $args = isset($params['args']) ? $params['args'] : null;
        $stmt->bindParam('args', $args);
        return $stmt->execute();
    }

    protected function updatePropertiesSelection($typeId, Array $properties)
    {
        foreach ($properties as $id => $values) {
            $stmt = $this->db->prepare('UPDATE `' . $this->tableTypesProps . '` SET `sort` = :sort WHERE `type_id` = :type_id AND `property_id` = :prop_id');
            $stmt->bindParam('type_id', $typeId);
            $stmt->bindParam('prop_id', $id, PDO::PARAM_INT);
            $stmt->bindParam('sort', $values['sort'], PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    protected function searchByCriteria(criteria $criteria)
    {
        $keys = $criteria->keys();
        $map = array_keys($this->getMap());

        $keys_to_remove = array();

        foreach ($keys as $val) {
            if (!strpos($val, '.') && !in_array($val, $map)) {
                $criterion = $criteria->getCriterion($val);
                $value = $criterion->getValue();

                $type = $this->getPropertyType($val);

                $criteria->add('p.name', $val)->add('d.' . $type['name'], $value, $criterion->getComparsion());
                $criteria->remove($val);

                $keys_to_remove[] = $type['name'];
            }
        }

        $criteria->addJoin($this->tableTypes, new criterion('t.id', $this->className . '.type_id', criteria::EQUAL, true), 't', criteria::JOIN_LEFT);
        $criteria->addJoin($this->tableTypesProps, new criterion('tp.type_id', 't.id', criteria::EQUAL, true), 'tp', criteria::JOIN_LEFT);
        $criteria->addJoin($this->tableProperties, new criterion('p.id', 'tp.property_id', criteria::EQUAL, true), 'p', criteria::JOIN_LEFT);
        $criterion = new criterion('d.property_type', 'tp.id', criteria::EQUAL, true);
        $criterion->addAnd(new criterion('d.id', $this->className . '.' . $this->tableKey, criteria::EQUAL, true));
        $criteria->addJoin($this->tableData, $criterion, 'd', criteria::JOIN_LEFT);
        $criteria->addGroupBy($this->className . '.' . $this->tableKey);

        $result = parent::searchByCriteria($criteria);

        $properties = clone $criteria;
        $properties->setTable($this->table, $this->className);
        $properties->clearSelectFields();
        $properties->clearGroupBy();
        $properties->addSelectField('d.*')->addSelectField($this->className . '.id', 'id')->addSelectField('p.name')->addSelectField('p.title')->addSelectField('p.args');

        // критерий для подзапроса, с помощью которого будут выбираться данные только для необходимых объектов
        $properties_needed = clone $properties;
        $properties_needed->setDistinct();
        $properties_needed->clearSelectFields()->addSelectField($this->className . '.' . $this->tableKey);
        $properties->addJoin($properties_needed, new criterion('x.' . $this->tableKey, $this->className . '.' . $this->tableKey, criteria::EQUAL, true), 'x', criteria::JOIN_INNER);
        $properties->clearLimit()->clearOffset();

        $properties->remove('p.name');
        foreach ($keys_to_remove as $key) {
            $properties->remove('d.' . $key);
        }

        $select = new simpleSelect($properties);
        $stmt = $this->db->query($select->toString());

        while ($row = $stmt->fetch()) {
            if ($row['property_type']) {
                $type_title = $this->getPropertyTypeByTypeprop($row['property_type']);
                $type = $this->prepareType($type_title);

                if (isset($row[$type])) {
                    switch ($type_title) {
                        case 'img':
                            $tmp_value = (array)unserialize($row[$type]);
                            $tmp = unserialize($row['args']);
                            $toolkit = systemToolkit::getInstance();
                            $tmpMapper = $toolkit->getMapper('fileManager', 'file', $tmp['section']);

                            if (!is_object($tmpMapper)) {
                                throw new mzzRuntimeException('Не получен маппер для получения изображений');
                            }

                            $images = array();
                            foreach ($tmp_value as $img_id) {
                                $images[] = $tmpMapper->searchById($img_id);
                            }
                            $row[$type] = $images;
                            break;
                    }
                }

                $property[$row['name']] = (isset($row[$type]) ? $row[$type] : null);
                $this->tmpPropsData[$row[$this->tableKey]] = $property;
            }
        }
        return $result;
    }

    /**
     * Возвращает доменный объект по аргументам
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        return $this->getAccess();
        throw new mzzDONotFoundException();
    }

    public function getObjId()
    {
        $toolkit = systemToolkit::getInstance();
        $obj_id = $toolkit->getObjectId($this->section . '_catalogue');
        $this->register($obj_id);
        return $obj_id;
    }

    private function getAccess()
    {
        $obj = $this->create();
        $obj->import(array('obj_id' => $this->getObjId()));
        return $obj;
    }
}

?>