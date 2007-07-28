<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('user/group');

/**
 * groupMapper: маппер для групп пользователей
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
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

    public function convertArgsToObj($args)
    {
        if (sizeof($args) == 0) {
            $toolkit = systemToolkit::getInstance();
            $obj_id = $toolkit->getObjectId($this->section . '_groupFolder');
            $this->register($obj_id);

            $group = $this->create();
            $group->import(array('obj_id' => $obj_id));

            return $group;
        }

        if (isset($args['id']) && $group = $this->searchOneByField('id', $args['id'])) {
            return $group;
        }

        throw new mzzDONotFoundException();
    }

}

?>