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

    protected $users_count = false;

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

    public function getUsersCount(group $group)
    {
        if ($this->users_count === false) {
            $userGroupMapper = systemToolkit::getInstance()->getMapper('user', 'userGroup', $this->section);

            $criteria = new criteria();
            $criteria->addSelectField(new sqlFunction('count', '*', true), $userGroupMapper->getClassName() . simpleMapper::TABLE_KEY_DELIMITER . 'cnt');
            $criteria->addGroupBy('group_id');

            $usersGroups = array();
            foreach ($userGroupMapper->searchAllByCriteria($criteria) as $val) {
                $usersGroups[$val->getGroup()->getId()] = $val->fakeField('cnt');
            }

            $this->users_count = $usersGroups;
        }

        return (isset($this->users_count[$group->getId()]) ? $this->users_count[$group->getId()] : 0);
    }

    public function delete($id)
    {
        if ($id instanceof group) {
            $id = $id->getId();
        } elseif (!is_scalar($id)) {
            throw new mzzRuntimeException('Wrong id or object');
        }

        // исключаем пользователей из этой группы
        $userGroupMapper = systemToolkit::getInstance()->getMapper('user', 'userGroup', $this->section);
        $groups = $userGroupMapper->searchAllByField('group_id', $id);

        foreach ($groups as $val) {
            $userGroupMapper->delete($val->getId());
        }

        parent::delete($id);
    }

    public function convertArgsToObj($args)
    {
        /*
        if (sizeof($args) == 0) {
            $toolkit = systemToolkit::getInstance();
            $obj_id = $toolkit->getObjectId($this->section . '_groupFolder');
            $this->register($obj_id);

            $group = $this->create();
            $group->import(array('obj_id' => $obj_id));

            return $group;
        }
        */

        if (isset($args['id']) && $group = $this->searchByKey($args['id'])) {
            return $group;
        }

        throw new mzzDONotFoundException();
    }

}

?>