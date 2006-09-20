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

fileLoader::load('user');
fileLoader::load('user/group');
fileLoader::load('user/mappers/userMapper');

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
     * Постфикс имени таблицы
     *
     * @var string
     */
    //protected $tablePostfix = '_group';

    /**
     * Выполняет поиск объекта по идентификатору
     *
     * @param integer $id идентификатор
     * @return object
     */
    public function searchById($id)
    {
        $stmt = $this->searchByField('id', $id);
        $row = $stmt->fetch();

        if ($row) {
            return $this->createGroupFromRow($row);
        } else {
            // Что это?
            if($id == 1) {
                throw new mzzSystemException('Отсутствует запись с ID: 1 для гостя в таблице ' . $this->table);
            }
            return $this->getGuest();
        }
    }

    /**
     * Выполняет поиск объекта по имени
     *
     * @param string $name имя
     * @return object|false
     */
    public function searchByName($name)
    {
        $stmt = $this->searchByField('name', $name);
        $row = $stmt->fetch();

        if ($row) {
            return $this->createGroupFromRow($row);
        } else {
            return false;
        }
    }

    /**
     * Выполняет поиск объекта (объектов) групп по принадлежности
     * к нему (к ним) пользователю
     *
     * @param string $id идентификатор пользователя
     * @return object|false
     */
    public function searchByUser($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->section() . "_usergroup_rel` `rel` INNER JOIN `" . $this->table . "` `gr` ON `rel`.`group_id` = `gr`.`id` WHERE `rel`.`user_id` = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        $result = array();

        foreach ($rows as $row) {
            $result[] = $this->createGroupFromRow($row);
        }

        return $result;
    }

    public function getUsers($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` `gr` INNER JOIN `" . $this->section() . "_usergroup_rel` `rel` ON `gr`.`id` = `rel`.`group_id` WHERE `gr`.`id` = :id");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll();

        $result = array();

        $userMapper = new userMapper('user');

        foreach ($rows as $row) {
            $result[] = $userMapper->searchById($row['user_id']);
        }

        return $result;
    }

    /**
     * Создает объект group из массива
     *
     * @param array $row
     * @return object
     */
    protected function createGroupFromRow($row)
    {
        $map = $this->getMap();
        $group = new group($map);
        $group->import($row);
        return $group;
    }

}

?>