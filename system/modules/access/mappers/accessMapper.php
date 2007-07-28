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

/**
 * accessMapper: маппер
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */

fileLoader::load('access');

class accessMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'access';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'access';

    public function __construct($section)
    {
        parent::__construct($section);
        $this->table = 'sys_access';
    }

    public function searchByObjId($obj_id)
    {
        return $this->searchAllByField('obj_id', $obj_id);
    }

    public function convertArgsToObj($args)
    {
        $access = $this->create();

        if (isset($args['section_name']) && isset($args['class_name'])) {
            $toolkit = systemToolkit::getInstance();
            $obj_id = $toolkit->getObjectId('access_' . $args['section_name'] . '_' . $args['class_name']);
            $this->register($obj_id, 'sys', 'access');

            $access->import(array('obj_id' => $obj_id));
            return $access;
        }

        if (isset($args['id'])) {
            $access->import(array('obj_id' => $args['id']));
            return $access;
        }

        throw new mzzDONotFoundException();
    }
}

?>