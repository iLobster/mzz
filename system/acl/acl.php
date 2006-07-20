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
     * @var string
     */
    private $section;

    /**
     * тип объекта
     *
     * @var string
     */
    //private $type;

    /**
     * уникальный id объекта
     *
     * @var integer
     */
    private $obj_id;

    /**
     * id пользователя, у которого будут проверяться права
     *
     * @var integer
     */
    private $uid;

    /**
     * массив групп, которым принадлежит пользователь
     *
     * @var array
     */
    private $groups = array();

    /**
     * переменная, для хранения результатов запросов<br>
     * для кеширования в памяти (предотвращение повторных аналогичных запросов)
     *
     * @var array
     */
    private $result = array();

    /**
     * конструктор
     *
     * @param user $user
     * @param integer $object_id
     * @param string_type $module
     * @param string $section
     */
    public function __construct($user = null, $object_id = 0, $module = null, $section = null)
    {
        if (empty($user)) {
            $toolkit = systemToolkit::getInstance();
            $user = $toolkit->getUser();
        }

        if (!($user instanceof user)) {
            throw new mzzInvalidParameterException('Переменная $user не является инстанцией класса user', $user);
        }

        $this->module = $module;
        $this->section = $section;
        //$this->type = $type;
        if (!is_int($object_id)) {
            throw new mzzInvalidParameterException('Переменная object_id не является переменной целочисленного типа', $object_id);
        }
        $this->obj_id = $object_id;
        $this->uid = $user->getId();
        $this->groups = $user->getGroupsList();
    }

    /**
     * метод получения списка прав на выбранный объект у конкретного пользователя<br>
     * объект однозначно идентифицируется совокупностью параметров: section/module/type/obj_id<br>
     * пользователь: uid/groups<br>
     * в результате получаем массив вида:<br>
     * $result[0]['param1'] = 1;<br>
     * $result[0]['param2'] = 0;<br>
     * где param1, param2 - запрашиваемое действие<br>
     * 1/0 - результат. 1 - доступ есть, 0 - доступа нет<br>
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

            $qry = 'SELECT IF(MAX(`a`.`deny`), 0, MAX(`a`.`allow`)) AS `access`, `p`.`name` FROM `sys_access` `a`
                     INNER JOIN `sys_access_modules_sections_properties` `msp` ON `a`.`module_section_property` = `msp`.`id`
                      INNER JOIN `sys_access_properties` `p` ON `msp`.`property_id` = `p`.`id`
                       WHERE `a`.`obj_id` = :obj_id AND (`a`.`uid` = :uid';

            if (sizeof($this->groups)) {
                $qry .= ' OR `a`.`gid` IN (' . $grp . ')';
            }

            $qry .= ')';

            $qry .= ' GROUP BY `a`.`module_section_property`';

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
     * метод для регистрации нового объекта в системе авторизации<br>
     * при регистрации нового объекта для него "наследуются" разрешения в соответствии со следующими правилами:<br>
     * - права безусловно копируются для объекта с аналогичным значением раздела, модуля, типа и имеющим obj_id = 0<br>
     * - права устанавливаются на текущего пользователя как на создателя объекта путём копирования объекта
     *   с аналогичными значениями раздела, модуля, типа и имеющими значение uid = 0
     *
     * @param integer $obj_id уникальный id регистрируемого объекта
     * @param string $module имя модуля
     * @param string $section имя раздела
     */
    public function register($obj_id, $module = null, $section = null)
    {
        $this->obj_id = $obj_id;

        if (!is_int($this->obj_id) || $this->obj_id <= 0) {
            throw new mzzInvalidParameterException('Свойство obj_id должно быть целочисленного типа и иметь значение > 0', $this->obj_id);
        }

        if (!empty($module)) {
            $this->module = $module;
        }

        if (!empty($section)) {
            $this->section = $section;
        }

        if (empty($this->module) || !is_string($this->module)) {
            throw new mzzInvalidParameterException('Свойство $module не установлено или имеет тип, отличный от string', $this->module);
        }

        if (empty($this->section) || !is_string($this->section)) {
            throw new mzzInvalidParameterException('Свойство $section не установлено или имеет тип, отличный от string', $this->section);
        }

        $this->initDb();

        $qry = $this->getQuery();
        $this->doRoutine($qry, $obj_id);
    }

    /**
     * метод удаления объекта из системы авторизации<br>
     * в случае, если аргумент $obj_id не указан, удаляется текущий объект
     *
     * @param integer $obj_id идентификатор удаляемого объекта
     */
    public function delete($obj_id = 0)
    {
        $this->initDb();

        $stmt = $this->db->prepare('DELETE FROM `sys_access` WHERE `obj_id` = :obj_id');

        $this->bind($stmt, $obj_id);

        $stmt->execute();
    }

    /**
     * метод получения запроса для получения объектов с нулевым obj_id
     * эти объекты используются для указания дефолтных значений прав
     *
     * @return string
     * @see acl::register()
     */
    private function getQuery()
    {
        return 'SELECT `a`.* FROM `sys_access_modules_sections` `ms`
                 INNER JOIN `sys_access_modules` `m` ON `ms`.`module_id` = `m`.`id` AND `m`.`name` = :module
                  INNER JOIN `sys_access_sections` `s` ON `ms`.`section_id` = `s`.`id` AND `s`.`name` = :section
                   INNER JOIN `sys_access_modules_sections_properties` `msp` ON `msp`.`module_section_id` = `ms`.`id`
                    INNER JOIN `sys_access_properties` `p` ON `p`.`id` = `msp`.`property_id`
                     INNER JOIN `sys_access` `a` ON `a`.`module_section_property` = `p`.`id` AND `a`.`obj_id` = 0';
    }

    /**
     * метод по созданию стейтмента, передаче в него параметров и выполнения<br>
     * полученные данные передаются далее для выполнения запроса вставки прав в соответствующую таблицу
     *
     * @param string $qry строка запроса
     * @param integer $obj_id уникальный id объекта
     * @see acl::register()
     */
    private function doRoutine($qry, $obj_id)
    {
        $stmt = $this->db->prepare($qry);

        $this->bind($stmt, $obj_id);

        $stmt->execute();

        $this->doInsertQuery($stmt, $obj_id);
    }

    /**
     * метод, осуществляющий вставку в таблицу прав записей прав
     *
     * @param mzzStatement $stmt
     * @param integer $obj_id уникальный id объекта
     * @see acl::doRoutine()
     */
    private function doInsertQuery($stmt, $obj_id)
    {
        $qry = 'INSERT INTO `sys_access` (`module_section_property`, `uid`, `gid`, `allow`, `deny`, `obj_id`) VALUES ';

        $exists = false;
        while($row = $stmt->fetch()) {
            $qry .= "(" . $this->db->quote($row['module_section_property']) . ", "; // . $this->db->quote($row['type']) . ", ";
            if (!$row['uid'] && !$row['gid']) {
                $qry .= $this->db->quote($this->uid) . ', NULL';
            } else {
                $qry .= (($tmp = (int)$row['uid']) > 0 ? $tmp : 'NULL' ). ", " . (($tmp = (int)$row['gid']) > 0 ? $tmp : 'NULL');
            }
            $qry .= ", " . (int)$row['allow'] . ", " . (int)$row['deny'] . ", " . (int)$obj_id . "), ";
            $exists = true;
        }
        $qry = substr($qry, 0, -2);

        if ($exists) {
            $this->db->query($qry);
        }
    }

    /**
     * метод инициализации объекта работы с базой данных<br>
     * запускается при надобности
     *
     * @see acl::get()
     * @see acl::register()
     */
    private function initDb()
    {
        if (empty($this->db)) {
            $this->db = db::factory();
        }
    }

    /**
     * бинд всех переменных в стейтмент
     *
     * @param mzzStatement $stmt
     * @param integer $obj_id
     * @see acl::get()
     * @see acl::doRoutine()
     * @see acl::delete()
     */
    private function bind($stmt, $obj_id = 0)
    {
        $stmt->bindParam(':section', $this->section);
        $stmt->bindParam(':module', $this->module);

        if (!empty($obj_id)) {
            if (!is_int($obj_id) || $obj_id <= 0) {
                throw new mzzInvalidParameterException('Свойство obj_id должно быть целочисленного типа и иметь значение > 0', $this->obj_id);
            }
            $stmt->bindParam(':obj_id', $obj_id);
        } else {
            $stmt->bindParam(':obj_id', $this->obj_id);
        }
        $stmt->bindParam(':uid', $this->uid);
    }
}

?>