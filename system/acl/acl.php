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
 * acl: класс авторизации пользователей
 *
 * @package system
 * @version 0.1
 */
class acl
{
    /**
     * инстанция объекта для работы с БД
     *
     * @var object
     */
    private $db;

    /**
     * имя модуля
     *
     * @var string
     */
    private $module;

    /**
     * имя раздела
     *
     * @var unknown_type
     */
    private $section;

    /**
     * тип объекта
     *
     * @var unknown_type
     */
    private $type;

    /**
     * уникальный id объекта
     *
     * @var integer
     */
    private $obj_id;

    /**
     * id пользователя, у которого будут проверяться права
     *
     * @var unknown_type
     */
    private $uid;

    /**
     * массив групп, которым принадлежит пользователь
     *
     * @var array
     */
    private $groups = array();

    /**
     * переменная, для хранения результатов запросов
     * для кеширования в памяти (предотвращение повторных аналогичных запросов)
     *
     * @var array
     */
    private $result = array();

    /**
     * конструктор
     *
     * @param string $module
     * @param string $section
     * @param string $type
     * @param user $user
     * @param integer $object_id
     */
    public function __construct($module, $section, $type, $user, $object_id = 0)
    {
        $this->module = $module;
        $this->section = $section;
        $this->type = $type;
        $this->obj_id = $object_id;
        $this->uid = $user->getId();
        $this->groups = $user->getGroupsId();
    }

    /**
     * метод получения списка прав на выбранный объект у конкретного пользователя
     * объект однозначно идентифицируется совокупностью параметров: section/module/type/obj_id
     * пользователь: uid/groups
     * в результате получаем массив вида:
     * $result[0]['param1'] = 1;
     * $result[0]['param2'] = 0;
     * где param1, param2 - запрашиваемое действие
     * 1/0 - результат. 1 - доступ есть, 0 - доступа нет
     *
     * @param string|null $param
     * @return array|bool массив с правами | наличие/отсутствие права
     */
    public function get($param = null)
    {
        if (empty($this->result[$this->obj_id])) {
            $this->initDb();

            $grp = '';

            foreach ($this->groups as $val) {
                $grp .= $this->db->quote($val) . ', ';
            }
            $grp = substr($grp, 0, -2);

            $qry = 'SELECT IF(MAX(`a`.`deny`), 0, MAX(`a`.`allow`)) AS `access`, `p`.`name` FROM `sys_access_modules` `m`
            INNER JOIN `sys_access_modules_list` `ml` ON `ml`.`id` = `m`.`module_id` AND `ml`.`name` = :module
            INNER JOIN `sys_access_modules_properties` `mp` ON `m`.`id` = `mp`.`module_id` AND `m`.`section` = :section
            INNER JOIN `sys_access_properties` `p` ON `mp`.`property_id` = `p`.`id`
            INNER JOIN `sys_access` `a` ON `a`.`module_property` = `mp`.`id`  AND `a`.`obj_id` = :obj_id AND `a`.`type` = :type
            WHERE `a`.`uid` = :uid ';
            if (sizeof($this->groups)) {
                $qry .= ' OR `a`.`gid` IN (' . $grp . ')';
            }
            $qry .= ' GROUP BY `a`.`module_property`';

            $stmt = $this->db->prepare($qry);

            $this->bind($stmt);

            $stmt->execute();

            $this->result[$this->obj_id] = array();

            while ($row = $stmt->fetch()) {
                $this->result[$this->obj_id][$row['name']] = $row['access'];
            }
        }

        if (empty($param)) {
            return $this->result[$this->obj_id];
        } else {
            return isset($this->result[$this->obj_id][$param]) ? (bool)$this->result[$this->obj_id][$param] : false;
        }
    }

    /**
     * метод для регистрации нового объекта в системе авторизации
     * при регистрации нового объекта для него "наследуются" разрешения в соответствии со следующими правилами:
     * - права безусловно копируются для объекта с аналогичным значением раздела, модуля, типа и имеющим obj_id = 0
     * - права устанавливаются на текущего пользователя как на создателя объекта путём копирования объекта
     *   с аналогичными значениями раздела, модуля, типа и имеющими значение uid = 0
     *
     * @param integer $obj_id уникальный id регистрируемого объекта
     */
    public function register($obj_id)
    {
        $this->initDb();

        $qry = 'SELECT `a`.* FROM `sys_access_modules` `m`
        INNER JOIN `sys_access_modules_list` `ml` ON `m`.`module_id` = `ml`.`id` AND `ml`.`name` = :module
        INNER JOIN `sys_access_modules_properties` `mp` ON `mp`.`module_id` = `m`.`id`
        INNER JOIN `sys_access` `a` ON `a`.`module_property` = `mp`.`id` AND `a`.`type` = :type AND `a`.`obj_id` = 0
        WHERE `m`.`section` = :section';

        $stmt = $this->db->prepare($qry);

        $this->bind($stmt);

        $stmt->execute();

        $qry = 'INSERT INTO `sys_access` (`module_property`, `type`, `uid`, `gid`, `allow`, `deny`, `obj_id`) VALUES ';

        $exists = false;
        while($row = $stmt->fetch()) {
            $qry .= "(" . $this->db->quote($row['module_property']) . ", " . $this->db->quote($row['type']) . ", " . $this->db->quote($row['uid']) . ", " . $this->db->quote($row['gid']) . ", " . $this->db->quote($row['allow']) . ", " . $this->db->quote($row['deny']) . ", " . $this->db->quote($obj_id) . "), ";
            $exists = true;
        }
        $qry = substr($qry, 0, -2);

        if ($exists) {
            $this->db->query($qry);
        }
    }

    /**
     * метод инициализации объекта работы с базой данных
     * запускается при надобности
     *
     */
    private function initDb()
    {
        if (empty($this->db)) {
            $this->db = db::factory();
        }
    }

    private function bind($stmt)
    {
        $stmt->bindParam(':section', $this->section);
        $stmt->bindParam(':module', $this->module);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':obj_id', $this->obj_id);
        $stmt->bindParam(':uid', $this->uid);
    }
}

?>