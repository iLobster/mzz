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
 * @package user
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
    protected $tablePostfix = '_group';

    /**
     * Конструктор
     *
     * @param string $section секция
     */
    public function __construct($section)
    {
        parent::__construct($section);
        $this->relationTable = $this->table . '_rel';
    }

    /**
     * Выполняет поиск объекта по идентификатору
     *
     * @param integer $id идентификатор
     * @return object
     */
    public function searchById($id)
    {
        $row = $this->searchOneByField('id', $id);
        /*var_dump($stmt);
        $row = $stmt->fetch();*/

        if ($row) {
            //return $this->createItemFromRow($row);
            return $row;
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
        return $this->searchOneByField('name', $name);
        /*$stmt = $this->searchByField('name', $name);
        $row = $stmt->fetch();

        if ($row) {
            return $this->createGroupFromRow($row);
        } else {
            return false;
        }*/
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
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->relationTable . "` `rel` INNER JOIN `" . $this->table . "` `gr` ON `rel`.`group_id` = `gr`.`id` WHERE `rel`.`user_id` = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        $result = array();

        foreach ($rows as $row) {
            $row = array(0 => array('group' => $row));
            $result[] = $this->createItemFromRow($row);
        }

        return $result;
    }

    public function getUsers($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `" . $this->table . "` `gr` INNER JOIN `" . $this->table . "_rel` `rel` ON `gr`.`id` = `rel`.`group_id` WHERE `gr`.`id` = :id");
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
     *//*
    protected function createItemFromRow($row)
    {
        $map = $this->getMap();
        $group = new group($map);

        $f = array();
        foreach ($row as $key => $val) {
            $f[$this->className][str_replace($this->className . '_', '', $key)] = $val;
        }
var_dump($row);
        $group->import($f[$this->className]);
        return $group;
    }*/

}

?>