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

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
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