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

fileLoader::load('catalogue');

/**
 * catalogueMapper: маппер
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueMapper extends simpleCatalogueMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'catalogue';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'catalogue';

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function searchByFolder($folder_id)
    {
        return $this->searchAllByField('folder_id', $folder_id);
    }

    public function get404()
    {
        fileLoader::load('catalogue/controllers/catalogue404Controller');
        return new catalogue404Controller();
    }

    public function convertArgsToObj($args)
    {
        $request = systemToolkit::getInstance()->getRequest();

        $action = $request->getAction();

        if ($action == 'addType' || $action == 'addProperty' || $action == 'adminTypes' || $action == 'adminProperties') {
            return $this->getAccess();
        } elseif ($action == 'editType' || $action == 'deleteType') {
            $type = $this->getType($args['id']);
            if ($type) {
                return $this->getAccess();
            }
        } elseif ($action == 'editProperty' || $action == 'deleteProperty') {
            $property = $this->getProperty($args['id']);
            if ($property) {
                return $this->getAccess();
            }
        } else {
            $item = $this->searchOneByField('id', $args['id']);

            if ($item) {
                return $item;
            }
        }

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