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
 * groupMapper: маппер для групп пользователей
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

fileLoader::load('user/group');

class groupMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'user';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'group';

    /**
     * Выполняет поиск объекта по идентификатору
     *
     * @param integer $id идентификатор
     * @return object
     */
    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    /**
     * Выполняет поиск объекта по имени
     *
     * @param string $name имя
     * @return object|false
     */
    public function searchByName($name)
    {
        return $this->searchOneByField('name', $name);
    }

    public function convertArgsToId($args)
    {
        if (sizeof($args) == 0) {
            $toolkit = systemToolkit::getInstance();
            $obj_id = $toolkit->getObjectId($this->section . '_groupFolder');
            $this->register($obj_id);
            return $obj_id;
        }

        //return 1;
        $group = $this->searchOneByField('id', $args['id']);
        return (int)$group->getObjId();
    }

}

?>