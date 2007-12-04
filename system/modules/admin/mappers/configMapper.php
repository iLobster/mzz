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

    private function getObjId()
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